# Progresso dos estudos de PHP

## Onde parei

- **Data e computador:** 15/10/2026, `computador 2`
- **Assunto:** `01-fundamentos`: fechando o `while` (com `if` / `else` dentro do loop).
- **O que foi feito:**
  - ex20 (`ex20-metade.php`): etapa 2 concluída, com ajuda. Primeiro pôs o `if` depois do
    `+ 1` e comparou com 6; depois a frase saiu antes do número; ao mover uma linha, copiou em
    vez de mover (`+ 1` duas vezes, contou de 2 em 2). Lição: dentro do loop, **mostrar,
    conferir e só então mudar o número** (o `+ 1` vai por último).
  - ex21 (`ex21-termometro.php`): concluído, com ajuda. Loop infinito (pôs o
    `+ $aumentoPorHora` dentro do `echo`: o `echo` só mostra, não muda a variável); esqueceu
    a `}` antes do `else`; usou `<= 25` em vez de `< 30` (o número do `if` tem que ser o do
    enunciado, senão quebra quando os valores mudam).
  - ex22 (`ex22-tanque.php`, contando para baixo): concluído com pouca ajuda. De novo a linha
    que muda o número veio antes do `if`; corrigiu e trocou para `<= 20` sozinho.
  - ex23 (`ex23-carregando.php`) e ex24 (`ex24-vida.php`, sem etapas): **sozinho, de
    primeira**. Cumpriu o critério combinado para passar ao `for`.
  - ex25 (`ex25-corrida.php`) criado e **ainda não feito**: aquecimento de `while`, a pedido dele.
- **Próximo passo:** fazer o ex25 sozinho para refrescar a memória. Depois começar o `for`,
  um pedaço por mensagem (ideia: mostrar o `for` como um `while` com início, condição e
  `+ 1` juntos numa linha só). Depois `foreach`, funções e `02-web`.
- **Dúvidas pendentes:** nenhuma.
- **Como ensinar (pedido dele):** em assunto novo, explicar **um pedaço por mensagem** e esperar
  ele entender antes de seguir. Uma aula com tudo de uma vez confundiu. Dicas concretas, e o
  comando completo para rodar o arquivo. Ao guiar um exercício, pedir **uma ação por
  mensagem**: ele reclamou de "várias coisas ao mesmo tempo". Quando um exercício juntar uma
  ideia nova (ex: `if` dentro do `while`), passar antes um exercício intermediário e dividir
  o enunciado em etapas. Quando ele disser "não entendi", mostrar o trecho do código dele
  com os valores de uma volta do loop e dar uma ação concreta com o número da linha (ex:
  "mova a linha 29 para cima do `if`"). Isso funcionou melhor que explicar de novo.
- **Ao conferir loops:** rodar com limite de tempo (`timeout 3 php ...`), porque um loop
  infinito trava. Se travar no terminal dele, avisar para apertar Ctrl+C.
- **Aviso:** em 06/10/2026 o histórico do repositório foi reescrito para tirar o Gmail
  dos commits. No outro computador, na primeira vez, usar `git fetch` e
  `git reset --hard origin/main` (se não houver alterações locais) em vez de `git pull`.

## Histórico

- 14/10/2026 (celular, nuvem): etapa 1 do ex20 com ajuda passo a passo (contador começando no fim, chaves, `;`, `/n`); teclado do celular troca `"` por aspas curvas.
- 09/10/2026 (`computador 2`): prática de `while`, ex15 a ex19 (os três últimos sozinho); termômetro adiado e dividido em etapas (ex20 e ex21).
- 08/10/2026 (`computador 2`): ex11 e ex12 concluídos (`else` sem condição, ordem com `>=`); primeiro loop (`while`, exemplo, ex13 e ex14).
- 07/10/2026 (`computador 2`): ex10 concluído (boletim com faltas, `if` / `elseif` em ordem).
- 06/10/2026 (`vilela`): ex09 concluído (`;` no fim da linha anterior ao erro, economia sem negativo).
- 06/10/2026 (`vilela`): ex08 concluído (arrays: índice começa em 0, `count`, `\n`).
- 05/10/2026 (`vilela`): ex07 concluído; enunciados dos exercícios 8 a 10 criados.
- 05/10/2026 (`vilela`): sincronização configurada (CLAUDE.md e PROGRESSO.md).
- 05/10/2026 (`computador 2`): estrutura inicial e exercícios 1 a 6 de fundamentos.
