# Progresso dos estudos de PHP

> **⚠️ Para o Claude no computador `vilela`:** o histórico do GitHub foi reescrito em
> 21/10/2026. Se o `git pull` deu conflito ou disse que os históricos divergiram, **não
> resolva o conflito nem faça merge/rebase**: rode `git merge --abort` (se houver merge em
> andamento), confira que não há trabalho local que ainda não está no GitHub, e então rode
> `git fetch` e `git reset --hard origin/main`. Depois, apague este aviso, faça commit e push.

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

- **Data e computador:** 22/10/2026, `computador 2`
- **Assunto:** `foreach` e `+=` / `-=` encerrados em `01-fundamentos`. Começou
  `03-banco-de-dados` com SQLite (pedido dele, ver "Novo jeito de estudar" abaixo).
- **O que foi feito:**
  - `foreach`: ex34 (convites) **com ajuda** no nome da variável (`$amigos as $amigos`; entendeu
    vendo o valor de `$amigos` a cada volta e trocou para `$amigo`). ex35 e ex36 com detalhes
    de texto; no ex36 usou `18` fixo no `if` em vez de `$idadeMinima` e corrigiu. ex37 e ex38
    **sozinho** (no ex38 só faltou um espaço).
  - Somar no `foreach`: ex39 (cofrinho) esqueceu o `$total = 0` antes do loop (aviso
    "Undefined variable") e corrigiu. ex40 **sozinho**, com a soma antes do `echo` certa de
    primeira. Para entender a soma, funcionou a explicação "como para uma criança" (cofrinho
    vazio + uma moeda por volta).
  - `+=` / `-=`: ele mesmo deduziu `$total += $km`. ex41 (vida no jogo): inverteu
    `$pocao += $vida`; entendeu com "quem bebe a poção é o personagem: quem sobe é a vida".
  - **Novo jeito de estudar:** ele achou o ritmo lento e pediu para aprender na prática com
    dados. Criei o banco SQLite `03-banco-de-dados/banco/estudos.sqlite` (tabela `pessoas`,
    500 pessoas fictícias), que vai para o git e vale nos dois computadores. Regras no
    `CLAUDE.md`. Funções e `02-web` ficaram para depois.
  - `03-banco-de-dados`: ex01-0 (exemplo de conexão, lido parte por parte: `new PDO`,
    `setAttribute`, `query`, `$pessoa["nome"]`). ex01 (faixas de idade) **com ajuda**: colou
    código PHP no PowerShell; escreveu o SQL solto, fora do `query("...")`; `FROM nome` em
    vez de `FROM pessoas`; `echo $pessoa` ("Array to string conversion"); divisas `< 29` em
    vez de `<= 29`. ex02 (10 mais velhos de MG + média calculada no PHP) **com ajuda**:
    `WHERE uf` sem comparação; aspas simples em volta da tabela e da coluna em vez do valor;
    `TOP10` (vem do SQL Server); faltou `, nome` no desempate; `+=` invertido de novo na
    soma das idades.
  - VS Code: ele já tinha o SQLite Viewer (ver a tabela). Instalou a extensão **SQLite**
    (alexcvzz) para testar consultas: Ctrl+Shift+P → "SQLite: New Query", Ctrl+Shift+Q roda.
    Os rascunhos `-- SQLite*.sql` estão no `.gitignore`.
- **Próximo passo:** próximo desafio de banco. Ele **sabe SQL básico** (usa SQL Server no
  trabalho), então o foco é o lado do PHP, um assunto novo por vez: (1) variável dentro do
  SQL do jeito seguro (`prepare` + `execute`); (2) inserir, alterar e apagar pessoas pelo PHP;
  (3) `require` para deixar a conexão num arquivo só (prometi mostrar). Sugerir testar a
  consulta antes na extensão SQLite e depois colar no `query("...")`.
- **No computador `vilela`:** antes do primeiro exercício de banco, conferir se `php -m`
  mostra `pdo_sqlite` (ver `CLAUDE.md`). Se ele quiser a tela de consulta, instalar as
  extensões SQLite Viewer e SQLite (alexcvzz) no VS Code de lá.
- **Dúvidas pendentes:** nenhuma.
- **Perfil do GitHub:** em 22/10 ele escolheu "desenvolvedor" como objetivo (antes estava
  "Engenharia de Dados"). Perfil ajustado, agora igual ao portfólio.
- **Como ensinar (pedido dele):** desde 22/10 ele quer **ritmo mais rápido e desafios mais
  difíceis**, sem etapas, usando o banco. Mas a explicação de assunto novo continua **um pedaço
  por mensagem**, curta e concreta. Quando não entende, pede "como se fosse para uma criança"
  (analogias simples funcionaram: telefone para a conexão, planilha para tabela e coluna,
  cofrinho para soma). Quando o exercício pedir um array, os itens já vêm no enunciado (regra
  no `CLAUDE.md`). Erro que se repetiu: a ordem do `+=` (o cofrinho fica à esquerda).
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
