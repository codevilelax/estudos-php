"use strict";

// A tela do treino. Tem duas telas:
// - a trilha: a lista de lições, com o que já foi feito;
// - a aula: a Emma na tela, a conversa e o microfone.
// A fala gravada vai para o servidor (api/falar.php), que devolve a correção e a
// resposta da professora. A resposta é lida em voz alta, e a Emma mexe a boca.

const GUARDADO = "treino-ingles-v2";
const TEMPO_MINIMO = 600; // gravação mais curta que isso (em milissegundos) é descartada
const TEMPO_MAXIMO = 60000; // depois disso a gravação é enviada sozinha
const FALAS_ENVIADAS = 8; // quantas falas antigas vão junto em cada pedido
const FALAS_GUARDADAS = 80; // quantas falas da aula ficam guardadas no navegador

const SAUDACAO_LIVRE = {
    papel: "ia",
    falas: [{ idioma: "en", texto: "Hi! I'm Emma. What would you like to talk about today?" }],
    traducao: "Oi! Eu sou a Emma. Sobre o que você quer conversar hoje?",
};

const DICAS = {
    parado: "Toque no microfone e fale",
    pensando: "Pensando…",
};

const STATUS_DA_EMMA = {
    parada: "Sua vez de falar",
    falando: "Falando…",
    ouvindo: "Ouvindo você…",
    pensando: "Pensando…",
};

const el = (id) => document.getElementById(id);

const telaTrilha = el("tela-trilha");
const telaAula = el("tela-aula");
const listaDeNiveis = el("niveis");
const destaqueTitulo = el("destaque-titulo");
const destaqueResumo = el("destaque-resumo");
const botaoContinuar = el("continuar");
const tituloDaAula = el("aula-titulo");
const barraDeProgresso = el("progresso");
const enchimento = el("progresso-barra");
const palco = el("palco");
const statusDaEmma = el("palco-status");
const lista = el("conversa");
const aviso = el("aviso");
const botaoVoltar = el("voltar");
const botaoPular = el("pular");
const botaoRecomecar = el("recomecar");
const botaoMicrofone = el("microfone");
const botaoCancelar = el("cancelar");
const botaoTeclado = el("teclado");
const formulario = el("digitar");
const campoTexto = el("texto");

let niveis = []; // o curso, como veio do servidor
let licoes = []; // todas as lições em ordem, cada uma com o número do seu nível
let dados = lerGuardado(); // o que fica guardado: lições concluídas e a aula em andamento
let aula = null; // a aula aberta agora (é a mesma de dados.aula)

let gravador = null;
let pedacos = [];
let inicioDaGravacao = 0;
let relogio = null;
let jogarFora = false;

// ---------- O que fica guardado no navegador ----------

function lerGuardado() {
    let lido = null;
    try {
        lido = JSON.parse(localStorage.getItem(GUARDADO));
    } catch (erro) {
        // Guardado estragado ou navegador sem armazenamento: começa do zero.
    }

    const valido = lido && Array.isArray(lido.concluidas);
    return valido ? lido : { concluidas: [], aula: null };
}

function guardar() {
    if (aula) {
        aula.conversa = aula.conversa.slice(-FALAS_GUARDADAS);
    }
    try {
        localStorage.setItem(GUARDADO, JSON.stringify(dados));
    } catch (erro) {
        // Sem espaço ou em janela anônima: o progresso só não fica guardado.
    }
}

// ---------- Voz ----------

let vozes = [];

function carregarVozes() {
    vozes = speechSynthesis.getVoices();
}

if (window.speechSynthesis) {
    carregarVozes();
    speechSynthesis.addEventListener("voiceschanged", carregarVozes);
}

