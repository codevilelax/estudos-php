<?php

// Tudo que fala com a IA (Groq) fica neste arquivo.
// A chave só é lida aqui, no servidor: o navegador nunca vê a chave.

require_once __DIR__ . "/curso.php";

const URL_IA = "https://api.groq.com/openai/v1";

// A conta gratuita tem um limite por minuto para cada modelo. O primeiro da lista
// é o principal. Os outros são reservas, para quando ele pede pausa.
const MODELOS_DE_CONVERSA = ["openai/gpt-oss-120b", "openai/gpt-oss-20b"];
const MODELOS_DE_OUVIDO = ["whisper-large-v3-turbo", "whisper-large-v3"];

// Até quantos segundos vale a pena esperar o modelo principal antes de ir para a reserva.
const ESPERA_MAXIMA = 10;

// Quantas falas antigas vão junto em cada pedido. Quanto mais falas, mais rápido
// o limite por minuto acaba.
const FALAS_LEMBRADAS = 8;

// Quantas vezes o aluno pratica depois de aprender todos os itens da lição.
const PRATICAS_POR_LICAO = 3;

// Quem é a professora e como ela responde. Vale para as lições e para a conversa livre.
// Estes textos vão em todo pedido, então cada palavra a mais gasta o limite por minuto.
const INSTRUCOES = <<<'TEXTO'
You are Emma, a warm, patient English teacher for a Brazilian student. You talk by voice, so everything you write is read aloud: keep it short and natural, with no lists, emojis or markdown.

The student's messages come from speech recognition: never correct punctuation, capitalization or spelling, and guess the meaning of strange words.

Answer with one JSON object:
- "correcao": if the student's last message was an attempt at English with a mistake (grammar, a wrong word, or not the phrase you asked for), the correct English. Otherwise "".
- "explicacao": if there is a "correcao", one short sentence in Brazilian Portuguese explaining the mistake, calling the student "você". Otherwise "".
- "acertou": true only if the last message was in English with no mistakes.
- "falas": what you say now: 1 to 4 short parts, in order, each {"idioma": "pt" or "en", "texto"}. Each language has its own voice: no English words inside a "pt" part, no Portuguese inside an "en" part. An English word or phrase always goes in its own "en" part.
- "traducao": Brazilian Portuguese translation of the "en" parts.
TEXTO;

// Como dar uma lição. As partes entre chaves são trocadas pelos dados da lição.
const INSTRUCOES_DA_LICAO = <<<'TEXTO'
Lesson {numero}: "{titulo}". Goal: {objetivo}
Items, in order:
{itens}
Language rule: {idioma}

"fase" starts as "ensinar": teach ONE item per turn, in order. "passo" is the number of the item you are teaching in this turn.
- Say the item ("en" part), its meaning in Portuguese, then what the student must do: repeat it or answer with it. If the item has "...", give one example and ask for the student's own version.
- Right answer: short praise, then the next item in the same turn.
- Wrong answer: show the right way and ask again with the same "passo". After two wrong tries, encourage and go on.

After the student says the last item, "fase" becomes "praticar": say you will practise now. Then, one per turn, describe a small everyday situation or ask a question that makes the student use an item (for example: "É de manhã e você encontra um amigo. O que você fala?"). Never give the answer: in "praticar" your "falas" have no "en" part with the expected answer. Now "passo" counts how many the student has answered correctly, going up one at a time. When it reaches {praticas}, set "concluida" to true, congratulate warmly, say in one sentence what the student can do now, and ask nothing. Otherwise "concluida" is false.

Always: end by telling the student exactly what to do next. In the first turn, greet, say in one sentence what today's lesson is, and teach item 1. If the student asks something in Portuguese, answer briefly and return to the lesson. Sound like a friendly young Brazilian: informal Portuguese, varied praise ("Boa!", "Isso aí!", "Perfeito!", "Mandou bem!").

Example of "falas" in a beginner teaching turn: [{"idioma":"pt","texto":"Boa! A próxima é:"},{"idioma":"en","texto":"Good morning."},{"idioma":"pt","texto":"Quer dizer bom dia. Agora repete pra mim."}]

