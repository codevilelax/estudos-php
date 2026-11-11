# Treino de inglês

Um parceiro de conversa em inglês: você fala no microfone, a IA responde em voz alta
e mostra o jeito certo quando você erra.

## Como abrir

Dê dois cliques em `iniciar.bat`. Ele liga o servidor e abre `http://localhost:8123`
no navegador. Na primeira vez, o navegador pede permissão para usar o microfone.

Para desligar, feche a janela preta do servidor.

## A chave da IA

O app usa a IA da Groq, no plano gratuito. A chave da conta fica no arquivo
`chave.txt`, nesta pasta, com a chave sozinha na primeira linha.

- O `chave.txt` está no `.gitignore` e **nunca** vai para o GitHub.
- Em outro computador, crie o `chave.txt` de novo com uma chave gerada em
  `console.groq.com` (API Keys).
- A chave é como uma senha: não mande em chat, print ou commit. Se vazar, apague
  no site da Groq e crie outra.

## Como funciona

1. `public/app.js` grava sua fala e manda o áudio para `public/api/falar.php`.
2. `src/ia.php` manda o áudio para a IA transformar em texto, e depois manda o texto
   (com as últimas falas da conversa) para a IA corrigir e responder.
3. A resposta volta para a tela, e o navegador lê em voz alta.

A chave só é usada no passo 2, dentro do PHP. O navegador nunca recebe a chave, e a
pasta `public` é a única que o servidor mostra.

## Onde mexer

- **Jeito de a IA conversar e corrigir:** o texto `INSTRUCOES`, no começo de `src/ia.php`.
- **Modelo da IA:** `MODELO_CONVERSA`, no mesmo arquivo.
- **Aparência:** `public/estilo.css`.

## Limites do plano gratuito

Por dia, 1000 respostas da IA e 2000 transcrições de áudio (valores de 11/11/2026).
Cada fala sua usa uma de cada.