// Escolhe a voz mais natural que o navegador tiver para o idioma ("en" ou "pt").
// A Emma é mulher, então vozes de homem perdem pontos.
function melhorVoz(idioma) {
    let melhor = null;
    let melhorNota = -99;

    for (const voz of vozes) {
        const idiomaDaVoz = voz.lang.replace("_", "-").toLowerCase();
        if (!idiomaDaVoz.startsWith(idioma)) {
            continue;
        }

        let nota = 0;
        if (/natural/i.test(voz.name)) nota += 4;
        if (/google (us english|português do brasil)/i.test(voz.name)) nota += 3;
        if (idiomaDaVoz === "en-us" || idiomaDaVoz === "pt-br") nota += 2;
        if (/aria|jenny|ava|emma|zira|francisca|thalita|maria/i.test(voz.name)) nota += 1;
        if (/david|mark|guy|andrew|brian|daniel|antonio|male/i.test(voz.name) && !/female/i.test(voz.name)) nota -= 3;

        if (nota > melhorNota) {
            melhorNota = nota;
            melhor = voz;
        }
    }

    return melhor;
}

// Nos primeiros níveis, o inglês é falado um pouco mais devagar.
function ritmoDoIngles() {
    const licao = aula ? acharLicao(aula.licao) : null;
    return licao && licao.nivel <= 2 ? 0.85 : 0.95;
}

// Lê em voz alta uma lista de partes, cada uma com a voz do seu idioma.
function falar(partes, devagar) {
    if (!window.speechSynthesis) {
        return;
    }

    speechSynthesis.cancel();

    for (const parte of partes) {
        const fala = new SpeechSynthesisUtterance(parte.texto);
        const voz = melhorVoz(parte.idioma);
        if (voz) {
            fala.voice = voz;
        }
        fala.lang = voz ? voz.lang : parte.idioma === "pt" ? "pt-BR" : "en-US";
        if (parte.idioma === "pt") {
            fala.rate = 1.05;
        } else {
            fala.rate = devagar ? 0.65 : ritmoDoIngles();
        }
        speechSynthesis.speak(fala);
    }
}

function calarVoz() {
    if (window.speechSynthesis) {
        speechSynthesis.cancel();
    }
}

// ---------- Emma ----------

// Copia o desenho da Emma (o molde do index.html) para dentro de um elemento.
function desenharEmma(lugar) {
    lugar.append(el("molde-emma").content.cloneNode(true));
    return lugar.querySelector(".emma");
}

const emmaDaAula = desenharEmma(el("emma-da-aula"));
desenharEmma(el("emma-da-trilha"));

let bocaAtual = 0;

// Várias vezes por segundo: decide o que a Emma está fazendo e mexe a boca
// enquanto o navegador estiver lendo a fala dela.
function atualizarEmma() {
    if (telaAula.hidden) {
        return;
    }

    let modo = "parada";
    if (estado() === "gravando") {
        modo = "ouvindo";
    } else if (estado() === "pensando") {
        modo = "pensando";
    } else if (window.speechSynthesis && speechSynthesis.speaking) {
        modo = "falando";
    }

    if (modo === "falando") {
        // Sorteia uma boca diferente da atual, para parecer que ela articula.
        const outras = [0, 1, 2, 3].filter((boca) => boca !== bocaAtual);
        bocaAtual = outras[Math.floor(Math.random() * outras.length)];
    } else {
        bocaAtual = 0;
    }

    palco.dataset.modo = modo;
    emmaDaAula.dataset.boca = bocaAtual;
    statusDaEmma.textContent = estado() === "fim" ? "" : STATUS_DA_EMMA[modo];
}

setInterval(atualizarEmma, 130);

// ---------- Ajudas para montar a tela ----------

function criar(tag, classe, texto) {
    const elemento = document.createElement(tag);
    if (classe) {
        elemento.className = classe;
    }
    if (texto !== undefined) {
        elemento.textContent = texto;
    }
    return elemento;
}

function botao(classe, rotulo, aoClicar) {
    const novo = criar("button", classe, rotulo);
    novo.type = "button";
    novo.addEventListener("click", aoClicar);
    return novo;
}

function rolarParaOFim() {
    lista.scrollTop = lista.scrollHeight;
}

function acharLicao(id) {
    return licoes.find((licao) => licao.id === id) || null;
}

// ---------- Trilha ----------

function foiConcluida(licao) {
    return dados.concluidas.includes(licao.id);
}

// Uma lição abre quando a anterior foi concluída. A primeira está sempre aberta.
function estaAberta(licao) {
    const posicao = licoes.indexOf(licao);
    return posicao === 0 || foiConcluida(licao) || foiConcluida(licoes[posicao - 1]);
}