Now: "fase" is "{fase}", "passo" is {passo}.
TEXTO;

const INSTRUCOES_DA_CONVERSA_LIVRE = <<<'TEXTO'
This is free conversation practice, with no lesson plan.
Speak only English: one or two short sentences with simple everyday words, usually ending with a question that keeps the conversation going. Do not repeat the correction in "falas".
If the student speaks Portuguese or asks how to say something, teach the English for it and invite them to try saying it.
Always use "praticar" for "fase", 0 for "passo" and false for "concluida".
TEXTO;

// O formato exato da resposta. A IA é obrigada a seguir.
const FORMATO_DA_RESPOSTA = [
    "type" => "json_schema",
    "json_schema" => [
        "name" => "fala_da_professora",
        "strict" => true,
        "schema" => [
            "type" => "object",
            "properties" => [
                "correcao" => ["type" => "string"],
                "explicacao" => ["type" => "string"],
                "acertou" => ["type" => "boolean"],
                "falas" => [
                    "type" => "array",
                    "items" => [
                        "type" => "object",
                        "properties" => [
                            "idioma" => ["type" => "string", "enum" => ["pt", "en"]],
                            "texto" => ["type" => "string"],
                        ],
                        "required" => ["idioma", "texto"],
                        "additionalProperties" => false,
                    ],
                ],
                "traducao" => ["type" => "string"],
                "fase" => ["type" => "string", "enum" => ["ensinar", "praticar"]],
                "passo" => ["type" => "integer"],
                "concluida" => ["type" => "boolean"],
            ],
            "required" => ["correcao", "explicacao", "acertou", "falas", "traducao", "fase", "passo", "concluida"],
            "additionalProperties" => false,
        ],
    ],
];

// Erro com uma mensagem pronta para aparecer na tela.
class ErroIA extends Exception
{
    public $codigoHttp = 0;
    public $espera = 0; // segundos até poder tentar de novo
}

function lerChave()
{
    $arquivo = __DIR__ . "/../chave.txt";
    $chave = is_file($arquivo) ? trim(file_get_contents($arquivo)) : "";

    if ($chave === "") {
        throw new ErroIA("Não achei a chave da IA. Ela fica no arquivo chave.txt, na pasta do projeto.");
    }

    return $chave;
}

// Manda um pedido para a IA e devolve a resposta já como array.
// $comoJson: true manda o corpo como JSON, false manda como formulário (para arquivos).
function pedirIA($caminho, $corpo, $comoJson)
{
    $cabecalhos = ["Authorization: Bearer " . lerChave()];
    if ($comoJson) {
        $cabecalhos[] = "Content-Type: application/json";
        $corpo = json_encode($corpo);
    }

    $espera = 0;
    $ch = curl_init(URL_IA . $caminho);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $corpo,
        CURLOPT_HTTPHEADER => $cabecalhos,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 45,
        CURLOPT_HEADERFUNCTION => function ($ch, $linha) use (&$espera) {
            if (stripos($linha, "retry-after:") === 0) {
                $espera = (int) ceil((float) trim(substr($linha, 12)));
            }
            return strlen($linha);
        },
    ]);
    $resposta = curl_exec($ch);
    $codigo = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($resposta === false) {
        throw new ErroIA("Não consegui falar com a IA. Confira a internet e tente de novo.");
    }

    $dados = json_decode($resposta, true);

    if ($codigo >= 400 || !is_array($dados)) {
        if ($codigo == 429) {
            $erro = new ErroIA("A IA pediu uma pausa. Espere alguns segundos e tente de novo.");
            $erro->espera = max($espera, 1);
        } elseif ($codigo == 401) {
            $erro = new ErroIA("A IA não aceitou a chave. Confira o arquivo chave.txt.");
        } else {
            error_log("Erro da IA ($codigo): " . substr($resposta, 0, 300));
            $erro = new ErroIA("A IA respondeu com um erro (código $codigo). Tente de novo.");
        }
        $erro->codigoHttp = $codigo;
        throw $erro;
    }

    return $dados;
}

