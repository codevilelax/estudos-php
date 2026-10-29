# Progresso dos estudos de PHP

> **⚠️ Para o Claude no computador `vilela` (monitor do Detran):** em 21/10/2026, no
> `computador 2`, fiz um monitor que avisa quando abre vaga numa quarta-feira no agendamento
> do exame prático do Detran-SP (script do Tampermonkey + notificação no celular pelo ntfy).
> Ele vai rodar **no `vilela`**. Tudo está nesta página, fixada no claude.ai dele:
> https://claude.ai/artifact/CfCJBGtok9eW2wsWUNa9Uf
> 1. Leia a página com a ferramenta Artifact (`action: "read"`): tem o passo a passo e o script inteiro.
> 2. Salve na memória deste computador: o link; o que é o monitor; que o celular já assinou o
>    tópico do ntfy (está na página) e recebeu o teste; que o WhatsApp (CallMeBot) ficou de
>    fora porque o bot estava lotado; e que o script ainda não foi testado na tela real do
>    Detran (a detecção de dia livre é pela cor: número escuro = disponível). Se der erro,
>    pedir print da caixinha preta do monitor e da tela, ajustar o script e republicar a página.
> 3. Apague este aviso, faça commit e push.
> 4. Ajude ele a seguir os passos da página, uma ação por mensagem.

