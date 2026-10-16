# Progresso dos estudos de PHP

## Onde parei

- **Data e computador:** 16/10/2026, `computador 2`
- **Assunto:** `01-fundamentos`: fechou o `while` e começou o `for`.
- **O que foi feito:**
  - ex25 (`ex25-corrida.php`) e ex26 (`ex26-forno.php`, três casos com `elseif`, valores bem
    na divisa): `while` com `if`, **sozinho, de primeira**. Com isso o `while` ficou encerrado.
  - `for` explicado como um `while` com começo, condição e passo juntos no parêntese. Por quê:
    o passo fica na linha de cima e não tem como esquecer ou pôr no lugar errado (o erro dele
    no `while`). Dúvida dele: a variável que conta é criada **dentro** do `for`; as outras
    (ex: `$aumento`) continuam fora, antes do loop.
  - ex27 (`ex27-flexoes.php`, 1 a 10): sozinho; só faltou o `!` no texto final.
  - ex28 (`ex28-foguete.php`, 10 a 1): usou `>= 0` e mostrou o 0 a mais; corrigiu para `> 0`.
  - ex29 (`ex29-volume.php`, `for` com `if` / `else` e `$aumento` fora): começou com
    `$volume = 100`, viu no terminal e corrigiu para 0 sozinho.
  - ex30 (`ex30-prova.php`) criado e **ainda não feito**: `for` contando para baixo de 15 em 15,
    com três casos (`if` / `elseif` / `else`), sem etapas.
- **Próximo passo:** fazer o ex30 sozinho. Depois, talvez mostrar o atalho `$i++` (um pedaço
  por mensagem), e então `foreach`, funções e `02-web`.
- **Dúvidas pendentes:** nenhuma.
- **Pendente:** no perfil (`codevilelax/codevilelax`), o "Sobre mim" diz que o objetivo é
  "Engenharia de Dados", e o portfólio novo diz "desenvolvedor". Ele pediu para deixar a troca
  para depois: perguntar de novo no próximo fim de sessão.
- **Como ensinar (pedido dele):** em assunto novo, explicar **um pedaço por mensagem** e esperar
  ele entender antes de seguir. Uma aula com tudo de uma vez confundiu. Dicas concretas, e o
  comando completo para rodar o arquivo. Quando ele pedir "o terminal do ex N", mandar **só o
  comando** para ele rodar: não rodar o arquivo nem mostrar a saída (ele quer ver sozinho). Ao guiar um exercício, pedir **uma ação por
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