// Faz o pedido com o modelo principal (o primeiro da lista). Se ele pedir pausa
// por causa do limite por minuto:
// 1. quando a pausa é curta, espera e tenta de novo, porque ele é o melhor;
// 2. se ainda não der, tenta os modelos de reserva.
// Só dá erro de pausa se nenhum responder.
function pedirComReserva($caminho, $corpo, $comoJson, $modelos)
{
    $corpo["model"] = $modelos[0];

    try {
        return pedirIA($caminho, $corpo, $comoJson);
    } catch (ErroIA $erro) {
        if ($erro->codigoHttp != 429) {
            throw $erro;
        }
        $pausa = $erro;
    }

    if ($pausa->espera <= ESPERA_MAXIMA) {
        sleep($pausa->espera);
        try {
            return pedirIA($caminho, $corpo, $comoJson);
        } catch (ErroIA $erro) {
            if ($erro->codigoHttp != 429) {
                throw $erro;
            }
            $pausa = $erro;
        }
    }

    foreach (array_slice($modelos, 1) as $reserva) {
        $corpo["model"] = $reserva;
        try {
            return pedirIA($caminho, $corpo, $comoJson);
        } catch (ErroIA $erro) {
            // A reserva também falhou: vale o pedido de pausa do modelo principal.
        }
    }

    throw $pausa;
}

// Transforma um áudio em texto, em inglês ou português. Devolve "" quando não tem fala.
function ouvir($arquivo, $tipo, $nome, $idioma = null)
{
    $campos = [
        "file" => new CURLFile($arquivo, $tipo, $nome),
        "response_format" => "verbose_json",
        "temperature" => "0",
    ];
    if ($idioma) {
        $campos["language"] = $idioma;
    }

    $dados = pedirComReserva("/audio/transcriptions", $campos, false, MODELOS_DE_OUVIDO);

    // Sem idioma definido, a IA descobre sozinha se é inglês ou português.
    // Se ela achar que é outra língua, entendeu errado: tenta de novo como inglês.
    $descoberto = strtolower($dados["language"] ?? "");
    if (!$idioma && $descoberto != "" && !in_array($descoberto, ["english", "portuguese", "en", "pt"])) {
        return ouvir($arquivo, $tipo, $nome, "en");
    }

    // Em silêncio ou barulho, a IA às vezes inventa uma frase ("Thank you.").
    // Cada trecho vem com a chance de não ser fala: se todos forem duvidosos, descarta.
    $trechos = $dados["segments"] ?? [];
    $temFala = count($trechos) == 0;
    foreach ($trechos as $trecho) {
        if (($trecho["no_speech_prob"] ?? 0) < 0.6) {
            $temFala = true;
        }
    }

    return $temFala ? trim($dados["text"] ?? "") : "";
}

// Deixa o texto só com letras e números, para comparar duas frases
// sem ligar para maiúsculas e pontuação.
function simplificar($texto)
{
    return preg_replace('/[^a-z0-9]+/', "", strtolower($texto));
}

// Em que vez do aluno a lição pode acabar, no mínimo:
// uma vez para cada item, mais as vezes de praticar.
function turnoMinimo($licao)
{
    return count($licao["itens"]) + PRATICAS_POR_LICAO;
}

// Quanto da lição já foi feito, de 0 a 100. Ensinar os itens vale 70, praticar vale 30.
function calcularProgresso($licao, $fase, $passo)
{
    if ($fase == "praticar") {
        return 70 + (int) round(30 * min($passo, PRATICAS_POR_LICAO) / PRATICAS_POR_LICAO);
    }

    $total = count($licao["itens"]);
    $itensFeitos = max(0, min($passo, $total) - 1);
    return (int) round(70 * $itensFeitos / $total);
}

