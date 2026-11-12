// Roda DEPOIS do app.js: usa a tela como uma pessoa usaria (clica, digita, grava),
// confere o que aparece e manda o resultado para o roteador guardar em arquivo.
(function () {
    const T = window.__teste;
    const $ = (seletor) => document.querySelector(seletor);
    const $$ = (seletor) => Array.from(document.querySelectorAll(seletor));
    const espera = (ms) => new Promise((resolver) => setTimeout(resolver, ms));
    const estado = () => document.body.dataset.estado;
    const guardado = () => JSON.parse(localStorage.getItem("treino-ingles-v2") || "null");
    const visivel = (elemento) => Boolean(elemento) && getComputedStyle(elemento).display !== "none" && !elemento.closest("[hidden]");

    async function ate(condicao, limite, descricao) {
        const inicio = Date.now();
        while (!condicao()) {
            if (Date.now() - inicio > (limite || 15000)) {
                throw new Error("tempo esgotado esperando: " + (descricao || condicao));
            }
            await espera(50);
        }
    }

    function conferir(descricao, passou, detalhe) {
        T.conferencias.push({ ok: Boolean(passou), descricao, detalhe: detalhe === undefined ? undefined : detalhe });
    }

    function igual(descricao, obtido, esperado) {
        conferir(descricao, JSON.stringify(obtido) === JSON.stringify(esperado), { obtido, esperado });
    }

    // Anota o jeito e a boca da Emma o tempo todo.
    setInterval(() => {
        const desenho = $("#emma-da-aula .emma");
        if (!desenho || $("#tela-aula").hidden) {
            return;
        }
        const chave = $("#palco").dataset.modo + ":" + desenho.dataset.boca;
        T.emmaVisto[chave] = (T.emmaVisto[chave] || 0) + 1;
    }, 40);

    function situacoes() {
        const contagem = { feita: 0, aberta: 0, fechada: 0 };
        for (const linha of $$(".licao")) {
            contagem[linha.dataset.situacao]++;
        }
        return contagem;
    }

    const linhaDaLicao = (posicao) => $$(".licao")[posicao - 1];
    const pedidosDeFala = () => T.pedidos.filter((pedido) => pedido.url.includes("api/falar.php"));
    const ultimoPedido = () => pedidosDeFala().slice(-1)[0];
    const faladoDesde = (inicio) => T.falado.slice(inicio).filter((item) => !item.cancelou);

    async function trilhaPronta() {
        await ate(() => !$("#continuar").hidden, 15000, "a trilha carregar");
    }

    async function respostaChegar(limite) {
        await ate(() => estado() !== "pensando", limite || 120000, "a resposta chegar");
    }

    async function digitar(texto, limite) {
        if ($("#digitar").hidden) {
            $("#teclado").click();
        }
        $("#texto").value = texto;
        $("#digitar").requestSubmit();
        await respostaChegar(limite);
    }

    // ---------- Cenários com respostas de mentira (não gastam a IA) ----------

    const cenarios = {};

    cenarios.trilha = async function () {
        await trilhaPronta();
        igual("são 24 lições + conversa livre", $$(".licao").length, 25);
        igual("5 blocos (4 níveis + sem roteiro)", $$(".nivel").length, 5);
        igual("no começo só a lição 1 e a conversa livre abrem", situacoes(), { feita: 0, aberta: 2, fechada: 23 });
        igual("destaque do começo", $("#destaque-titulo").textContent, "Vamos começar do zero?");
        igual("botão do destaque", $("#continuar").textContent, "Começar lição 1");
        conferir("lição fechada não clica", linhaDaLicao(2).disabled && !linhaDaLicao(1).disabled);
        igual("a Emma foi desenhada nos dois lugares", $$(".retrato .emma").length, 2);
        conferir("a tela da aula começa escondida", $("#tela-aula").hidden && !$("#tela-trilha").hidden);
        T.niveis = $$(".nivel h3").map((titulo) => titulo.textContent);
        T.primeiraLinha = linhaDaLicao(1).textContent;
    };

    cenarios["sem-servidor"] = async function () {
        await ate(() => $("#destaque-titulo").textContent !== "Carregando as lições…", 5000, "o aviso de erro");
        igual("avisa quando o servidor está desligado", $("#destaque-titulo").textContent, "Não consegui carregar as lições");
        conferir("sem botão de começar", $("#continuar").hidden);
    };

    cenarios.estragado = async function () {
        await trilhaPronta();
        igual("guardado estragado: começa do zero sem quebrar", situacoes(), { feita: 0, aberta: 2, fechada: 23 });
    };

    cenarios.metade = async function () {
        await trilhaPronta();
        igual("8 feitas, a 9 e a livre abertas", situacoes(), { feita: 8, aberta: 2, fechada: 15 });
        conferir("destaque aponta a lição 9", $("#continuar").textContent === "Começar lição 9" && $("#destaque-titulo").textContent.startsWith("Próxima: "), $("#destaque-titulo").textContent);
        igual("lição feita mostra o visto e Refazer", linhaDaLicao(3).querySelector(".licao-numero").textContent + "|" + linhaDaLicao(3).querySelector(".licao-seta").textContent, "✓|Refazer");
    };

    cenarios.tudo = async function () {
        await trilhaPronta();
        igual("curso terminado", $("#destaque-titulo").textContent, "Você terminou o curso!");
        igual("botão vira conversa livre", $("#continuar").textContent, "Conversa livre");

        const antes = T.falado.length;
        $("#continuar").click();
        igual("título da conversa livre", $("#aula-titulo").textContent, "Conversa livre");
        igual("a saudação aparece sem pedir nada ao servidor", [$$("#conversa .bloco.ia").length, pedidosDeFala().length], [1, 0]);
        conferir("sem barra de progresso e sem Pular na conversa livre", $("#progresso").hidden && $("#pular").hidden);
        igual("saudação lida em inglês, com voz de mulher", faladoDesde(antes), [
            { texto: "Hi! I'm Emma. What would you like to talk about today?", lang: "en-US", rate: 0.95, voz: "Microsoft Aria Online (Natural) - English (United States)" },
        ]);

        const botoes = $$("#conversa .bloco.ia .acoes button");
        igual("botões da fala em inglês", botoes.map((b) => b.textContent), ["Ouvir", "Devagar", "Traduzir"]);
        botoes[2].click();
        conferir("Traduzir mostra a tradução", visivel($("#conversa .traducao")) && botoes[2].textContent === "Esconder tradução");
        botoes[2].click();
        conferir("e esconde de novo", !visivel($("#conversa .traducao")));

        const antesDoDevagar = T.falado.length;
        botoes[1].click();
        igual("Devagar lê mais lento", faladoDesde(antesDoDevagar).map((item) => item.rate), [0.65]);

        T.falso = "ok";
        await digitar("I goed to the beach");
        igual("pedido da conversa livre", ultimoPedido().campos, { texto: "I goed to the beach", licao: "livre", fase: "ensinar", passo: "1", turno: "1", historico: "1 falas" });
        $("#recomecar").click();
        igual("Recomeçar volta só com a saudação", $$("#conversa .bloco").length, 1);
    };

    cenarios.pular = async function () {
        await trilhaPronta();
        $("#continuar").click();
        igual("título da aula", $("#aula-titulo").textContent, "Lição 1 · Cumprimentos");
        conferir("abre a aula e esconde a trilha", !$("#tela-aula").hidden && $("#tela-trilha").hidden);
        conferir("enquanto a Emma pensa: pontinhos e microfone travado", estado() === "pensando" && $$("#conversa .pontos").length === 1 && $("#microfone").disabled);
        igual("pedido de abertura", ultimoPedido().campos, { licao: "1", comecar: "1" });

        $("#pular").click();
        conferir("Pular volta para a trilha", $("#tela-aula").hidden && !$("#tela-trilha").hidden);
        igual("lição 1 feita, lição 2 aberta", situacoes(), { feita: 1, aberta: 2, fechada: 22 });
        igual("destaque passa para a lição 2", $("#continuar").textContent, "Começar lição 2");

        await espera(T.demora + 600);
        conferir("a resposta atrasada da aula abandonada é ignorada", $("#tela-aula").hidden && guardado().aula.conversa.length === 0, guardado());
        igual("guardou a lição concluída", guardado().concluidas, [1]);

        linhaDaLicao(1).click();
        await respostaChegar();
        conferir("Refazer abre a lição do zero", $$("#conversa .bloco.ia").length === 1 && estado() === "parado" && !$("#pular").hidden);
        $("#voltar").click();
        igual("refazendo, a lição continua contando como feita", guardado().concluidas, [1]);
        igual("destaque oferece continuar a que ficou no meio", $("#continuar").textContent, "Continuar lição 1");
    };

    cenarios.erro = async function () {
        await trilhaPronta();
        $("#continuar").click();
        await ate(() => $(".cartao-de-aviso"), 5000, "o cartão de erro");
        igual("erro na abertura vira cartão", $(".cartao-de-aviso h3").textContent, "Não consegui começar a lição");
        igual("com a mensagem do servidor", $(".cartao-de-aviso p").textContent, "A IA pediu uma pausa. Espere alguns segundos e tente de novo.");
        conferir("sem pontinhos sobrando", $$("#conversa .pontos").length === 0 && estado() === "parado");

        $(".cartao-de-aviso button").click();
        await ate(() => $$("#conversa .bloco.ia .acoes").length === 1, 5000, "a abertura depois de tentar de novo");
        conferir("Tentar de novo funciona e o cartão some", !$(".cartao-de-aviso"));

        T.falso = "rede";
        await digitar("Hello");
        conferir("falha de rede: aviso em vermelho", $("#aviso").classList.contains("erro"), $("#aviso").textContent);
        igual("o texto digitado volta para o campo", $("#texto").value, "Hello");
        igual("a conversa fica como estava", $$("#conversa .bloco").length, 1);
        igual("nada foi guardado da fala perdida", guardado().aula.conversa.length, 1);

        T.falso = "ok";
        $("#digitar").requestSubmit();
        await respostaChegar();
        igual("mandando de novo, funciona", $$("#conversa .bloco").length, 3);
    };

    cenarios.completo = async function () {
        await trilhaPronta();
        const inicio = T.falado.length;
        $("#continuar").click();
        await respostaChegar();

        igual("a abertura tem a frase em destaque", $$("#conversa .frase").map((b) => b.textContent), ["Hello."]);
        igual("fala toda em português não tem Traduzir; com inglês tem Devagar", $$("#conversa .bloco.ia .acoes button").map((b) => b.textContent), ["Ouvir", "Devagar"]);
        igual("cada parte é lida com a voz do seu idioma", faladoDesde(inicio).map((item) => item.lang + " " + item.rate + " " + item.voz), [
            "pt-BR 1.05 Microsoft Francisca Online (Natural) - Portuguese (Brazil)",
            "en-US 0.85 Microsoft Aria Online (Natural) - English (United States)",
            "pt-BR 1.05 Microsoft Francisca Online (Natural) - Portuguese (Brazil)",
        ]);

        await ate(() => $("#palco").dataset.modo === "falando", 3000, "a Emma falar");
        igual("enquanto fala, o status diz Falando", $("#palco-status").textContent, "Falando…");
        await ate(() => $("#palco").dataset.modo === "parada", 8000, "a Emma parar de falar");
        await espera(300);
        igual("quando para: boca fechada e sua vez", [$("#emma-da-aula .emma").dataset.boca, $("#palco-status").textContent], ["0", "Sua vez de falar"]);
        const bocas = Object.keys(T.emmaVisto).filter((chave) => chave.startsWith("falando:"));
        conferir("a boca mexe enquanto fala (várias formas)", bocas.length >= 3, T.emmaVisto);

        const antesDaFrase = T.falado.length;
        $("#conversa .frase").click();
        igual("clicar na frase toca só ela", faladoDesde(antesDaFrase).map((item) => item.texto), ["Hello."]);

        // 1ª fala: errada
        await digitar("Morning good");
        igual("pedido leva lição, fase, passo e turno", ultimoPedido().campos, { texto: "Morning good", licao: "1", fase: "ensinar", passo: "1", turno: "1", historico: "1 falas" });
        igual("o histórico manda a fala da Emma num texto só", ultimoPedido().ultimaDoHistorico.papel, "ia");
        igual("aparece o cartão Jeito certo", [$$("#conversa .correcao").length, $("#conversa .correcao .etiqueta").textContent], [1, "Jeito certo"]);
        igual("palavras trocadas ficam marcadas", $$("#conversa .correcao mark").map((m) => m.textContent), ["morning."]);
        conferir("com a explicação em português", $("#conversa .explicacao").textContent.startsWith("A ordem é ao contrário"));
        igual("barra de progresso anda", [$("#progresso-barra").style.width, $("#progresso").getAttribute("aria-valuenow")], ["12%", "12"]);

        // 2ª fala: certa
        await digitar("Good morning");
        igual("fala certa ganha o selo", $$("#conversa .sem-erros").map((s) => s.textContent), ["✓ Sem erros"]);
        igual("o pedido seguinte manda o passo que o servidor devolveu", [ultimoPedido().campos.passo, ultimoPedido().campos.turno, ultimoPedido().campos.historico], ["2", "2", "3 falas"]);
        igual("fala só em português: só o botão Ouvir", $$("#conversa .bloco.ia:last-child .acoes button").map((b) => b.textContent), ["Ouvir"]);

        // 3ª fala: conclui
        await digitar("Good morning");
        igual("o pedido da prática manda a fase praticar", [ultimoPedido().campos.fase, ultimoPedido().campos.passo, ultimoPedido().campos.turno], ["praticar", "2", "3"]);
        igual("lição concluída: estado fim", estado(), "fim");
        igual("cartão de fim", [$(".cartao-de-aviso h3").textContent, $$(".cartao-de-aviso button").map((b) => b.textContent)], ["Lição concluída", ["Próxima lição", "Ver as lições"]]);
        conferir("microfone e teclado somem no fim", !visivel($("#barra")));
        conferir("Pular some, barra cheia", $("#pular").hidden && $("#progresso-barra").style.width === "100%");
        igual("guardou a conclusão", [guardado().concluidas, guardado().aula.concluida], [[1], true]);
        await espera(400);
        igual("no fim o status fica vazio", $("#palco-status").textContent, "");
        await espera(800);
        const larguras = [Math.round($("#progresso-barra").getBoundingClientRect().width), Math.round($("#progresso").getBoundingClientRect().width)];
        conferir("a barra verde aparece cheia de verdade (medida na tela)", larguras[0] === larguras[1] && larguras[0] > 100, {
            larguras,
            altura: $("#progresso-barra").getBoundingClientRect().height,
            cor: getComputedStyle($("#progresso-barra")).backgroundColor,
            visivel: visivel($("#progresso-barra")),
        });

        $(".cartao-de-aviso button").click();
        await respostaChegar();
        igual("Próxima lição abre a lição 2", $("#aula-titulo").textContent, "Lição 2 · Apresentação");
        igual("pedindo a abertura dela", ultimoPedido().campos, { licao: "2", comecar: "1" });
        conferir("com microfone de volta e barra zerada", visivel($("#barra")) && estado() === "parado" && $("#progresso-barra").style.width === "0%" && !$("#pular").hidden);
        igual("conversa nova", $$("#conversa .bloco").length, 1);
    };

    cenarios.andamento = async function () {
        await trilhaPronta();
        igual("destaque oferece continuar", [$("#destaque-titulo").textContent, $("#continuar").textContent], ["Continuar: Apresentação", "Continuar lição 2"]);
        igual("situação das lições", situacoes(), { feita: 1, aberta: 2, fechada: 22 });

        const falas = T.falado.length;
        $("#continuar").click();
        igual("a conversa guardada volta inteira", [$$("#conversa .bloco.ia").length, $$("#conversa .bloco.voce").length], [3, 2]);
        igual("sem pedir nada ao servidor e sem falar sozinha", [pedidosDeFala().length, faladoDesde(falas).length], [0, 0]);
        igual("correção e selo voltam", [$$("#conversa .correcao mark").map((m) => m.textContent), $$("#conversa .sem-erros").length], [["is"], 1]);
        igual("progresso volta", $("#progresso-barra").style.width, "14%");
        conferir("pronta para ouvir", estado() === "parado" && visivel($("#microfone")) && !$("#microfone").disabled);

        await digitar("What's your name?");
        igual("continua do ponto guardado", ultimoPedido().campos, { texto: "What's your name?", licao: "2", fase: "ensinar", passo: "2", turno: "3", historico: "5 falas" });

        $("#recomecar").click();
        igual("Recomeçar zera e pede a abertura", [ultimoPedido().campos, $$("#conversa .bloco.voce").length], [{ licao: "2", comecar: "1" }, 0]);
        await respostaChegar();
        igual("progresso volta a zero", $("#progresso-barra").style.width, "0%");
    };

    cenarios.fim = async function () {
        await trilhaPronta();
        igual("aula concluída não conta como em andamento", $("#continuar").textContent, "Começar lição 3");
        linhaDaLicao(2).click();
        conferir("Refazer uma lição concluída começa do zero", estado() === "pensando" && $$("#conversa .bloco.voce").length === 0 && !$(".cartao-de-aviso"), { estado: estado(), blocos: $$("#conversa .bloco").length });
        await respostaChegar();
        igual("e pede a abertura", ultimoPedido().campos, { licao: "2", comecar: "1" });
    };

    // Só prepara a tela para a foto.
    cenarios.foto = async function () {
        await trilhaPronta();
        const acao = T.params.get("acao") || "";
        if (acao.includes("abrir")) {
            $("#continuar").click();
            await respostaChegar();
        }
        if (acao.includes("conversar")) {
            await digitar("Morning good");
            await digitar("Good morning");
        }
        if (acao.includes("terminar")) {
            await digitar("Good morning");
        }
        if (acao.includes("ouvir")) {
            $("#conversa .bloco.ia .acoes button").click();
        }
        if (acao.includes("teclado")) {
            $("#teclado").click();
        }
        if (acao.includes("gravando")) {
            document.body.dataset.estado = "gravando";
            $("#aviso").textContent = "0:03 · toque para enviar";
        }
        if (acao.includes("pensando")) {
            document.body.dataset.estado = "pensando";
            $("#microfone").disabled = true;
            $("#aviso").textContent = "Pensando…";
        }
        if (acao.includes("erro")) {
            $("#aviso").textContent = "A IA pediu uma pausa. Espere alguns segundos e tente de novo.";
            $("#aviso").classList.add("erro");
        }
    };

    // ---------- Cenários de verdade (usam a IA) ----------

    function escolherResposta(bloco, fase) {
        const frases = Array.from(bloco.querySelectorAll(".frase")).map((b) => b.textContent.trim());
        const texto = bloco.querySelector(".fala").textContent.toLowerCase();

        if (frases.length > 0) {
            const frase = frases[frases.length - 1];
            if (fase === "praticar" && /how are you/i.test(frase)) {
                return "I'm fine, thanks";
            }
            return frase.split("/")[0].trim();
        }
        if (/manhã|acord/.test(texto)) return "Good morning";
        if (/dormir|noite|deitar/.test(texto)) return "Good night";
        if (/tchau|desped|embora|saindo|sair|até logo/.test(texto)) return "Goodbye";
        if (/como (você |voce |vc |ele |ela )?(est|vai)|tudo bem/.test(texto)) {
            return /você (quer|vai) (saber|perguntar)|como você pergunta/.test(texto) ? "How are you?" : "I'm fine, thanks";
        }
        return "Hello";
    }

    cenarios["real-licao"] = async function () {
        const pausa = Number(T.params.get("pausa") || 7000);
        await trilhaPronta();
        $("#continuar").click();
        await respostaChegar();
        conferir("a Emma abriu a lição", $$("#conversa .bloco.ia .acoes").length === 1, $("#conversa").textContent.slice(0, 300));

        let errou = false;
        for (let vez = 1; vez <= 22 && estado() !== "fim"; vez++) {
            await espera(pausa);
            const resposta = ultimoPedido().resposta || {};
            const blocos = $$("#conversa .bloco.ia");
            if (blocos.length === 0) {
                break;
            }
            let fala = escolherResposta(blocos[blocos.length - 1], resposta.fase);
            if (!errou && resposta.fase === "ensinar" && /good morning/i.test(fala)) {
                fala = "Morning good";
                errou = true;
            }

            await digitar(fala);
            const volta = ultimoPedido().resposta || {};
            T.turnos.push({
                vez,
                fala,
                ms: ultimoPedido().ms,
                enviado: ultimoPedido().campos,
                ok: volta.ok,
                erro: volta.erro,
                correcao: volta.correcao,
                explicacao: volta.explicacao,
                acertou: volta.acertou,
                fase: volta.fase,
                passo: volta.passo,
                progresso: volta.progresso,
                concluida: volta.concluida,
                emma: (volta.falas || []).map((parte) => parte.idioma + ": " + parte.texto),
            });
            if (!volta.ok) {
                await espera(12000);
                $("#texto").value = "";
            }
        }

        // A condução da aula: nenhum item pulado e nenhuma despedida antes da hora.
        const abertura = (pedidosDeFala()[0].resposta.falas || []).map((parte) => parte.idioma + ": " + parte.texto);
        const ensinado = T.turnos
            .map((turno) => turno.emma)
            .concat([abertura])
            .flat()
            .filter((parte) => parte.startsWith("en:"))
            .join(" | ")
            .toLowerCase();
        for (const item of ["hello|hi", "good morning", "good night", "how are you", "i'm fine|i am fine", "goodbye|bye"]) {
            conferir("a Emma ensinou: " + item, new RegExp(item).test(ensinado));
        }
        const pulos = T.turnos.filter((turno, i) => i > 0 && turno.fase === T.turnos[i - 1].fase && (turno.passo < T.turnos[i - 1].passo || turno.passo > T.turnos[i - 1].passo + 1));
        conferir("cada fala anda no máximo um passo", pulos.length === 0, pulos);
        const mudas = T.turnos.filter((turno) => turno.ok && turno.fase === "praticar" && !turno.concluida && !/\?|tent[ae]|repet|repit|diga|fal[ae]/i.test(turno.emma.join(" ")));
        conferir("na prática, a Emma só se despede quando a lição acaba de verdade", mudas.length === 0, mudas.map((turno) => turno.emma));
        T.caminho = T.turnos.map((turno) => turno.fase[0] + turno.passo + (turno.concluida ? "!" : "")).join(" ");

        igual("a lição chegou ao fim pela tela", estado(), "fim");
        conferir("a correção apareceu na tela", $$("#conversa .correcao").length >= 1, $$("#conversa .correcao").map((c) => c.textContent));
        conferir("cartão de lição concluída", $(".cartao-de-aviso") && $(".cartao-de-aviso h3").textContent === "Lição concluída");
        igual("progresso em 100%", $("#progresso-barra").style.width, "100%");
        igual("guardou a lição 1 como concluída", guardado().concluidas, [1]);

        const botoes = $$(".cartao-de-aviso button");
        if (botoes.length === 2) {
            botoes[1].click();
            igual("de volta na trilha: 1 feita, 2 aberta", situacoes(), { feita: 1, aberta: 2, fechada: 22 });
            igual("destaque aponta a lição 2", $("#continuar").textContent, "Começar lição 2");
        }
        T.tamanhoGuardado = localStorage.getItem("treino-ingles-v2").length;
    };

    cenarios["real-livre"] = async function () {
        await trilhaPronta();
        $$(".licao").slice(-1)[0].click();
        await digitar("Yesterday I goed to the beach with my friends");
        const volta = ultimoPedido().resposta || {};
        T.turnos.push({ fala: "Yesterday I goed to the beach with my friends", ms: ultimoPedido().ms, volta });
        conferir("a IA corrigiu o erro (goed → went)", /went/i.test(volta.correcao || ""), volta.correcao);
        conferir("cartão de correção com a palavra marcada", $$("#conversa .correcao mark").some((m) => /went/i.test(m.textContent)), $$("#conversa .correcao mark").map((m) => m.textContent));
        conferir("resposta só em inglês, com Traduzir", $$("#conversa .bloco.ia:last-child .acoes button").map((b) => b.textContent).join() === "Ouvir,Devagar,Traduzir", $$("#conversa .bloco.ia:last-child .acoes button").map((b) => b.textContent));
        conferir("tradução veio", (volta.traducao || "").length > 3, volta.traducao);
    };

    // Grava com o microfone de mentira do Chrome, que toca um arquivo de áudio.
    cenarios["real-mic"] = async function () {
        const esperado = new RegExp(T.params.get("esperado") || ".", "i");
        const segundos = Number(T.params.get("segundos") || 5);
        await trilhaPronta();

        if (T.params.get("licao") === "1") {
            $("#continuar").click();
            await respostaChegar();
            await espera(3000);
        } else {
            $$(".licao").slice(-1)[0].click();
        }

        // 1. gravação de verdade
        $("#microfone").click();
        await ate(() => estado() === "gravando", 8000, "a gravação começar");
        conferir("gravando: aparece cancelar, some o teclado, a Emma ouve", visivel($("#cancelar")) && getComputedStyle($("#teclado")).visibility === "hidden");
        await espera(700);
        igual("a Emma fica ouvindo", [$("#palco").dataset.modo, $("#palco-status").textContent], ["ouvindo", "Ouvindo você…"]);
        conferir("relógio da gravação", /^0:0\d · toque para enviar$/.test($("#aviso").textContent), $("#aviso").textContent);
        await espera(segundos * 1000 - 700);
        $("#microfone").click();
        await ate(() => estado() === "pensando", 3000, "o envio");
        await respostaChegar();

        const pedido = ultimoPedido();
        const volta = pedido.resposta || {};
        T.turnos.push({ enviado: pedido.campos, ms: pedido.ms, volta });
        conferir("o áudio foi enviado", /^\(áudio audio\//.test(pedido.campos.audio || ""), pedido.campos.audio);
        conferir("a IA entendeu a fala gravada", volta.ok && esperado.test(volta.voce || ""), volta.voce || volta.erro);
        conferir("a fala aparece na conversa", $$("#conversa .bloco.voce .fala").some((f) => esperado.test(f.textContent)));

        // 2. gravação curta demais
        await espera(1500);
        const antes = pedidosDeFala().length;
        $("#microfone").click();
        await ate(() => estado() === "gravando", 8000, "a segunda gravação");
        $("#microfone").click();
        await ate(() => estado() === "parado", 3000, "voltar a parado");
        igual("gravação curta é descartada com aviso", [$("#aviso").textContent, pedidosDeFala().length - antes], ["Ficou muito curto. Toque, fale e toque de novo.", 0]);

        // 3. cancelar
        $("#microfone").click();
        await ate(() => estado() === "gravando", 8000, "a terceira gravação");
        await espera(1200);
        $("#cancelar").click();
        await ate(() => estado() === "parado", 3000, "cancelar");
        await espera(500);
        igual("cancelar não envia nada", [pedidosDeFala().length - antes, $("#aviso").textContent], [0, "Toque no microfone e fale"]);

        // 4. atalhos do teclado
        document.dispatchEvent(new KeyboardEvent("keydown", { code: "Space", bubbles: true }));
        await ate(() => estado() === "gravando", 8000, "gravar com a barra de espaço");
        await espera(900);
        document.dispatchEvent(new KeyboardEvent("keydown", { code: "Escape", bubbles: true }));
        await ate(() => estado() === "parado", 3000, "cancelar com Esc");
        igual("barra de espaço grava e Esc cancela", pedidosDeFala().length - antes, 0);

        // 5. sair da aula no meio da gravação
        $("#microfone").click();
        await ate(() => estado() === "gravando", 8000, "a última gravação");
        await espera(900);
        $("#voltar").click();
        await espera(800);
        conferir("sair da aula gravando: descarta e volta para a trilha", pedidosDeFala().length - antes === 0 && estado() === "parado" && $("#tela-aula").hidden, estado());
    };

    // ---------- Roda o cenário e manda o resultado ----------

    async function rodar() {
        const cenario = cenarios[T.nome];
        try {
            if (!cenario) {
                throw new Error("cenário desconhecido: " + T.nome);
            }
            await cenario();
        } catch (erro) {
            T.conferencias.push({ ok: false, descricao: "o roteiro parou no meio", detalhe: String((erro && erro.stack) || erro) });
        }

        const falhas = T.conferencias.filter((item) => !item.ok);
        const resultado = {
            nome: T.nome,
            passou: falhas.length === 0 && T.errosJs.length === 0,
            total: T.conferencias.length,
            falhas,
            errosJs: T.errosJs,
            vozTrocada: T.vozTrocada,
            emmaVisto: T.emmaVisto,
            turnos: T.turnos,
            niveis: T.niveis,
            primeiraLinha: T.primeiraLinha,
            tamanhoGuardado: T.tamanhoGuardado,
            caminho: T.caminho,
            certas: T.conferencias.filter((item) => item.ok).map((item) => item.descricao),
        };
        document.documentElement.dataset.teste = resultado.passou ? "passou" : "falhou";

        if (T.nome !== "foto") {
            await T.fetchReal("/__teste/resultado?nome=" + T.nome + (T.params.get("sufixo") || ""), { method: "POST", body: JSON.stringify(resultado, null, 1) });
        }
    }

    rodar();
})();
