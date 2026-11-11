"use strict";

// A tela do treino: grava a fala, manda para o servidor (api/falar.php),
// mostra a correção e a resposta da IA e lê a resposta em voz alta.

const GUARDADO = "treino-ingles-conversa";
const TEMPO_MINIMO = 600; // gravação mais curta que isso (em milissegundos) é descartada
const TEMPO_MAXIMO = 60000; // depois disso a gravação é enviada sozinha
const FALAS_ENVIADAS = 12; // quantas falas antigas vão junto em cada pedido

const SAUDACAO = {
    papel: "ia",
    texto: "Hi! I'm your English practice partner. What would you like to talk about today?",
    traducao: "Oi! Sou seu parceiro para treinar inglês. Sobre o que você quer conversar hoje?",
};

const DICAS = {
    parado: "Toque no microfone e fale em inglês",
    pensando: "Pensando…",
};

const telaInicio = document.getElementById("inicio");
const lista = document.getElementById("conversa");
const conteudo = document.getElementById("conteudo");
const barra = document.getElementById("barra");
const aviso = document.getElementById("aviso");
const botaoComecar = document.getElementById("comecar");
const botaoNova = document.getElementById("nova");
const botaoMicrofone = document.getElementById("microfone");
const botaoCancelar = document.getElementById("cancelar");
const botaoTeclado = document.getElementById("teclado");
const formulario = document.getElementById("digitar");
const campoTexto = document.getElementById("texto");

let conversa = lerGuardado();
let gravador = null;
let pedacos = [];
let inicioDaGravacao = 0;
let relogio = null;
let jogarFora = false;

// ---------- Conversa guardada no navegador ----------

function lerGuardado() {
    try {
        const lido = JSON.parse(localStorage.getItem(GUARDADO));
        return Array.isArray(lido) ? lido : [];
    } catch (erro) {
        return [];
    }
}