// A professora às vezes cita uma frase em inglês no meio de uma fala em português
// (ex: Repita "Good morning"). A voz em português leria o inglês com sotaque,
// então esse trecho entre aspas vira uma parte separada, em inglês.
function separarIngles($falas, $licao)
{
    // Frases que com certeza são inglês: as partes em inglês desta fala e os itens da lição.
    $conhecidas = [];
    foreach ($falas as $parte) {
        if ($parte["idioma"] == "en") {
            $conhecidas[] = simplificar($parte["texto"]);
        }
    }
    foreach ($licao === null ? [] : $licao["itens"] as $item) {
        $conhecidas[] = simplificar($item);
        foreach (preg_split('/[\/()]|\.\.\./', $item) as $pedaco) {
            $conhecidas[] = simplificar($pedaco);
        }
    }

    $ehIngles = function ($trecho) use ($conhecidas) {
        $trecho = simplificar($trecho);
        foreach ($conhecidas as $frase) {
            // Igual a uma frase conhecida, ou começa com ela (ex: "My name is Ana").
            if (strlen($frase) >= 2 && ($trecho == $frase || (strlen($frase) >= 6 && strpos($trecho, $frase) === 0))) {
                return true;
            }
        }
        return false;
    };

    $temLetra = function ($texto) {
        return preg_match('/\pL/u', $texto) == 1;
    };

    $novas = [];
    foreach ($falas as $parte) {
        // Corta nas aspas: os pedaços de posição ímpar são os que estavam entre aspas.
        $pedacos = preg_split('/["“”]/u', $parte["texto"]);
        if ($parte["idioma"] != "pt" || count($pedacos) % 2 == 0) {
            $novas[] = $parte;
            continue;
        }

        $portugues = "";
        $depoisDoIngles = false;
        foreach ($pedacos as $posicao => $pedaco) {
            if ($posicao % 2 == 0) {
                // Logo depois de um trecho em inglês, sobra a pontuação que vinha colada nas aspas.
                $portugues .= $depoisDoIngles ? ltrim($pedaco, " .,;:!?") : $pedaco;
                $depoisDoIngles = false;
            } elseif ($ehIngles($pedaco)) {
                if ($temLetra($portugues)) {
                    $novas[] = ["idioma" => "pt", "texto" => trim($portugues)];
                }
                $novas[] = ["idioma" => "en", "texto" => trim($pedaco)];
                $portugues = "";
                $depoisDoIngles = true;
            } else {
                $portugues .= '"' . $pedaco . '"';
            }
        }
        if ($temLetra($portugues)) {
            $novas[] = ["idioma" => "pt", "texto" => trim($portugues)];
        }
    }

    return $novas;
}

// Monta o roteiro completo: quem é a professora + a lição (ou a conversa livre).
function montarInstrucoes($licao, $ponto)
{
    if ($licao === null) {
        return INSTRUCOES . "\n\n" . INSTRUCOES_DA_CONVERSA_LIVRE;
    }

    $itens = "";
    foreach ($licao["itens"] as $numero => $item) {
        $itens .= ($numero + 1) . ". " . $item . "\n";
    }

    $daLicao = strtr(INSTRUCOES_DA_LICAO, [
        "{numero}" => $licao["id"],
        "{titulo}" => $licao["titulo"],
        "{objetivo}" => $licao["objetivo"],
        "{itens}" => trim($itens),
        "{idioma}" => NIVEIS[$licao["nivel"]]["idioma"],
        "{praticas}" => PRATICAS_POR_LICAO,
        "{fase}" => $ponto["fase"],
        "{passo}" => $ponto["passo"],
    ]);

    return INSTRUCOES . "\n\n" . $daLicao;
}

