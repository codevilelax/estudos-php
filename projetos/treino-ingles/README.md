# Treino de inglês

Um curso de inglês por voz, do zero. A professora Emma aparece na tela, ensina uma coisa
por vez, você repete no microfone e ela corrige. São 24 lições em 4 níveis, mais uma
conversa livre.

## Como abrir

Dê dois cliques em `iniciar.bat`. Ele liga o servidor e abre `http://localhost:8123`
no navegador. Na primeira vez, o navegador pede permissão para usar o microfone.

Para desligar, feche a janela preta do servidor.

## Como usar

- **Lições:** a primeira tela mostra a trilha. Uma lição abre quando a anterior foi
  concluída. A conversa livre fica sempre aberta, no fim da lista.
- **Falar:** toque no microfone, fale e toque de novo para enviar. No teclado, a barra de
  espaço faz o mesmo e o Esc cancela a gravação. O botão do teclado, ao lado do microfone,
  deixa escrever em vez de falar.
- **Falas da Emma:** `Ouvir` repete, `Devagar` repete o inglês mais lento e `Traduzir`
  mostra em português. A frase em inglês em destaque toca quando você clica nela.
- **Pular** marca a lição como concluída. **Recomeçar** começa a lição de novo.
- O progresso fica guardado no navegador, só neste computador. Se você sair no meio de uma
  lição, ela continua de onde parou.

## A chave da IA

O app usa a IA da Groq, no plano gratuito. A chave da conta fica no arquivo
`chave.txt`, nesta pasta, com a chave sozinha na primeira linha.

- O `chave.txt` está no `.gitignore` e **nunca** vai para o GitHub.
- Em outro computador, crie o `chave.txt` de novo com uma chave gerada em
  `console.groq.com` (API Keys).
- A chave é como uma senha: não mande em chat, print ou commit. Se vazar, apague
  no site da Groq e crie outra.

## Como funciona

1. `public/app.js` pede a lista de lições para `public/api/curso.php` e monta a trilha.
2. Na aula, ele grava sua fala e manda o áudio para `public/api/falar.php`, junto com o
   ponto em que a lição está.
3. `src/ia.php` manda o áudio para a IA transformar em texto. Depois manda o texto, as
   últimas falas e o plano da lição (que está em `src/curso.php`) para a IA corrigir e
   responder como a professora.
4. A resposta volta em partes, cada uma marcada como português ou inglês. O navegador lê
   cada parte com a voz do seu idioma, e a Emma mexe a boca enquanto a voz toca.

A chave só é usada no passo 3, dentro do PHP. O navegador nunca recebe a chave, e a
pasta `public` é a única que o servidor mostra.

## Onde mexer

- **Lições (títulos, o que cada uma ensina, ordem):** `src/curso.php`.
- **Jeito de a Emma ensinar e corrigir:** os textos `INSTRUCOES` e `INSTRUCOES_DA_LICAO`,
  no começo de `src/ia.php`.
- **Quantas vezes você pratica no fim de cada lição:** `PRATICAS_POR_LICAO`, no mesmo arquivo.
- **Modelos da IA:** `MODELOS_DE_CONVERSA` e `MODELOS_DE_OUVIDO`, no mesmo arquivo. O primeiro
  de cada lista é o principal, os outros são reservas.
- **Aparência:** `public/estilo.css`. O desenho da Emma fica no começo de `public/index.html`.

## Teste automático

A pasta `testes` tem um teste que abre a tela num Chrome escondido, clica, digita, grava
com um microfone de mentira e confere o resultado. Roda no Git Bash, a partir desta pasta:

- `bash testes/rodar.sh mentira`: confere a tela sem gastar a IA (30 segundos).
- `bash testes/rodar.sh real`: faz a lição 1 inteira com a IA de verdade (uns 3 minutos).
- `bash testes/rodar.sh fotos`: tira fotos das telas, em tamanho de computador e de celular.

A voz e o microfone de verdade o teste não alcança: esses só dá para conferir usando o app.

## Limites do plano gratuito

Valores de 11/11/2026:

- Por dia: 1000 respostas da IA e 2000 transcrições de áudio. Cada fala sua usa uma de cada.
- Por minuto: 8000 tokens por modelo (cada fala de uma lição gasta uns 1300) e 20
  transcrições. Falando muito rápido em seguida, a IA pode pedir uma pausa de alguns segundos.
