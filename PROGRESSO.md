# Progresso dos estudos de PHP

## Onde parei

- **Data e computador:** 20/10/2026, `vilela`
- **Assunto:** `01-fundamentos`: praticando o `for`.
- **O que foi feito:**
  - ex30 (`ex30-prova.php`, `for` descendo de 15 em 15 com `if` / `elseif` / `else`): sozinho,
    saída certa. Mas usou `> 1` no `elseif` (com 1 minuto cairia em "acabou"); com a dica da
    divisa, corrigiu para `>= 1`.
  - Atalho `$i++` explicado: só soma 1, e quem decide quando parar é a condição. Dúvida dele:
    achava que o `++` somava "até ser verdadeiro". Testou trocando o passo do ex27 por `$n++`.
  - `+=` foi mostrado cedo demais; ele pediu para deixar para depois (uma coisa de cada vez).
  - ex31 (`ex31-senhas.php`, `for` com `$senha++`, três casos comparando com `$minhaSenha` e
    `==`): **sozinho e sem consultar**; achou o próprio erro.
  - ex32 (`ex32-corrida.php`) criado e **ainda não feito**: `for` com conta dentro
    (`$semana * $kmPorSemana`, como a tabuada do ex15) e `if` / `else` com `$meta`.
- **Próximo passo:** fazer o ex32 sozinho. Ele pediu mais prática de `for` antes de seguir.
  Depois: `+=` / `-=` (quando ele quiser), `foreach`, funções e `02-web`.
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
- **Aviso:** em 06/10/2026 o histórico do repositório foi reescrito para tirar o Gmail
  dos commits. No outro computador, na primeira vez, usar `git fetch` e
  `git reset --hard origin/main` (se não houver alterações locais) em vez de `git pull`.

## Histórico

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