function proximaLicao() {
    return licoes.find((licao) => !foiConcluida(licao)) || null;
}

function aulaEmAndamento() {
    const guardada = dados.aula;
    return guardada && !guardada.concluida && guardada.conversa.length > 0 ? guardada : null;
}

function mostrarDestaque() {
    const emAndamento = aulaEmAndamento();
    const proxima = proximaLicao();
    let alvo = "livre";

    if (emAndamento && emAndamento.licao !== "livre" && acharLicao(emAndamento.licao)) {
        const licao = acharLicao(emAndamento.licao);
        alvo = licao.id;
        destaqueTitulo.textContent = "Continuar: " + licao.titulo;
        destaqueResumo.textContent = "Você parou no meio da lição " + licao.id + ". Vamos terminar?";
        botaoContinuar.textContent = "Continuar lição " + licao.id;
    } else if (proxima) {
        alvo = proxima.id;
        const primeira = dados.concluidas.length === 0;
        destaqueTitulo.textContent = primeira ? "Vamos começar do zero?" : "Próxima: " + proxima.titulo;
        destaqueResumo.textContent = primeira
            ? "Eu te ensino uma coisa por vez, em português no começo. Você repete, eu corrijo, e a gente avança."
            : proxima.resumo;
        botaoContinuar.textContent = "Começar lição " + proxima.id;
    } else {
        destaqueTitulo.textContent = "Você terminou o curso!";
        destaqueResumo.textContent = "Agora é praticar. Vamos conversar em inglês sobre o que você quiser.";
        botaoContinuar.textContent = "Conversa livre";
    }

    botaoContinuar.hidden = false;
    botaoContinuar.onclick = () => abrirAula(alvo);
}

function linhaDaLicao(numero, titulo, resumo, situacao, aoClicar) {
    const linha = botao("licao", undefined, aoClicar);
    linha.dataset.situacao = situacao;
    linha.disabled = situacao === "fechada";

    const texto = criar("span", "licao-texto");
    texto.append(criar("strong", "", titulo), criar("span", "", resumo));

    const setas = { feita: "Refazer", aberta: "Abrir ›", fechada: "" };
    linha.append(criar("span", "licao-numero", numero), texto, criar("span", "licao-seta", setas[situacao]));
    return linha;
}

function mostrarTrilha() {
    mostrarDestaque();
    listaDeNiveis.textContent = "";

    for (const nivel of niveis) {
        const secao = criar("section", "nivel");
        const titulo = criar("h3");
        titulo.append(criar("span", "", "Nível " + nivel.numero), nivel.nome);

        const linhas = criar("div", "licoes");
        for (const licao of nivel.licoes) {
            let situacao = "fechada";
            if (foiConcluida(licao)) {
                situacao = "feita";
            } else if (estaAberta(licao)) {
                situacao = "aberta";
            }
            const numero = situacao === "feita" ? "✓" : String(licao.id);
            linhas.append(linhaDaLicao(numero, licao.titulo, licao.resumo, situacao, () => abrirAula(licao.id)));
        }

        secao.append(titulo, linhas);
        listaDeNiveis.append(secao);
    }

    const secao = criar("section", "nivel");
    const titulo = criar("h3");
    titulo.append(criar("span", "", "Sem roteiro"), "Conversa livre");
    const linhas = criar("div", "licoes");
    linhas.append(linhaDaLicao("∞", "Bate-papo com a Emma", "Converse em inglês sobre o que quiser.", "aberta", () => abrirAula("livre")));
    secao.append(titulo, linhas);
    listaDeNiveis.append(secao);
}

async function carregarCurso() {
    try {
        const retorno = await fetch("api/curso.php");
        niveis = (await retorno.json()).niveis;
    } catch (erro) {
        destaqueTitulo.textContent = "Não consegui carregar as lições";
        destaqueResumo.textContent = "Confira se o servidor está ligado (iniciar.bat) e atualize a página.";
        return;
    }

    licoes = [];
    for (const nivel of niveis) {
        for (const licao of nivel.licoes) {
            licao.nivel = nivel.numero;
            licoes.push(licao);
        }
    }

    mostrarTrilha();
}

// ---------- Falas na tela ----------

