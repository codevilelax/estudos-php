# Progresso dos estudos de PHP

## Onde parei

- **Data e computador:** 08/10/2026, computador `vilela`
- **Assunto:** `01-fundamentos`: terminou as condicionais e começou os loops
- **O que foi feito:**
  - ex12 (`ex12-bateria.php`, bateria do celular): **concluído sozinho, sem ajuda**, e correto
    em todas as fronteiras (19, 20, 49, 50, 89, 90). Usou `>=` descendo do maior para o
    menor, que era o ponto que tinha travado no ex11.
  - Início dos loops: explicação do `while` e das 3 etapas de um loop (começo, condição,
    atualização), com o aviso sobre o loop infinito (Ctrl+C para parar).
  - Enunciado do ex13 (`ex13-contagem.php`, contagem regressiva com `while`) criado.
  - ex11 (`ex11-pizzaria.php`, frete da pizzaria): **concluído e funcionando**, testado nos
    valores de fronteira (29, 30, 50, 79, 80 e distância acima de 10 km).
  - Corrigiu sozinho dois erros de sintaxe:
    - uma letra solta depois do `;` (o PHP acusou o erro na linha seguinte);
    - `else` com condição: o `else` não leva condição, porque quer dizer "em qualquer outro caso".
  - Erro de lógica: usou `< 80` e `< 50` descendo do maior para o menor. Como o `< 80`
    pegava todos os valores abaixo de 80, as linhas de baixo nunca rodavam. **A correção
    (`>= 50`, `>= 30`) foi feita pelo Claude, a pedido.** Vale praticar isso de novo sozinho.
  - Conversa sobre nomes de variáveis: nomes completos (`$valorPedido`) são mais fáceis de
    ler do que abreviados (`$vlrPed`). Decidiu manter `$vlrPed`, o que é aceitável.
- **Próximo passo:** fazer o `ex13-contagem.php` (primeiro loop, com `while`). Depois, `for`
  e `foreach` (um de cada vez), e então funções. Só então o `02-web`.
  Ao começar assunto novo, usar exercícios curtos, que dê para fazer sozinho do começo ao fim.
- **Dúvidas pendentes:** nenhuma.
- **Aviso:** em 06/10/2026 o histórico do repositório foi reescrito para tirar o Gmail
  dos commits. No outro computador, na primeira vez, usar `git fetch` e
  `git reset --hard origin/main` (se não houver alterações locais) em vez de `git pull`.

## Histórico

- 08/10/2026 (`vilela`): ex11 e ex12 concluídos (`else` sem condição, ordem com `>=`); início dos loops.
- 07/10/2026 (`vilela`): ex10 concluído (boletim com faltas, `if` / `elseif` em ordem).
- 06/10/2026 (`vilela`): ex09 concluído (`;` no fim da linha anterior ao erro, economia sem negativo).
- 06/10/2026 (`vilela`): ex08 concluído (arrays: índice começa em 0, `count`, `\n`).
- 05/10/2026 (`vilela`): ex07 concluído; enunciados dos exercícios 8 a 10 criados.
- 05/10/2026 (`vilela`): sincronização configurada (CLAUDE.md e PROGRESSO.md).
- 05/10/2026 (outro computador): estrutura inicial e exercícios 1 a 6 de fundamentos.
