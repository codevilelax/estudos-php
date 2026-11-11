<?php

// O curso: 4 níveis, 24 lições, do zero até a conversa de verdade.
//
// Cada lição tem:
// - "titulo" e "resumo": aparecem na tela, em português.
// - "objetivo" e "itens": vão para a IA, em inglês. É o plano de aula que ela segue,
//   ensinando um item por vez, na ordem.
//
// Para mudar ou criar uma lição, é só mexer aqui. O "id" não pode repetir.

const NIVEIS = [
    1 => [
        "nome" => "Primeiros passos",
        // Quanto português a professora usa neste nível.
        "idioma" => "The student knows almost no English. Everything you say is in Portuguese, including praise and instructions. English is only for the words and phrases being taught, each in its own \"en\" part.",
    ],
    2 => [
        "nome" => "Dia a dia",
        "idioma" => "Explain in Portuguese, but use very simple English for praise and for short instructions the student already knows (Great! Very good! Repeat, please. And you?).",
    ],
    3 => [
        "nome" => "Contando histórias",
        "idioma" => "Speak simple English most of the time. Use Portuguese only to explain a grammar point or a new word.",
    ],
    4 => [
        "nome" => "Conversa de verdade",
        "idioma" => "Speak only English, clear and natural. Use Portuguese only if the student is lost.",
    ],
];