function simplificar(palavra) {
    return palavra.toLowerCase().replace(/[^a-z0-9']/g, "");
}

// Monta a frase corrigida com as palavras novas ou trocadas em destaque.
// Compara as duas frases palavra por palavra e acha a maior sequência em comum.
function destacar(original, correcao) {
    const antes = original.split(/\s+/).map(simplificar).filter(Boolean);
    const palavras = correcao.split(/\s+/).filter(Boolean);
    const depois = palavras.map(simplificar);

    const tabela = [];
    for (let i = 0; i <= antes.length; i++) {
        tabela.push(new Array(depois.length + 1).fill(0));
    }
    for (let i = antes.length - 1; i >= 0; i--) {
        for (let j = depois.length - 1; j >= 0; j--) {
            tabela[i][j] = antes[i] === depois[j]
                ? tabela[i + 1][j + 1] + 1
                : Math.max(tabela[i + 1][j], tabela[i][j + 1]);
        }
    }

    const frase = document.createDocumentFragment();
    let i = 0;
    palavras.forEach((palavra, j) => {
        while (i < antes.length && antes[i] !== depois[j] && tabela[i + 1][j] >= tabela[i][j + 1]) {
            i++;
        }
        const igual = depois[j] === "" || (i < antes.length && antes[i] === depois[j]);
        if (igual && depois[j] !== "") {
            i++;
        }
        if (j > 0) {
            frase.append(" ");
        }
        frase.append(igual ? palavra : criar("mark", "", palavra));
    });

    return frase;
}

function mostrarFalaIA(item) {
    const bloco = criar("div", "bloco ia");
    const fala = criar("div", "fala");
    const emIngles = item.falas.filter((parte) => parte.idioma === "en");
    const misturada = emIngles.length > 0 && emIngles.length < item.falas.length;

    for (const parte of item.falas) {
        if (parte.idioma === "en" && misturada) {
            // No meio de uma fala em português, o inglês é a frase que ela está ensinando.
            const frase = botao("frase", parte.texto, () => falar([parte], false));
            frase.lang = "en";
            frase.title = "Ouvir de novo";
            fala.append(frase);
        } else {
            const texto = criar("p", "", parte.texto);
            texto.lang = parte.idioma === "en" ? "en" : "pt-br";
            fala.append(texto);
        }
    }

    const acoes = criar("div", "acoes");
    acoes.append(botao("botao-pequeno", "Ouvir", () => falar(item.falas, false)));
    if (emIngles.length > 0) {
        acoes.append(botao("botao-pequeno", "Devagar", () => falar(emIngles, true)));
    }

    if (item.traducao) {
        const traducao = criar("p", "traducao", item.traducao);
        traducao.hidden = true;
        fala.append(traducao);

        const alternar = botao("botao-pequeno", "Traduzir", () => {
            traducao.hidden = !traducao.hidden;
            alternar.textContent = traducao.hidden ? "Traduzir" : "Esconder tradução";
        });
        acoes.append(alternar);
    }

    bloco.append(fala, acoes);
    lista.append(bloco);
    rolarParaOFim();
}

function mostrarFalaVoce(item) {
    const bloco = criar("div", "bloco voce");
    bloco.append(criar("div", "fala", item.texto));

    if (item.correcao) {
        const correcao = [{ idioma: "en", texto: item.correcao }];
        const cartao = criar("div", "correcao");
        const frase = criar("p");
        frase.lang = "en";
        frase.append(destacar(item.texto, item.correcao));
        cartao.append(criar("span", "etiqueta", "Jeito certo"), frase);

        if (item.explicacao) {
            cartao.append(criar("p", "explicacao", item.explicacao));
        }

        const acoes = criar("div", "acoes");
        acoes.append(
            botao("botao-pequeno", "Ouvir", () => falar(correcao, false)),
            botao("botao-pequeno", "Devagar", () => falar(correcao, true))
        );
        cartao.append(acoes);
        bloco.append(cartao);
    } else if (item.acertou) {
        bloco.append(criar("span", "sem-erros", "✓ Sem erros"));
    }

    lista.append(bloco);
    rolarParaOFim();
}

// Balão provisório enquanto a resposta não chega.
function mostrarEspera(texto, lado) {
    const bloco = criar("div", "bloco " + lado);
    const fala = criar("div", "fala");

    if (texto) {
        fala.textContent = texto;
    } else {
        const pontos = criar("span", "pontos");
        pontos.append(criar("span"), criar("span"), criar("span"));
        fala.append(pontos);
    }

    bloco.append(fala);
    lista.append(bloco);
    rolarParaOFim();
    return bloco;
}

// Cartão no meio da conversa, com título, texto e botões.
function mostrarCartao(titulo, texto, botoes) {
    const cartao = criar("div", "cartao-de-aviso");
    const acoes = criar("div", "acoes");
    acoes.append(...botoes);
    cartao.append(criar("h3", "", titulo), criar("p", "", texto), acoes);
    lista.append(cartao);
    rolarParaOFim();
    return cartao;
}

function mostrarFimDaLicao() {
    const licao = acharLicao(aula.licao);
    const posicao = licoes.indexOf(licao);
    const seguinte = licoes[posicao + 1];
    const botoes = [];

    if (seguinte) {
        botoes.push(botao("botao-principal", "Próxima lição", () => abrirAula(seguinte.id)));
    }
    botoes.push(botao("botao-pequeno", "Ver as lições", voltarParaATrilha));

    const texto = seguinte
        ? "Você terminou \"" + licao.titulo + "\". A próxima é \"" + seguinte.titulo + "\"."
        : "Você terminou a última lição do curso. Agora é praticar na conversa livre.";
    mostrarCartao("Lição concluída", texto, botoes);
}

function mostrarConversa() {
    lista.textContent = "";
    for (const item of aula.conversa) {
        if (item.papel === "ia") {
            mostrarFalaIA(item);
        } else {
            mostrarFalaVoce(item);
        }
    }
    if (aula.concluida) {
        mostrarFimDaLicao();
    }
}

// ---------- Estado da aula ----------

function estado() {
    return document.body.dataset.estado;
}

function avisar(texto, ehErro) {
    aviso.textContent = texto || DICAS[estado()] || "";
    aviso.classList.toggle("erro", Boolean(texto && ehErro));
}

function mudarEstado(novo) {
    document.body.dataset.estado = novo;
    botaoMicrofone.disabled = novo === "pensando";
    botaoMicrofone.setAttribute("aria-label", novo === "gravando" ? "Enviar a gravação" : "Falar");
    avisar("");
}

function mostrarProgresso() {
    const ehLicao = aula.licao !== "livre";
    barraDeProgresso.hidden = !ehLicao;
    botaoPular.hidden = !ehLicao || aula.concluida;
    enchimento.style.width = aula.progresso + "%";
    barraDeProgresso.setAttribute("aria-valuenow", aula.progresso);
}

// ---------- Abrir, recomeçar e sair da aula ----------

function novaAula(licao) {
    return { licao, fase: "ensinar", passo: 1, turno: 0, progresso: 0, concluida: false, conversa: [] };
}

function abrirAula(licao, doZero) {
    // Só continua de onde parou se a aula guardada é desta lição e ficou no meio.
    // Lição já concluída ("Refazer") começa do zero.
    const guardada = dados.aula;
    const continuar = !doZero && guardada && guardada.licao === licao && !guardada.concluida && guardada.conversa.length > 0;

    calarVoz();
    aula = continuar ? guardada : novaAula(licao);
    dados.aula = aula;

    const daLicao = acharLicao(licao);
    tituloDaAula.textContent = daLicao ? "Lição " + daLicao.id + " · " + daLicao.titulo : "Conversa livre";

    telaTrilha.hidden = true;
    telaAula.hidden = false;
    formulario.hidden = true;
    mudarEstado(aula.concluida ? "fim" : "parado");
    mostrarProgresso();
    mostrarConversa();

    if (aula.conversa.length > 0) {
        return;
    }

    if (licao === "livre") {
        aula.conversa.push(SAUDACAO_LIVRE);
        guardar();
        mostrarConversa();
        falar(SAUDACAO_LIVRE.falas, false);
    } else {
        pedirAbertura();
    }
}

function voltarParaATrilha() {
    if (estado() === "gravando") {
        pararGravacao(true);
    }
    calarVoz();
    guardar();
    telaAula.hidden = true;
    telaTrilha.hidden = false;
    mostrarTrilha();
}

function concluirLicao() {
    aula.concluida = true;
    aula.progresso = 100;
    if (!dados.concluidas.includes(aula.licao)) {
        dados.concluidas.push(aula.licao);
    }
    guardar();
}

// ---------- Gravação ----------

function tipoDeGravacao() {
    const tipos = ["audio/webm;codecs=opus", "audio/webm", "audio/mp4", "audio/ogg;codecs=opus"];
    return tipos.find((tipo) => MediaRecorder.isTypeSupported(tipo)) || "";
}

function mostrarRelogio() {
    const segundos = Math.floor((Date.now() - inicioDaGravacao) / 1000);
    aviso.classList.remove("erro");
    aviso.textContent = "0:" + String(segundos).padStart(2, "0") + " · toque para enviar";

    if (Date.now() - inicioDaGravacao >= TEMPO_MAXIMO) {
        pararGravacao(false);
    }
}

async function comecarGravacao() {
    if (!navigator.mediaDevices || !window.MediaRecorder) {
        avisar("Este navegador não grava áudio. Use o teclado para escrever.", true);
        return;
    }

    calarVoz();

    let microfone;
    try {
        microfone = await navigator.mediaDevices.getUserMedia({
            audio: { echoCancellation: true, noiseSuppression: true },
        });
    } catch (erro) {
        avisar("Preciso do microfone. Clique no cadeado ao lado do endereço, permita o microfone e tente de novo.", true);
        return;
    }

    // Enquanto o navegador pedia a permissão, outra coisa pode ter começado.
    if (estado() !== "parado" || telaAula.hidden) {
        microfone.getTracks().forEach((faixa) => faixa.stop());
        return;
    }

    const tipo = tipoDeGravacao();
    gravador = new MediaRecorder(microfone, tipo ? { mimeType: tipo, audioBitsPerSecond: 32000 } : undefined);
    pedacos = [];
    jogarFora = false;

    gravador.addEventListener("dataavailable", (evento) => {
        if (evento.data.size > 0) {
            pedacos.push(evento.data);
        }
    });

    gravador.addEventListener("stop", () => {
        const duracao = Date.now() - inicioDaGravacao;
        const audio = new Blob(pedacos, { type: gravador.mimeType || "audio/webm" });

        microfone.getTracks().forEach((faixa) => faixa.stop());
        gravador = null;

        if (jogarFora) {
            if (estado() === "gravando") {
                mudarEstado("parado");
            }
        } else if (duracao < TEMPO_MINIMO || audio.size === 0) {
            mudarEstado("parado");
            avisar("Ficou muito curto. Toque, fale e toque de novo.", true);
        } else {
            const envio = new FormData();
            envio.append("audio", audio, "fala");
            enviar(envio, "");
        }
    });

    gravador.start();
    inicioDaGravacao = Date.now();
    mudarEstado("gravando");
    mostrarRelogio();
    relogio = setInterval(mostrarRelogio, 250);
}

function pararGravacao(descartar) {
    clearInterval(relogio);
    jogarFora = descartar;
    if (gravador && gravador.state !== "inactive") {
        gravador.stop();
    }
}

function alternarMicrofone() {
    if (estado() === "parado") {
        comecarGravacao();
    } else if (estado() === "gravando") {
        pararGravacao(false);
    }
}

// ---------- Conversa com o servidor ----------

// Manda o pedido para o servidor e devolve a resposta. Nunca dá erro:
// quando algo falha, devolve { ok: false, erro: "..." }.
async function pedir(envio) {
    try {
        const retorno = await fetch("api/falar.php", { method: "POST", body: envio });
        return await retorno.json();
    } catch (erro) {
        return { ok: false, erro: "Não consegui falar com o servidor. Confira se ele está ligado." };
    }
}

// Guarda e mostra o que a professora respondeu, e lê em voz alta.
function receberFalaDaEmma(resposta) {
    const fala = { papel: "ia", falas: resposta.falas, traducao: resposta.traducao };
    aula.conversa.push(fala);
    aula.fase = resposta.fase;
    aula.passo = resposta.passo;
    aula.progresso = resposta.progresso;

    if (resposta.concluida) {
        concluirLicao();
    }
    guardar();

    mostrarFalaIA(fala);
    mostrarProgresso();
    falar(fala.falas, false);

    if (aula.concluida) {
        mudarEstado("fim");
        mostrarFimDaLicao();
    }
}

// Pede para a Emma abrir a lição (a primeira fala é dela).
async function pedirAbertura() {
    const aulaDoPedido = aula;
    mudarEstado("pensando");
    const espera = mostrarEspera("", "ia");

    const envio = new FormData();
    envio.append("licao", aula.licao);
    envio.append("comecar", "1");
    const resposta = await pedir(envio);

    // Se ele saiu desta aula enquanto a resposta vinha, ela não serve mais.
    if (aula !== aulaDoPedido || telaAula.hidden) {
        return;
    }

    espera.remove();
    mudarEstado("parado");

    if (!resposta.ok) {
        const cartao = mostrarCartao("Não consegui começar a lição", resposta.erro || "Tente de novo.", [
            botao("botao-principal", "Tentar de novo", () => {
                cartao.remove();
                pedirAbertura();
            }),
        ]);
        return;
    }

    receberFalaDaEmma(resposta);
}

async function enviar(envio, textoDigitado) {
    const aulaDoPedido = aula;
    const anteriores = aula.conversa.slice(-FALAS_ENVIADAS).map((item) => ({
        papel: item.papel,
        texto: item.papel === "ia" ? item.falas.map((parte) => parte.texto).join(" ") : item.texto,
    }));

    envio.append("licao", aula.licao);
    envio.append("fase", aula.fase);
    envio.append("passo", aula.passo);
    envio.append("turno", aula.turno + 1);
    envio.append("historico", JSON.stringify(anteriores));

    mudarEstado("pensando");
    const espera = mostrarEspera(textoDigitado, "voce");
    const resposta = await pedir(envio);

    if (aula !== aulaDoPedido || telaAula.hidden) {
        return;
    }

    espera.remove();
    mudarEstado("parado");

    if (!resposta.ok) {
        avisar(resposta.erro || "Deu um erro. Tente de novo.", true);
        if (textoDigitado) {
            campoTexto.value = textoDigitado;
        }
        return;
    }

    const voce = {
        papel: "voce",
        texto: resposta.voce,
        correcao: resposta.correcao,
        explicacao: resposta.explicacao,
        acertou: resposta.acertou,
    };
    aula.conversa.push(voce);
    aula.turno++;
    mostrarFalaVoce(voce);
    receberFalaDaEmma(resposta);
}

// ---------- Botões ----------

botaoMicrofone.addEventListener("click", alternarMicrofone);
botaoCancelar.addEventListener("click", () => pararGravacao(true));
botaoVoltar.addEventListener("click", voltarParaATrilha);

botaoRecomecar.addEventListener("click", () => {
    if (estado() === "gravando") {
        pararGravacao(true);
    }
    abrirAula(aula.licao, true);
});

botaoPular.addEventListener("click", () => {
    if (estado() === "gravando") {
        pararGravacao(true);
    }
    concluirLicao();
    voltarParaATrilha();
});

botaoTeclado.addEventListener("click", () => {
    formulario.hidden = !formulario.hidden;
    if (!formulario.hidden) {
        campoTexto.focus();
    }
    rolarParaOFim();
});

formulario.addEventListener("submit", (evento) => {
    evento.preventDefault();

    const texto = campoTexto.value.trim();
    if (texto === "" || estado() !== "parado") {
        return;
    }

    calarVoz();
    campoTexto.value = "";
    const envio = new FormData();
    envio.append("texto", texto);
    enviar(envio, texto);
});

// Atalhos: barra de espaço liga e desliga o microfone, Esc cancela a gravação.
document.addEventListener("keydown", (evento) => {
    if (telaAula.hidden) {
        return;
    }

    const digitando = ["INPUT", "BUTTON", "TEXTAREA"].includes(document.activeElement.tagName);

    if (evento.code === "Space" && !evento.repeat && !digitando) {
        evento.preventDefault();
        alternarMicrofone();
    } else if (evento.code === "Escape" && estado() === "gravando") {
        pararGravacao(true);
    }
});

carregarCurso();
