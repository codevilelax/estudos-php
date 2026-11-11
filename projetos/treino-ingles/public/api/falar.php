<?php

// Recebe uma fala (áudio gravado ou texto digitado) junto com as falas anteriores
// e devolve, em JSON, o que foi entendido, a correção e a resposta da professora.
//
// O que chega (POST):
// - licao:     número da lição, ou "livre" para conversa livre
// - fase e passo: onde a lição está (o servidor devolve, a tela manda de volta)
// - turno:     quantas vezes o aluno já falou nesta lição, contando com esta
// - historico: as falas anteriores, em JSON
// - comecar=1: a professora abre a lição (não vem fala do aluno)
// - audio ou texto: a fala do aluno

require __DIR__ . "/../../src/ia.php";

ini_set("display_errors", 0);
header("Content-Type: application/json; charset=utf-8");
header("Cache-Control: no-store");

function responder($dados)
{
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit;
}

// Confere o histórico que veio do navegador e fica só com o que é válido.
function lerHistorico($json)
{
    $lista = json_decode($json, true);
    $historico = [];

    if (is_array($lista)) {
        foreach ($lista as $item) {
            $papel = $item["papel"] ?? "";
            $texto = $item["texto"] ?? "";
            if (($papel == "ia" || $papel == "voce") && is_string($texto) && trim($texto) !== "") {
                $historico[] = ["papel" => $papel, "texto" => mb_substr(trim($texto), 0, 1000)];
            }
        }
    }

    return $historico;
}

// O serviço de transcrição descobre o formato pelo nome do arquivo.
function nomeDoAudio($tipo)
{
    foreach (["webm" => "webm", "ogg" => "ogg", "mp4" => "m4a", "m4a" => "m4a", "wav" => "wav", "mpeg" => "mp3"] as $pedaco => $extensao) {
        if (strpos($tipo, $pedaco) !== false) {
            return "fala." . $extensao;
        }
    }
    return "fala.webm";
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    responder(["ok" => false, "erro" => "Esta página só aceita envio de fala."]);
}

try {
    $historico = lerHistorico($_POST["historico"] ?? "[]");
    $licao = null;
    $pedida = $_POST["licao"] ?? "livre";
    if ($pedida != "livre") {
        $licao = acharLicao((int) $pedida);
        if ($licao === null) {
            throw new ErroIA("Não achei essa lição.");
        }
    }

    if (isset($_POST["comecar"])) {
        if ($licao === null) {
            throw new ErroIA("A conversa livre começa sozinha.");
        }
        $fala = null;
    } elseif (isset($_FILES["audio"])) {
        $audio = $_FILES["audio"];

        if ($audio["error"] == UPLOAD_ERR_INI_SIZE || $audio["error"] == UPLOAD_ERR_FORM_SIZE) {
            throw new ErroIA("A gravação ficou grande demais. Fale por menos tempo.");
        }
        if ($audio["error"] != UPLOAD_ERR_OK || $audio["size"] == 0) {
            throw new ErroIA("A gravação não chegou. Tente de novo.");
        }

        // O tipo chega como "audio/webm;codecs=opus": fica só a primeira parte.
        $tipo = trim(explode(";", $audio["type"])[0]);

        $fala = ouvir($audio["tmp_name"], $tipo, nomeDoAudio($tipo));
        if ($fala === "") {
            throw new ErroIA("Não ouvi nada. Fale mais perto do microfone e tente de novo.");
        }
    } else {
        $fala = mb_substr(trim($_POST["texto"] ?? ""), 0, 500);
        if ($fala === "") {
            throw new ErroIA("Escreva alguma coisa antes de enviar.");
        }
    }

    // Onde a lição está. Na abertura, começa do zero.
    $ponto = ["fase" => "ensinar", "passo" => 1, "turno" => 0];
    if ($fala !== null) {
        $ponto = [
            "fase" => ($_POST["fase"] ?? "") == "praticar" ? "praticar" : "ensinar",
            "passo" => max(0, min(50, (int) ($_POST["passo"] ?? 1))),
            "turno" => max(1, (int) ($_POST["turno"] ?? 1)),
        ];
    }

    $resultado = conversar($licao, $historico, $fala, $ponto);

    responder(["ok" => true, "voce" => $fala] + $resultado);
} catch (ErroIA $erro) {
    responder(["ok" => false, "erro" => $erro->getMessage(), "espera" => $erro->espera]);
} catch (Throwable $erro) {
    error_log("Erro no falar.php: " . $erro->getMessage());
    responder(["ok" => false, "erro" => "Deu um erro no servidor. Tente de novo."]);
}