// Manda a fala do aluno (com as falas anteriores) e devolve o que a professora responde.
// $licao: a lição (do curso.php) ou null para conversa livre.
// $historico: lista de ["papel" => "ia" ou "voce", "texto" => "..."]
// $fala: o que o aluno disse, ou null para a professora abrir a lição.
// $ponto: onde a lição está: ["fase" => "ensinar" ou "praticar", "passo" => número,
//         "turno" => quantas vezes o aluno já falou, contando com esta]
function conversar($licao, $historico, $fala, $ponto)
{
    $mensagens = [["role" => "system", "content" => montarInstrucoes($licao, $ponto)]];
    foreach (array_slice($historico, -FALAS_LEMBRADAS) as $item) {
        $mensagens[] = [
            "role" => $item["papel"] == "ia" ? "assistant" : "user",
            "content" => $item["texto"],
        ];
    }
    $mensagens[] = [
        "role" => "user",
        "content" => $fala === null ? "(The lesson starts now. The student has not said anything yet.)" : $fala,
    ];

    $pedido = [
        "messages" => $mensagens,
        "temperature" => 0.6,
        "max_completion_tokens" => 1000,
        "reasoning_effort" => "low",
        "response_format" => FORMATO_DA_RESPOSTA,
    ];

    try {
        $dados = pedirComReserva("/chat/completions", $pedido, true, MODELOS_DE_CONVERSA);
    } catch (ErroIA $erro) {
        if ($erro->codigoHttp != 400) {
            throw $erro;
        }
        // A IA não conseguiu seguir o formato exato: tenta de novo com o formato mais solto.
        $pedido["response_format"] = ["type" => "json_object"];
        $dados = pedirComReserva("/chat/completions", $pedido, true, MODELOS_DE_CONVERSA);
    }

    $texto = trim($dados["choices"][0]["message"]["content"] ?? "");
    $partes = json_decode($texto, true);
    if (!is_array($partes)) {
        $partes = ["falas" => [["idioma" => "en", "texto" => $texto]]];
    }

    // Confere cada pedaço da resposta, porque a tela depende deste formato.
    $falas = [];
    $temPortugues = false;
    foreach (is_array($partes["falas"] ?? null) ? $partes["falas"] : [] as $parte) {
        $textoDaParte = is_array($parte) && is_string($parte["texto"] ?? null) ? trim($parte["texto"]) : "";
        if ($textoDaParte !== "") {
            $idioma = ($parte["idioma"] ?? "") == "pt" ? "pt" : "en";
            $falas[] = ["idioma" => $idioma, "texto" => $textoDaParte];
            $temPortugues = $temPortugues || $idioma == "pt";
        }
    }
    if (count($falas) == 0) {
        throw new ErroIA("A IA não respondeu direito. Tente de novo.");
    }

    $resultado = ["falas" => separarIngles($falas, $licao)];
    foreach (["correcao", "explicacao", "traducao"] as $campo) {
        $resultado[$campo] = is_string($partes[$campo] ?? null) ? trim($partes[$campo]) : "";
    }

    // Quando a professora já falou em português, a tradução seria repetição.
    if ($temPortugues) {
        $resultado["traducao"] = "";
    }

    // Se a "correção" é a mesma frase (só muda pontuação ou maiúscula), não é correção.
    if ($fala === null || simplificar($resultado["correcao"]) == simplificar($fala)) {
        $resultado["correcao"] = "";
    }
    if ($resultado["correcao"] === "") {
        $resultado["explicacao"] = "";
    }
    $resultado["acertou"] = $fala !== null && $resultado["correcao"] === "" && ($partes["acertou"] ?? false) === true;

    // Conversa livre não tem fases, progresso nem fim.
    if ($licao === null) {
        return $resultado + ["fase" => "praticar", "passo" => 0, "progresso" => 0, "concluida" => false];
    }

    // A lição só anda para a frente: não volta de fase nem de passo.
    $fase = ($partes["fase"] ?? "") == "praticar" || $ponto["fase"] == "praticar" ? "praticar" : "ensinar";
    $passo = max(0, min(50, (int) ($partes["passo"] ?? 0)));
    if ($fase == $ponto["fase"]) {
        $passo = max($passo, $ponto["passo"]);
    }

    // A lição só acaba na fase de praticar e depois de o aluno ter falado o mínimo
    // de vezes, mesmo que a IA queira encerrar antes.
    $concluida = ($partes["concluida"] ?? false) === true
        && $fase == "praticar"
        && $ponto["turno"] >= turnoMinimo($licao);

    $progresso = $concluida ? 100 : min(95, calcularProgresso($licao, $fase, $passo));

    return $resultado + ["fase" => $fase, "passo" => $passo, "progresso" => $progresso, "concluida" => $concluida];
}