> **⚠️ Para o Claude no computador `vilela` (extensões do VS Code):** em 22/10/2026 ele pediu
> que o VS Code do `vilela` fique com **as mesmas extensões do `computador 2`**, que é a
> referência ("esse aqui tem as melhores"). As que existirem só no `vilela` devem sair. No
> `computador 2` passei para ele a sincronização do VS Code (Ctrl+Shift+P → "Settings Sync:
> Backup and Sync Settings", conta GitHub `codevilelax`).
> 1. Rode `code --list-extensions` e compare com a lista abaixo.
> 2. Mostre a ele as que sobram no `vilela` e pergunte se pode **desinstalar**
>    (`code --uninstall-extension <id>`). Ele falou em "desativar", mas explique em uma linha
>    que a desativada continua instalada e a sincronização copiaria ela para o `computador 2`.
>    Se ele preferir desativar, é pelo painel de extensões (botão direito → Disable).
> 3. **Só depois disso**, ajude a ligar a sincronização com a mesma conta. Se perguntar entre
>    "Merge" e "Replace Local", escolha **Replace Local** (o `computador 2` manda). Se ele não
>    quiser a sincronização, instale as que faltam com `code --install-extension <id>`.
> 4. Confira com `code --list-extensions`, apague este aviso, faça commit e push.
>
> Extensões do `computador 2` (22/10/2026): `alexcvzz.vscode-sqlite`, `anthropic.claude-code`,
> `batisteo.vscode-django`, `brapifra.phpserver`, `devsense.composer-php-vscode`,
> `devsense.intelli-php-vscode`, `devsense.phptools-vscode`, `devsense.profiler-php-vscode`,
> `donjayamanne.python-environment-manager`, `donjayamanne.python-extension-pack`,
> `esbenp.prettier-vscode`, `formulahendry.code-runner`, `kevinrose.vsc-python-indent`,
> `mathiasfrohlich.kotlin`, `mechatroner.rainbow-csv`, `ms-python.debugpy`, `ms-python.python`,
> `ms-python.vscode-pylance`, `ms-python.vscode-python-envs`, `ms-vscode.powershell`,
> `njpwerner.autodocstring`, `openai.chatgpt`, `openai.codex-audio`, `pkief.material-icon-theme`,
> `qwtel.sqlite-viewer`, `ritwickdey.liveserver`, `rocketseat.theme-omni`,
> `visualstudioexptteam.intellicode-api-usage-examples`, `visualstudioexptteam.vscodeintellicode`,
> `wholroyd.jinja`, `zobo.php-intellisense`.

## Onde parei

- **Data e computador:** 29/10/2026, `computador 2`
- **Assunto:** projeto `projetos/cadastro-pessoas`: **`UPDATE`** e começo da parte 5,
  **levar pro navegador**.
- **O que foi feito:**
  - **`UPDATE` concluído** no `alterar.php`, passo a passo: `require`, 2 `readline`,
    `prepare("UPDATE pessoas SET idade = ? WHERE id = ?")`, `execute([$idade, $id])` e `echo`.
    Carla Mendes (id 501) agora tem 29 anos (conferi no banco: só ela mudou).
  - Erros no caminho: `SET id = ? AND idade = ?` sem `WHERE`; depois `SET` e `WHERE`
    trocados (`SET id = ? WHERE idade = ?`); no `execute`, usou `$delete` (nome do outro
    arquivo), dois arrays `[$idade], [$id]` e ordem errada. Entendeu com "`SET` = o que muda,
    `WHERE` = qual pessoa" e "os valores vão na mesma ordem dos `?`". Treino de explicar a
    linha do `prepare`: acertou o SQL; achava que o `prepare` conecta (quem conecta é o
    `require`) e que `$update` guarda o texto (guarda o comando preparado; prepare = deixa
    pronto, execute = roda).
  - **Parte 5, passos 1 e 2 (`index.php`):** a busca por estado virou página. `$_GET["uf"]`
    no lugar do `readline`, `<br>` no lugar do `"\n"`, servidor com
    `php -S localhost:8000 -t <pasta do projeto>` (caminho absoluto). Formulário `<form>` +
    `<select name="uf">` + `<button>`; a lista de estados vem do banco
    (`SELECT DISTINCT uf ... ORDER BY uf` + `foreach` com `echo "<option>..."`). O `require`
    foi para a linha 1 (`<?php require ...; ?>`), antes do formulário. Fez quase tudo com
    ajuda, uma ação por mensagem (pediu de novo: "muita informação de uma vez").
  - Erros no caminho: trocou o `<form>` inteiro pelo `<select>` (sumiram form e botão);
    não salvou depois de apagar linhas; o servidor desligou ("conexão recusada").
  - **Banco agora:** 501 pessoas, Carla com 29 anos. O próximo `id` vai ser **503**.
- **Próximo passo:** o desafio que ele mesmo achou (anotado no topo do `index.php`): depois
  de buscar, a lista volta para AL. Resolver com `if` / `else` dentro do `foreach` dos
  estados, escrevendo `<option selected>` quando o estado for igual a `$_GET["uf"]`. Depois:
  a frase "Nenhuma pessoa encontrada em" aparece ao abrir a página sem estado (tratar quando
  não tem `uf`); visual (escuro + vermelho, como o portfólio); cadastrar, alterar e apagar
  pela página. Treino de explicar ainda sem resposta: a linha do `execute` do `cadastrar.php`.
- **No computador `vilela`:** antes do primeiro exercício de banco, conferir se `php -m`
  mostra `pdo_sqlite` (ver `CLAUDE.md`). Se ele quiser a tela de consulta, instalar as
  extensões SQLite Viewer e SQLite (alexcvzz) no VS Code de lá. O `readline` do projeto
  precisa funcionar no PHP de lá (`php -r "var_dump(function_exists('readline'));"`).
- **Dúvidas pendentes:** nenhuma.
- **Perfil do GitHub:** em 22/10 ele escolheu "desenvolvedor" como objetivo (antes estava
  "Engenharia de Dados"). Perfil ajustado, agora igual ao portfólio.
- **Como ensinar (pedido dele):** desde 22/10 ele quer **ritmo mais rápido e desafios mais
  difíceis**, sem etapas, usando o banco. Mas a explicação de assunto novo continua **um pedaço
  por mensagem**, curta e concreta. Quando não entende, pede "como se fosse para uma criança"
  (analogias simples funcionaram: telefone para a conexão, planilha para tabela e coluna,
  cofrinho para soma, campeonato para maior/menor). Desde 23/10, treinar também a
  **explicação**: nos exercícios, uma Parte 2 em que ele explica linhas em comentário (o que
  faz + pra quê). Ele gostou de **caça ao bug** (código quebrado para consertar). Quando ele
  pede "passo a passo", dar uma ação por mensagem e conferir o arquivo depois de cada uma:
  funcionou muito bem em 23/10. Quando o exercício pedir um array, os itens já vêm no
  enunciado (regra no `CLAUDE.md`). Erros que se repetem: a ordem do `+=` (o cofrinho fica à
  esquerda), colocar linhas dentro/fora das chaves erradas, `=` no lugar de `==` no `if`
  (23/10 e 26/10) e **aspas**: o que é texto vai dentro, o que é código (coluna, caixinha,
  `.`) vai fora. Quando um passo é **só repetição** do que ele já sabe (copiar a conexão,
  `prepare`/`execute` iguais), ele cansa ("muito repetitivo"): oferecer fazer essa parte por
  ele e focar no que é novo.
- **Privacidade:** o repositório `estudos-php` é **público** e o banco vai junto no push.
  Se ele se cadastrar com dados reais (nome, idade, cidade), avisar antes de subir.
  Dicas concretas, e o comando para rodar o arquivo com o **caminho absoluto** neste computador
  (o relativo não funcionou no terminal dele). Quando ele pedir "o terminal do ex N", mandar
  **só o comando** para ele rodar: não rodar o arquivo, não mostrar a saída e não comentar erro
  (ele quer ver sozinho antes de pedir ajuda). Ao guiar um exercício, pedir **uma ação por
  mensagem**: ele reclamou de "várias coisas ao mesmo tempo". Quando ele disser "não entendi",
  mostrar o trecho do código dele com os valores de uma volta do loop e dar uma ação concreta
  com o número da linha. Isso funcionou melhor que explicar de novo. Incentivar a ler a
  mensagem de erro antes de pedir ajuda (falamos disso em 22/10).
- **Ao conferir loops:** rodar com limite de tempo (`timeout 3 php ...`), porque um loop
  infinito trava. Se travar no terminal dele, avisar para apertar Ctrl+C.
- **Aviso:** em 06/10/2026 e de novo em 21/10/2026 o histórico do repositório foi reescrito
  (em 06/10 para tirar o Gmail dos commits; em 21/10 para deixar neutro o commit de 19/10).
  No outro computador (`vilela`), na primeira vez depois de 21/10, usar `git fetch` e
  `git reset --hard origin/main` (se não houver alterações locais) em vez de `git pull`.

## Histórico

- 28/10/2026 (`computador 2`): projeto `cadastro-pessoas`, parte 4: `require` com `conexao.php` nos três arquivos.
- 26/10/2026 (`computador 2`): projeto `cadastro-pessoas`: `if` / `else` no `buscar.php`, `INSERT` no `cadastrar.php` (Carla Mendes, id 501) e `DELETE` no `apagar.php`.
- 23/10/2026 (`computador 2`): treino de explicar código; ex03 e ex04 de banco (com ajuda); começo do projeto `cadastro-pessoas` (`readline`, `prepare` + `execute`).
- 22/10/2026 (`computador 2`): ex34 a ex41 (`foreach` e `+=`/`-=` encerrados); banco SQLite de 500 pessoas criado; ex01 e ex02 de banco com ajuda.
- 21/10/2026 (`computador 2`): ex32 com ajuda e ex33 sozinho (`for` encerrado); exemplo do `foreach` e ex34 preparados.
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
