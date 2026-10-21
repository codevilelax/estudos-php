# Progresso dos estudos de PHP

## Onde parei

- **Data e computador:** 21/10/2026, `computador 2`
- **Assunto:** `01-fundamentos`: `for` encerrado.
- **O que foi feito:**
  - ex32 (`ex32-corrida.php`, `for` com conta dentro e `if` / `else` com `$meta`): **com
    ajuda**. Travou em: colocar a conta como 4ª parte dentro dos parênteses do `for` (erro de
    sintaxe); `echo` da mensagem antes do `echo` da linha (cada mensagem caía na linha
    anterior e a da semana 6 parecia sumir); `<= 8` na divisa (8 km dava "continua"); `8` e
    `$semana + $semana` fixos em vez de `$meta` e `$kmPorSemana`. Corrigiu tudo com dicas.
  - ex33 (`ex33-cinema.php`, mesma estrutura do ex32 com a divisa invertida: R$ 40 ainda
    cabe, então `<=`): **sozinho e sem ajuda**, certo de primeira.
- **Próximo passo:** começar o `foreach` (loop para percorrer arrays; arrays vistos no ex08).
  É assunto novo: um pedaço por mensagem. Depois: `+=` / `-=` (quando ele quiser), funções e
  `02-web`.
- **Dúvidas pendentes:** nenhuma.
- **Pendente:** no perfil (`codevilelax/codevilelax`), o "Sobre mim" diz que o objetivo é
  "Engenharia de Dados", e o portfólio novo diz "desenvolvedor". Ele pediu para deixar a troca
  para depois: perguntar de novo no próximo fim de sessão.
- **Como ensinar (pedido dele):** em assunto novo, explicar **um pedaço por mensagem** e esperar
  ele entender antes de seguir. Uma aula com tudo de uma vez confundiu. Dicas concretas, e o
  comando para rodar o arquivo com o **caminho absoluto** neste computador (o relativo não
  funcionou no terminal dele). Quando ele pedir "o terminal do ex N", mandar **só o
  comando** para ele rodar: não rodar o arquivo, não mostrar a saída e não comentar erro (ele
  quer ver sozinho antes de pedir ajuda). Ao guiar um exercício, pedir **uma ação por
  mensagem**: ele reclamou de "várias coisas ao mesmo tempo". Quando um exercício juntar uma
  ideia nova (ex: `if` dentro do `while`), passar antes um exercício intermediário e dividir
  o enunciado em etapas. Quando ele disser "não entendi", mostrar o trecho do código dele
  com os valores de uma volta do loop e dar uma ação concreta com o número da linha (ex:
  "mova a linha 29 para cima do `if`"). Isso funcionou melhor que explicar de novo.
- **Ao conferir loops:** rodar com limite de tempo (`timeout 3 php ...`), porque um loop
  infinito trava. Se travar no terminal dele, avisar para apertar Ctrl+C.
- **Aviso:** em 06/10/2026 e de novo em 21/10/2026 o histórico do repositório foi reescrito
  (em 06/10 para tirar o Gmail dos commits; em 21/10 para deixar neutro o commit de 19/10).
  No outro computador (`vilela`), na primeira vez depois de 21/10, usar `git fetch` e
  `git reset --hard origin/main` (se não houver alterações locais) em vez de `git pull`.

## Histórico

- 20/10/2026 (`vilela`): ex30 e ex31 de `for` sozinho (ex30 com dica na divisa); atalho `$i++` explicado; ex32 criado.
- 16/10/2026 (`computador 2`): ex25 e ex26 sozinho (`while` encerrado); começo do `for`, ex27 a ex29 (quase tudo sozinho); ex30 criado.
- 15/10/2026 (`computador 2`): ex20 a ex24 de `while` com `if` / `else` (ex20 a ex22 com ajuda, ex23 e ex24 sozinho); ex25 criado como aquecimento.
- 14/10/2026 (celular, nuvem): etapa 1 do ex20 com ajuda passo a passo (contador começando no fim, chaves, `;`, `/n`); teclado do celular troca `"` por aspas curvas.
- 09/10/2026 (`computador 2`): prática de `while`, ex15 a ex19 (os três últimos sozinho); termômetro adiado e dividido em etapas (ex20 e ex21).
- 08/10/2026 (`computador 2`): ex11 e ex12 concluídos (`else` sem condição, ordem com `>=`); primeiro loop (`while`, exemplo, ex13 e ex14).
- 07/10/2026 (`computador 2`): ex10 concluído (boletim com faltas, `if` / `elseif` em ordem).
- 06/10/2026 (`vilela`): ex09 concluído (`;` no fim da linha anterior ao erro, economia sem negativo).
- 06/10/2026 (`vilela`): ex08 concluído (arrays: índice começa em 0, `count`, `\n`).
- 05/10/2026 (`vilela`): ex07 concluído; enunciados dos exercícios 8 a 10 criados.
- 05/10/2026 (`vilela`): sincronização configurada (CLAUDE.md e PROGRESSO.md).
- 05/10/2026 (`computador 2`): estrutura inicial e exercícios 1 a 6 de fundamentos.
