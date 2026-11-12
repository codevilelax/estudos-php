// Roda ANTES do app.js: prepara o que fica guardado, troca a voz por uma de mentira
// (para o computador não falar alto durante o teste) e registra os pedidos ao servidor.
(function () {
    const params = new URLSearchParams(location.search);
    const T = (window.__teste = {
        nome: params.get("teste") || "trilha",
        params,
        conferencias: [],
        falado: [],
        pedidos: [],
        errosJs: [],
        emmaVisto: {},
        turnos: [],
    });

    window.addEventListener("error", (e) => {
        T.errosJs.push(e.message + " @" + String(e.filename || "").split("/").pop() + ":" + e.lineno);
    });
    window.addEventListener("unhandledrejection", (e) => {
        T.errosJs.push("promessa: " + ((e.reason && e.reason.message) || e.reason));
    });

    // ---------- Voz de mentira ----------

    const vozes = [
        { name: "Microsoft David - English (United States)", lang: "en-US" },
        { name: "Microsoft Zira - English (United States)", lang: "en-US" },
        { name: "Microsoft Aria Online (Natural) - English (United States)", lang: "en-US" },
        { name: "Microsoft Sonia Online (Natural) - English (United Kingdom)", lang: "en-GB" },
        { name: "Microsoft Daniel - Portuguese (Brazil)", lang: "pt-BR" },
        { name: "Microsoft Maria - Portuguese (Brazil)", lang: "pt-BR" },
        { name: "Microsoft Francisca Online (Natural) - Portuguese (Brazil)", lang: "pt-BR" },
        { name: "Google português do Brasil", lang: "pt-BR" },
    ];

    const falaLonga = params.get("falaLonga") === "1";
    let fimDaFala = 0;
    const vozFalsa = {
        get speaking() {
            return Date.now() < fimDaFala;
        },
        getVoices() {
            return vozes;
        },
        speak(fala) {
            T.falado.push({ texto: fala.text, lang: fala.lang, rate: fala.rate, voz: fala.voice ? fala.voice.name : null });
            const duracao = falaLonga ? 600000 : Math.min(1500, 40 * fala.text.length);
            fimDaFala = Math.max(fimDaFala, Date.now()) + duracao;
        },
        cancel() {
            fimDaFala = 0;
            T.falado.push({ cancelou: true });
        },
        addEventListener() {},
        removeEventListener() {},
    };
    Object.defineProperty(window, "speechSynthesis", { value: vozFalsa, configurable: true });
    window.SpeechSynthesisUtterance = function (texto) {
        this.text = texto;
        this.voice = null;
        this.lang = "";
        this.rate = 1;
    };
    T.vozTrocada = window.speechSynthesis === vozFalsa;

    // ---------- O que fica guardado ----------

    const pt = (texto) => ({ idioma: "pt", texto });
    const en = (texto) => ({ idioma: "en", texto });

    const CONVERSA = [
        {
            papel: "ia",
            falas: [pt("Oi! Hoje a gente vai aprender a se apresentar. A primeira frase é:"), en("My name is Emma."), pt("Quer dizer: meu nome é Emma. Agora fala a sua, com o seu nome.")],
            traducao: "",
        },
        { papel: "voce", texto: "My name Alex", correcao: "My name is Alex.", explicacao: "Faltou o \"is\": em inglês a frase precisa do verbo.", acertou: false },
        {
            papel: "ia",
            falas: [pt("Quase! Faltou uma palavrinha. O certo é:"), en("My name is Alex."), pt("Repete pra mim.")],
            traducao: "",
        },
        { papel: "voce", texto: "My name is Alex.", correcao: "", explicacao: "", acertou: true },
        {
            papel: "ia",
            falas: [pt("Perfeito! A próxima é:"), en("What's your name?"), pt("Quer dizer: qual é o seu nome? Repete pra mim.")],
            traducao: "",
        },
    ];

    const todas = [];
    for (let i = 1; i <= 24; i++) {
        todas.push(i);
    }

    const SEMENTES = {
        andamento: {
            concluidas: [1],
            aula: { licao: 2, fase: "ensinar", passo: 2, turno: 2, progresso: 14, concluida: false, conversa: CONVERSA },
        },
        fim: {
            concluidas: [1, 2],
            aula: { licao: 2, fase: "praticar", passo: 3, turno: 8, progresso: 100, concluida: true, conversa: CONVERSA },
        },
        metade: { concluidas: todas.slice(0, 8), aula: null },
        tudo: { concluidas: todas, aula: null },
        estragado: "isto não é JSON {",
    };

    const semente = params.get("semente");
    localStorage.removeItem("treino-ingles-v2");
    if (semente && SEMENTES[semente]) {
        const valor = SEMENTES[semente];
        localStorage.setItem("treino-ingles-v2", typeof valor === "string" ? valor : JSON.stringify(valor));
    }

    // ---------- Pedidos ao servidor: registro e respostas de mentira ----------

    const base = { correcao: "", explicacao: "", acertou: false, traducao: "", concluida: false };
    const PRONTAS = [
        Object.assign({}, base, {
            falas: [pt("Oi! Eu sou a Emma. Hoje a gente vai aprender a cumprimentar as pessoas. A primeira é:"), en("Hello."), pt("Quer dizer olá. Repete pra mim.")],
            fase: "ensinar",
            passo: 1,
            progresso: 0,
        }),
        Object.assign({}, base, {
            correcao: "Good morning.",
            explicacao: "A ordem é ao contrário: primeiro \"good\", depois \"morning\".",
            falas: [pt("Quase! O certo é:"), en("Good morning."), pt("Tenta de novo.")],
            fase: "ensinar",
            passo: 2,
            progresso: 12,
        }),
        Object.assign({}, base, {
            acertou: true,
            falas: [pt("Mandou bem! Agora vamos praticar. É de manhã e você encontra um amigo. O que você fala?")],
            fase: "praticar",
            passo: 2,
            progresso: 90,
        }),
        Object.assign({}, base, {
            acertou: true,
            falas: [pt("Perfeito! Você terminou a lição. Agora você já sabe cumprimentar alguém em inglês.")],
            fase: "praticar",
            passo: 3,
            progresso: 100,
            concluida: true,
        }),
    ];

    const espera = (ms) => new Promise((resolver) => setTimeout(resolver, ms));
    const fetchReal = window.fetch.bind(window);
    T.fetchReal = fetchReal;
    T.falso = params.get("falso") || ""; // o roteiro pode trocar no meio do teste
    T.demora = Number(params.get("demora") || 200);
    let proximaPronta = 0;
    let aberturas = 0;

    function respostaDeMentira(registro) {
        const ehFalar = registro.url.includes("api/falar.php");
        const ehCurso = registro.url.includes("api/curso.php");

        if (T.falso === "sem-servidor" && ehCurso) {
            return { falha: true };
        }
        if (!ehFalar || T.falso === "") {
            return null;
        }
        if (T.falso === "rede") {
            return { falha: true };
        }

        const abertura = registro.campos && registro.campos.comecar === "1";
        if (abertura) {
            aberturas++;
            if (T.falso === "erro-abertura" && aberturas === 1) {
                return { json: { ok: false, erro: "A IA pediu uma pausa. Espere alguns segundos e tente de novo.", espera: 5 } };
            }
            proximaPronta = 1;
            return { json: Object.assign({ ok: true, voce: null }, PRONTAS[0]) };
        }

        const pronta = PRONTAS[Math.min(proximaPronta, PRONTAS.length - 1)];
        proximaPronta++;
        return { json: Object.assign({ ok: true, voce: registro.campos.texto || "(fala gravada)" }, pronta) };
    }

    window.fetch = async function (url, opcoes) {
        const registro = { url: String(url) };
        if (opcoes && opcoes.body instanceof FormData) {
            registro.campos = {};
            for (const [chave, valor] of opcoes.body.entries()) {
                if (valor instanceof Blob) {
                    registro.campos[chave] = "(áudio " + valor.type + ", " + valor.size + " bytes)";
                } else if (chave === "historico") {
                    registro.campos[chave] = JSON.parse(valor).length + " falas";
                    registro.ultimaDoHistorico = JSON.parse(valor).slice(-1)[0] || null;
                } else {
                    registro.campos[chave] = valor;
                }
            }
        }
        T.pedidos.push(registro);
        const inicio = Date.now();

        const mentira = respostaDeMentira(registro);
        if (mentira) {
            await espera(T.demora);
            if (mentira.falha) {
                registro.resposta = "(falha de rede de mentira)";
                throw new TypeError("Failed to fetch");
            }
            registro.resposta = mentira.json;
            return new Response(JSON.stringify(mentira.json), { headers: { "Content-Type": "application/json" } });
        }

        const resposta = await fetchReal(url, opcoes);
        registro.ms = Date.now() - inicio;
        try {
            registro.resposta = await resposta.clone().json();
        } catch (erro) {
            registro.resposta = "(não é JSON, código " + resposta.status + ")";
        }
        return resposta;
    };
})();
