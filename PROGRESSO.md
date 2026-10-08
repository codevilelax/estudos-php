# Progresso dos estudos de PHP

## Onde parei

- **Data e computador:** 08/10/2026, computador `vilela`
- **Assunto:** `01-fundamentos`: terminou as condicionais e começou os loops (`while`)
- **O que foi feito:**
  - ex11 (`ex11-pizzaria.php`, frete da pizzaria): **concluído e funcionando**, testado nos
    valores de fronteira (29, 30, 50, 79, 80 e distância acima de 10 km).
    - Corrigiu sozinho dois erros de sintaxe: uma letra solta depois do `;` (o PHP acusou a
      linha seguinte) e `else` com condição (o `else` não leva condição).
    - Erro de lógica: usou `< 80` e `< 50` descendo do maior para o menor. **A correção
      (`>= 50`, `>= 30`) foi feita pelo Claude, a pedido.**
    - Nomes de variáveis: preferiu manter `$vlrPed` em vez de `$valorPedido` (aceitável).
  - ex12 (`ex12-bateria.php`, bateria do celular): **concluído sozinho, sem ajuda**, e correto
    em todas as fronteiras. Usou `>=` descendo do maior para o menor (fixou o ponto do ex11).
  - **Loops, primeiro contato com o `while`:**
    - `ex13-0-exemplo-while.php`: exemplo para mexer e rodar (contar de 1 até N). Não é exercício.
    - Entendeu `$contador = $contador + 1` (o `=` quer dizer "guarde", e o lado direito é
      calculado primeiro) e que o loop começa a partir do **valor inicial** da variável.
    - ex13 (`ex13-contagem.php`, contagem regressiva de 10 até 1): **concluído**, com ajuda.
      Os erros no caminho: condição `<= 1` (o loop não rodou nenhuma vez); a frase dentro do
      loop (apareceu 10 vezes); contar para cima em vez de para baixo. No fim, colocou o
      "Feliz Ano Novo!" fora do loop sozinho.
    - Viu por cima: os 4 tipos de loop (`while`, `for`, `foreach`, `do...while`) e a diferença
      entre `while` (condição) e `foreach` (passa pelos itens de um array).
    - ex14 (`ex14-pares.php`, números pares de 2 até 20): **concluído sozinho, sem ajuda**, de
      primeira. Usou a atualização de 2 em 2 (`$par = $par + 2`).
  - Os exemplos ficam logo antes do exercício do assunto, com nome `exNN-0-exemplo-...` (ex: `ex13-0-exemplo-while.php`).
- **Próximo passo:** começar o `for` (um pedaço por vez, com exemplo antes do exercício).
  Depois, `foreach`, e então funções. Só então o `02-web`.
- **Como ensinar (pedido dele):** em assunto novo, explicar **um pedaço por mensagem** e esperar
  ele entender antes de seguir. Uma aula com tudo de uma vez confundiu. Dicas concretas, e o
  comando completo para rodar o arquivo.
- **Dúvidas pendentes:** nenhuma. Pendência pequena: tirar os espaços do `echo` da linha 22 do
  ex13, que está fora do loop mas recuado como se estivesse dentro.
- **Aviso:** em 06/10/2026 o histórico do repositório foi reescrito para tirar o Gmail
  dos commits. No outro computador, na primeira vez, usar `git fetch` e
  `git reset --hard origin/main` (se não houver alterações locais) em vez de `git pull`.

## Histórico

- 08/10/2026 (`vilela`): ex11 e ex12 concluídos (`else` sem condição, ordem com `>=`); primeiro loop (`while`, exemplo, ex13 e ex14).
- 07/10/2026 (`vilela`): ex10 concluído (boletim com faltas, `if` / `elseif` em ordem).
- 06/10/2026 (`vilela`): ex09 concluído (`;` no fim da linha anterior ao erro, economia sem negativo).
- 06/10/2026 (`vilela`): ex08 concluído (arrays: índice começa em 0, `count`, `\n`).
- 05/10/2026 (`vilela`): ex07 concluído; enunciados dos exercícios 8 a 10 criados.
- 05/10/2026 (`vilela`): sincronização configurada (CLAUDE.md e PROGRESSO.md).
- 05/10/2026 (outro computador): estrutura inicial e exercícios 1 a 6 de fundamentos.