function guardar() {
    try {
        localStorage.setItem(GUARDADO, JSON.stringify(conversa));
    } catch (erro) {
        // Sem espaço ou em janela anônima: a conversa só não fica guardada.
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

// Escolhe a voz em inglês mais natural que o navegador tiver.
function melhorVoz() {
    let melhor = null;
    let melhorNota = -1;

    for (const voz of vozes) {
        const idioma = voz.lang.replace("_", "-").toLowerCase();
        if (!idioma.startsWith("en")) {
            continue;
        }

        let nota = 0;
        if (/natural/i.test(voz.name)) nota += 4;
        if (/google us english/i.test(voz.name)) nota += 3;
        if (idioma === "en-us") nota += 2;
        if (/aria|jenny|guy|ava|andrew|emma/i.test(voz.name)) nota += 1;

        if (nota > melhorNota) {
            melhorNota = nota;
            melhor = voz;
        }
    }

    return melhor;
}

function falar(texto, devagar) {
    if (!window.speechSynthesis) {
        return;
    }

    speechSynthesis.cancel();

    const fala = new SpeechSynthesisUtterance(texto);
    const voz = melhorVoz();
    if (voz) {
        fala.voice = voz;
    }
    fala.lang = voz ? voz.lang : "en-US";
    fala.rate = devagar ? 0.7 : 0.95;
    speechSynthesis.speak(fala);
}

function calarVoz() {
    if (window.speechSynthesis) {
        speechSynthesis.cancel();
    }
}

// ---------- Montagem da tela ----------

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

function botaoPequeno(rotulo, aoClicar) {
    const botao = criar("button", "botao-pequeno", rotulo);
    botao.type = "button";
    botao.addEventListener("click", aoClicar);
    return botao;
}

function botoesDeOuvir(texto) {
    const acoes = criar("div", "acoes");
    acoes.append(
        botaoPequeno("Ouvir", () => falar(texto, false)),
        botaoPequeno("Devagar", () => falar(texto, true))
    );
    return acoes;
}

function rolarParaOFim() {
    conteudo.scrollTop = conteudo.scrollHeight;
}

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
    const ingles = criar("p", "", item.texto);
    ingles.lang = "en";
    fala.append(ingles);

    const acoes = botoesDeOuvir(item.texto);

    if (item.traducao) {
        const traducao = criar("p", "traducao", item.traducao);
        traducao.hidden = true;
        fala.append(traducao);

        const botao = botaoPequeno("Traduzir", () => {
            traducao.hidden = !traducao.hidden;
            botao.textContent = traducao.hidden ? "Traduzir" : "Esconder tradução";
        });
        acoes.append(botao);
    }

    bloco.append(fala, acoes);
    lista.append(bloco);
    rolarParaOFim();
}

function mostrarFalaVoce(item) {
    const bloco = criar("div", "bloco voce");
    const fala = criar("div", "fala", item.texto);
    fala.lang = "en";
    bloco.append(fala);

    if (item.correcao) {
        const cartao = criar("div", "correcao");
        const frase = criar("p");
        frase.lang = "en";
        frase.append(destacar(item.texto, item.correcao));
        cartao.append(criar("span", "etiqueta", "Jeito certo"), frase);

        if (item.explicacao) {
            cartao.append(criar("p", "explicacao", item.explicacao));
        }

        cartao.append(botoesDeOuvir(item.correcao));
        bloco.append(cartao);
    } else {
        bloco.append(criar("span", "sem-erros", "✓ Sem erros"));
    }

    lista.append(bloco);
    rolarParaOFim();
}

// Balão provisório enquanto a resposta não chega.
function mostrarEspera(texto) {
    const bloco = criar("div", "bloco voce");
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

function mostrarConversa() {
    lista.textContent = "";
    for (const item of conversa) {
        if (item.papel === "ia") {
            mostrarFalaIA(item);
        } else {
            mostrarFalaVoce(item);
        }
    }
}

// ---------- Estado da tela ----------

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
    if (estado() !== "parado") {
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
            mudarEstado("parado");
        } else if (duracao < TEMPO_MINIMO || audio.size === 0) {
            mudarEstado("parado");
            avisar("Ficou muito curto. Toque, fale e toque de novo.", true);
        } else {
            const dados = new FormData();
            dados.append("audio", audio, "fala");
            enviar(dados, "");
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

async function enviar(dados, textoDigitado) {
    const anteriores = conversa.slice(-FALAS_ENVIADAS).map((item) => ({ papel: item.papel, texto: item.texto }));
    dados.append("historico", JSON.stringify(anteriores));

    mudarEstado("pensando");
    const espera = mostrarEspera(textoDigitado);

    let resposta;
    try {
        const retorno = await fetch("api/falar.php", { method: "POST", body: dados });
        resposta = await retorno.json();
    } catch (erro) {
        resposta = { ok: false, erro: "Não consegui falar com o servidor. Confira se ele está ligado." };
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
    };
    const ia = { papel: "ia", texto: resposta.resposta, traducao: resposta.traducao };

    conversa.push(voce, ia);
    guardar();
    mostrarFalaVoce(voce);
    mostrarFalaIA(ia);
    falar(ia.texto, false);
}

// ---------- Começo e botões ----------

function comecarConversa() {
    telaInicio.hidden = true;
    lista.hidden = false;
    barra.hidden = false;
    botaoNova.hidden = false;
    mudarEstado("parado");

    if (conversa.length === 0) {
        conversa.push(SAUDACAO);
        guardar();
        mostrarConversa();
        falar(SAUDACAO.texto, false);
    } else {
        mostrarConversa();
    }
}

if (conversa.length > 0) {
    botaoComecar.textContent = "Continuar conversa";
}

botaoComecar.addEventListener("click", comecarConversa);
botaoMicrofone.addEventListener("click", alternarMicrofone);
botaoCancelar.addEventListener("click", () => pararGravacao(true));

botaoNova.addEventListener("click", () => {
    if (estado() === "gravando") {
        pararGravacao(true);
    }
    if (estado() === "pensando") {
        return;
    }
    calarVoz();
    conversa = [];
    comecarConversa();
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
    const dados = new FormData();
    dados.append("texto", texto);
    enviar(dados, texto);
});

// Atalhos: barra de espaço liga e desliga o microfone, Esc cancela a gravação.
document.addEventListener("keydown", (evento) => {
    const digitando = ["INPUT", "BUTTON", "TEXTAREA"].includes(document.activeElement.tagName);

    if (evento.code === "Space" && !evento.repeat && !digitando && !barra.hidden) {
        evento.preventDefault();
        alternarMicrofone();
    } else if (evento.code === "Escape" && estado() === "gravando") {
        pararGravacao(true);
    }
});