const LICOES = [
    // ---------- Nível 1: Primeiros passos ----------
    [
        "id" => 1,
        "nivel" => 1,
        "titulo" => "Cumprimentos",
        "resumo" => "Dizer oi, tchau e perguntar como a pessoa está.",
        "objetivo" => "Greet someone, ask how they are, answer, and say goodbye.",
        "itens" => ["Hello / Hi", "Good morning", "Good night", "How are you?", "I'm fine, thanks", "Goodbye / Bye"],
    ],
    [
        "id" => 2,
        "nivel" => 1,
        "titulo" => "Apresentação",
        "resumo" => "Falar seu nome e de onde você é.",
        "objetivo" => "Introduce yourself: say your name and where you are from, and ask the same.",
        "itens" => ["My name is ...", "What's your name?", "Nice to meet you", "I'm from Brazil", "Where are you from?"],
    ],
    [
        "id" => 3,
        "nivel" => 1,
        "titulo" => "Verbo to be",
        "resumo" => "I am, you are, he is: o verbo ser e estar.",
        "objetivo" => "Use the verb to be in the present to describe people (happy, tired, hungry, a student, my friend).",
        "itens" => ["I am ... (I'm)", "You are ... (You're)", "He is ... / She is ...", "We are ... / They are ...", "I am not ..."],
    ],
    [
        "id" => 4,
        "nivel" => 1,
        "titulo" => "Números e idade",
        "resumo" => "Contar até 20 e falar quantos anos você tem.",
        "objetivo" => "Count from 1 to 20, ask someone's age and say your own.",
        "itens" => ["Numbers 1 to 5", "Numbers 6 to 10", "Numbers 11 to 20", "How old are you?", "I am ... years old"],
    ],
    [
        "id" => 5,
        "nivel" => 1,
        "titulo" => "Família",
        "resumo" => "Falar da sua família com I have.",
        "objetivo" => "Name family members and say who you have in your family.",
        "itens" => ["mother, father", "brother, sister", "I have a brother", "I don't have a sister", "This is my mother"],
    ],
    [
        "id" => 6,
        "nivel" => 1,
        "titulo" => "Gostos",
        "resumo" => "Dizer do que você gosta e do que não gosta.",
        "objetivo" => "Say what you like and don't like (pizza, soccer, music, games, coffee) and ask someone else.",
        "itens" => ["I like ...", "I don't like ...", "I love ...", "Do you like ...?", "Yes, I do / No, I don't"],
    ],

    // ---------- Nível 2: Dia a dia ----------
    [
        "id" => 7,
        "nivel" => 2,
        "titulo" => "Rotina",
        "resumo" => "Contar o que você faz todo dia.",
        "objetivo" => "Describe a daily routine with the present simple.",
        "itens" => ["I wake up at ...", "I go to work / I go to school", "I have lunch", "I go home", "I go to bed at ..."],
    ],
    [
        "id" => 8,
        "nivel" => 2,
        "titulo" => "Perguntas com do e does",
        "resumo" => "Fazer perguntas e falar de outras pessoas.",
        "objetivo" => "Ask and answer present simple questions, and use the third person -s.",
        "itens" => ["Do you ...? Yes, I do / No, I don't", "He likes ... / She works ... (the -s)", "Does he ...? / Does she ...?", "He doesn't ...", "What do you do?"],
    ],
    [
        "id" => 9,
        "nivel" => 2,
        "titulo" => "Horas e dias",
        "resumo" => "Perguntar as horas e falar os dias da semana.",
        "objetivo" => "Tell the time and say when things happen.",
        "itens" => ["What time is it?", "It's seven o'clock", "It's half past eight", "Days of the week", "on Monday, in the morning, at night"],
    ],
    [
        "id" => 10,
        "nivel" => 2,
        "titulo" => "Comida e pedidos",
        "resumo" => "Pedir comida e bebida com educação.",
        "objetivo" => "Order food and drinks politely (water, coffee, juice, a burger) and ask the price.",
        "itens" => ["I'm hungry / I'm thirsty", "I would like ..., please", "Can I have ..., please?", "How much is it?", "The bill, please"],
    ],
    [
        "id" => 11,
        "nivel" => 2,
        "titulo" => "Casa e cidade",
        "resumo" => "Dizer o que tem em um lugar com there is e there are.",
        "objetivo" => "Describe what exists in a house or a city, and where things are.",
        "itens" => ["There is a ...", "There are ...", "Is there a ... near here?", "in, on, under, next to", "supermarket, pharmacy, bank"],
    ],
    [
        "id" => 12,
        "nivel" => 2,
        "titulo" => "Can e can't",
        "resumo" => "Falar o que você sabe e não sabe fazer.",
        "objetivo" => "Talk about abilities (swim, cook, drive, speak English, play the guitar).",
        "itens" => ["I can ...", "I can't ...", "Can you ...?", "Yes, I can / No, I can't", "He can ... but he can't ..."],
    ],

    // ---------- Nível 3: Contando histórias ----------
    [
        "id" => 13,
        "nivel" => 3,
        "titulo" => "Passado do to be",
        "resumo" => "Was e were: como as coisas eram.",
        "objetivo" => "Use was and were to talk about where you were and how things were.",
        "itens" => ["I was ...", "You were ... / We were ... / They were ...", "He was ... / She was ...", "I wasn't ... / We weren't ...", "Where were you yesterday?"],
    ],
    [
        "id" => 14,
        "nivel" => 3,
        "titulo" => "Passado regular",
        "resumo" => "Contar o que você fez com os verbos em -ed.",
        "objetivo" => "Talk about the past with regular verbs (worked, played, watched, studied).",
        "itens" => ["worked, played, watched, studied (-ed)", "I played soccer yesterday", "I didn't work yesterday", "Did you watch ...?", "Yes, I did / No, I didn't"],
    ],
    [
        "id" => 15,
        "nivel" => 3,
        "titulo" => "Passado irregular",
        "resumo" => "Went, had, ate: os verbos que mudam no passado.",
        "objetivo" => "Use common irregular past verbs to tell what happened.",
        "itens" => ["go → went", "have → had", "eat → ate", "see → saw", "buy → bought", "What did you do last weekend?"],
    ],
    [
        "id" => 16,
        "nivel" => 3,
        "titulo" => "Futuro com going to",
        "resumo" => "Falar dos seus planos.",
        "objetivo" => "Talk about plans with going to (tomorrow, tonight, next week).",
        "itens" => ["I am going to ...", "I'm not going to ...", "Are you going to ...?", "What are you going to do tomorrow?", "tomorrow, tonight, next week"],
    ],
    [
        "id" => 17,
        "nivel" => 3,
        "titulo" => "Futuro com will",
        "resumo" => "Fazer promessas, ofertas e previsões.",
        "objetivo" => "Use will for promises, offers and predictions.",
        "itens" => ["I will ... (I'll)", "I won't ...", "Will you ...?", "I think it will ...", "I'll help you"],
    ],
    [
        "id" => 18,
        "nivel" => 3,
        "titulo" => "Comparações",
        "resumo" => "Maior, melhor, mais caro: comparar coisas.",
        "objetivo" => "Compare two things and say which is the best.",
        "itens" => ["bigger than, cheaper than", "more expensive than", "better than / worse than", "the best / the biggest", "as ... as"],
    ],

    // ---------- Nível 4: Conversa de verdade ----------
    [
        "id" => 19,
        "nivel" => 4,
        "titulo" => "O que está acontecendo agora",
        "resumo" => "I am doing: falar do que acontece neste momento.",
        "objetivo" => "Use the present continuous and contrast it with routines.",
        "itens" => ["I am working", "What are you doing?", "He isn't sleeping", "I usually ..., but today I am ...", "right now, at the moment"],
    ],
    [
        "id" => 20,
        "nivel" => 4,
        "titulo" => "Experiências de vida",
        "resumo" => "Have you ever: contar o que você já fez na vida.",
        "objetivo" => "Use the present perfect for life experiences and contrast it with the past simple.",
        "itens" => ["Have you ever ...?", "I have been to ...", "I have never ...", "Yes, I have / No, I haven't", "I went there in 2020 (past simple for a finished time)"],
    ],
    [
        "id" => 21,
        "nivel" => 4,
        "titulo" => "Opiniões e conselhos",
        "resumo" => "Dar sua opinião e aconselhar alguém.",
        "objetivo" => "Give opinions, agree or disagree, and give advice.",
        "itens" => ["I think ... / In my opinion ...", "I agree / I don't agree", "You should ...", "You shouldn't ...", "What do you think about ...?"],
    ],
    [
        "id" => 22,
        "nivel" => 4,
        "titulo" => "E se...?",
        "resumo" => "Falar de possibilidades com if.",
        "objetivo" => "Use the first and second conditionals.",
        "itens" => ["If it rains, I will stay home", "If I have time, I'll ...", "If I had money, I would ...", "What would you do if ...?", "I would ... / I wouldn't ..."],
    ],
    [
        "id" => 23,
        "nivel" => 4,
        "titulo" => "Viagem",
        "resumo" => "Se virar em aeroporto, hotel e na rua.",
        "objetivo" => "Handle travel situations by role-play: airport, hotel and asking for directions.",
        "itens" => ["I'd like to check in", "I have a reservation", "Where is the gate?", "How do I get to ...?", "Could you help me, please?", "Can I pay by card?"],
    ],
    [
        "id" => 24,
        "nivel" => 4,
        "titulo" => "Falar de você",
        "resumo" => "Contar sua história e seus objetivos, como numa entrevista.",
        "objetivo" => "Talk about yourself, your experience and your goals, as in a job interview role-play.",
        "itens" => ["Tell me about yourself", "I have experience in ...", "I am good at ...", "I want to improve my ...", "My goal is to ..."],
    ],
];

// Devolve a lição com este id, ou null se não existir.
function acharLicao($id)
{
    foreach (LICOES as $licao) {
        if ($licao["id"] == $id) {
            return $licao;
        }
    }
    return null;
}
