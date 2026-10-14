# Progresso dos estudos de PHP

## Onde parei

- **Data e computador:** 14/10/2026, pelo celular (sessão do Claude Code na nuvem)
- **Assunto:** `01-fundamentos`: praticando o `while`.
- **O que foi feito:**
  - ex20 (`ex20-metade.php`): **etapa 1 concluída, com ajuda passo a passo** (mostrar de 1 até
    10 com `while`). Erros corrigidos um por vez:
    - começou o contador em 10 (o fim), de novo o erro do ex16; numa tentativa mudou a
      condição para `>= 0` e criou um loop infinito;
    - esqueceu as chaves `{ }` do `while`;
    - esqueceu o `;` depois do `echo`;
    - escreveu `/n` em vez de `\n`.
  - No celular, o teclado troca `"` por aspas curvas `“ ”`. O PHP não aceita; o Claude trocou ao salvar.
- **Próximo passo:** etapa 2 do ex20 (o `if` que mostra "Metade do caminho!" no 5). Depois,
  o ex21 (`ex21-termometro.php`, `if` / `else` dentro do `while`, em etapas), refeito **sem
  olhar** a solução. Seguir no `while` até ele se sentir seguro. Só então `for`, `foreach`,
  funções e `02-web`.
- **Dúvidas pendentes:** nenhuma.
- **Como ensinar (pedido dele):** em assunto novo, explicar **um pedaço por mensagem** e esperar
  ele entender antes de seguir. Uma aula com tudo de uma vez confundiu. Dicas concretas, e o
  comando completo para rodar o arquivo. Ao guiar um exercício, pedir **uma ação por
  mensagem**: ele reclamou de "várias coisas ao mesmo tempo". Quando um exercício juntar uma
  ideia nova (ex: `if` dentro do `while`), passar antes um exercício intermediário e dividir
  o enunciado em etapas.
- **Aviso:** em 06/10/2026 o histórico do repositório foi reescrito para tirar o Gmail
  dos commits. No outro computador, na primeira vez, usar `git fetch` e
  `git reset --hard origin/main` (se não houver alterações locais) em vez de `git pull`.

## Histórico

- 09/10/2026 (`computador 2`): prática de `while`, ex15 a ex19 (os três últimos sozinho); termômetro adiado e dividido em etapas (ex20 e ex21).
- 08/10/2026 (`computador 2`): ex11 e ex12 concluídos (`else` sem condição, ordem com `>=`); primeiro loop (`while`, exemplo, ex13 e ex14).
- 07/10/2026 (`computador 2`): ex10 concluído (boletim com faltas, `if` / `elseif` em ordem).
- 06/10/2026 (`vilela`): ex09 concluído (`;` no fim da linha anterior ao erro, economia sem negativo).
- 06/10/2026 (`vilela`): ex08 concluído (arrays: índice começa em 0, `count`, `\n`).
- 05/10/2026 (`vilela`): ex07 concluído; enunciados dos exercícios 8 a 10 criados.
- 05/10/2026 (`vilela`): sincronização configurada (CLAUDE.md e PROGRESSO.md).
- 05/10/2026 (`computador 2`): estrutura inicial e exercícios 1 a 6 de fundamentos.
