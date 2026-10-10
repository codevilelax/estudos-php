# Progresso dos estudos de PHP

## Onde parei

- **Data e computador:** 09/10/2026, `computador 2`
- **Assunto:** `01-fundamentos`: praticando o `while`. Decidiu ficar uns dias só no `while`,
  "até ficar craque", antes de começar o `for`.
- **O que foi feito:**
  - ex15 (`ex15-tabuada.php`, tabuada do 7): **concluído, com bastante ajuda**.
    - Erros no caminho: usou o `$numero` (fixo) como contador e aumentava ele; esqueceu de
      aumentar o contador (loop infinito); somava antes do `echo` e perdia o `7 X 1`.
    - Descobriu sozinho outro jeito de contar: começar em 0, usar `< 10` e somar antes do
      `echo`. Achou que o Claude tinha errado; as duas formas funcionam.
  - ex16 (`ex16-cofrinho.php`, R$ 50 por mês durante 12 meses): **concluído, com ajuda passo a
    passo**. Repetiu o erro de aumentar a variável fixa (`$valorMensal`) e começou o contador
    em 12 (o fim, não o começo). Esqueceu de salvar uma vez. Viu o erro
    "unexpected end of file" (faltava o `}`).
  - ex17 (`ex17-ingressos.php`, preço de 1 a 8 ingressos): **sozinho, de primeira**. Separou o
    valor fixo do contador. Usou o jeito "começa em 1, `<=`, soma depois do `echo`".
  - ex18 (`ex18-descarregando.php`, bateria descendo de 20 em 20): **sozinho**. Ajustes:
    usar a variável `$gastoPorHora` em vez do número 20 escrito direto, e apagar uma linha em
    branco antes do `<?php` (ela aparece na saída).
  - ex19 (`ex19-aniversarios.php`, ano e idade): **sozinho, de primeira**, com duas variáveis
    mudando no mesmo loop.
  - O termômetro (`if` / `else` dentro do `while`) foi difícil demais. Arrumou o loop, mas
    travou no `if`: colocou depois do `}` do loop e fez um `==` para cada temperatura. Pediu
    o código completo e o Claude mostrou. **Ficou combinado refazer do zero, em etapas:** o
    termômetro virou o ex21, e o ex20 agora é um exercício mais fácil antes dele.
  - Anotou no caderno: a forma do `while`, os dois jeitos de contar de 1 até 10 e a lista dos
    erros que já cometeu.
  - Pediu uma nota de 0 a 10: 7 no começo, 8 depois do ex17 (separou fixo e contador sozinho).
  - Os exemplos ficam logo antes do exercício do assunto, com nome `exNN-0-exemplo-...` (ex: `ex13-0-exemplo-while.php`).
- **Próximo passo:** ex20 (`ex20-metade.php`, primeiro `if` dentro do `while`, em 2 etapas).
  Depois, o ex21 (`ex21-termometro.php`, `if` / `else` dentro do `while`, também em etapas),
  refeito **sem olhar** a solução. Seguir no `while` até ele se sentir seguro. Só então
  `for`, `foreach`, funções e `02-web`.
- **Como ensinar (pedido dele):** em assunto novo, explicar **um pedaço por mensagem** e esperar
  ele entender antes de seguir. Uma aula com tudo de uma vez confundiu. Dicas concretas, e o
  comando completo para rodar o arquivo. Ao guiar um exercício, pedir **uma ação por
  mensagem**: ele reclamou de "várias coisas ao mesmo tempo". Quando um exercício juntar uma
  ideia nova (ex: `if` dentro do `while`), passar antes um exercício intermediário e dividir
  o enunciado em etapas.
- **Dúvidas pendentes:** nenhuma.
- **Aviso:** em 06/10/2026 o histórico do repositório foi reescrito para tirar o Gmail
  dos commits. No outro computador, na primeira vez, usar `git fetch` e
  `git reset --hard origin/main` (se não houver alterações locais) em vez de `git pull`.

## Histórico

- 10/10/2026 (`vilela`): sábado de descanso; só tirou o recuo do `echo` do ex13 (pendência).
- 09/10/2026 (`computador 2`): prática de `while`, ex15 a ex19 (os três últimos sozinho); termômetro adiado e dividido em etapas (ex20 e ex21).
- 08/10/2026 (`computador 2`): ex11 e ex12 concluídos (`else` sem condição, ordem com `>=`); primeiro loop (`while`, exemplo, ex13 e ex14).
- 07/10/2026 (`computador 2`): ex10 concluído (boletim com faltas, `if` / `elseif` em ordem).
- 06/10/2026 (`vilela`): ex09 concluído (`;` no fim da linha anterior ao erro, economia sem negativo).
- 06/10/2026 (`vilela`): ex08 concluído (arrays: índice começa em 0, `count`, `\n`).
- 05/10/2026 (`vilela`): ex07 concluído; enunciados dos exercícios 8 a 10 criados.
- 05/10/2026 (`vilela`): sincronização configurada (CLAUDE.md e PROGRESSO.md).
- 05/10/2026 (`computador 2`): estrutura inicial e exercícios 1 a 6 de fundamentos.
