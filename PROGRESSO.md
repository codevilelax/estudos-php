# Progresso dos estudos de PHP

> **⚠️ Para o Claude no computador `vilela` (loja do Valorant, parte do login):** em 06/11/2026
> começamos o projeto `projetos/loja-valorant`: um robô que confere a loja diária do Valorant
> na conta dele e avisa no celular (ntfy) quando vier uma skin da lista de desejos, mesmo com
> o PC desligado. O login só pode ser feito **no `vilela`, nunca no `computador 2`**.
> Ele já sabe que a loja não está na API oficial da Riot, que a rota não oficial traz risco
> para a conta, e decidiu seguir. O login é feito no navegador: não há senha para o robô usar.
> 1. **Regra:** o cookie `ssid` e o endereço depois do login (traz token) são como chaves da
>    conta. Nunca peça o valor, nem em chat ou print, e nunca deixe no código ou no git.
> 2. Passo em aberto: ele entra no navegador do `vilela` por este link e vê, em F12 →
>    Application → Cookies → `https://auth.riotgames.com`, se existe a linha `ssid`:
>    `https://auth.riotgames.com/authorize?redirect_uri=https%3A%2F%2Fplayvalorant.com%2Fopt_in&client_id=play-valorant-web-prod&response_type=token%20id_token&nonce=1&scope=account%20openid`
>    No `computador 2`, esse link terminou em erro 404 e não chegamos a saber em qual domínio.
>    Se o endereço começar com `playvalorant.com`, o login funcionou mesmo com o 404. Se
>    começar com `auth.riotgames.com`, procure o link atual.
> 3. **Neste projeto, ele comanda e o Claude escreve todo o código** (a regra de não entregar a
>    solução não vale aqui). O `robo.php` já está pronto e passou no `php robo.php --teste`,
>    mas a parte que usa a conta **nunca rodou**: a rota veio de documentação da comunidade e
>    pode estar velha. Teste no `vilela` com `RIOT_SSID` em variável de ambiente, sem mostrar o
>    valor, e corrija o que falhar. Use `php robo.php --mostrar` para ver o resultado: sem essa
>    opção o robô só escreve "Loja lida." de propósito. Veja também por quanto tempo a sessão dura.
> 4. **Privacidade (ele pediu o máximo possível):** são dois repositórios, e nenhum dado da conta
>    pode ir para um lugar público.
>    - **Privado, `codevilelax/loja-valorant`** (é o nome que está no `app/index.html`): `robo.php`,
>      `desejos.txt`, `config.json`, `dados/loja.json` e o GitHub Actions, com a sessão e o tópico
>      do ntfy em secrets. **Em 06/11 esse repositório existe, vazio e PÚBLICO: precisa virar
>      privado (Settings → Danger Zone → Change visibility) antes de receber qualquer arquivo.**
>    - **Público, com nome neutro (`minha-loja`, ainda não existe), com o Pages ligado:** só o
>      conteúdo de `app/`, sem dados.
>    - O app só lê os dados pela API do GitHub, com uma chave só para o repositório privado
>      (Contents read/write) e colada no app instalado no celular (no iPhone, o app instalado
>      guarda dados separados do Safari). Sem a chave, mostra só a tela bloqueada ou o exemplo.
>    - O aviso do ntfy é genérico de propósito ("Veio skin da sua lista. Abra o app."), porque o
>      ntfy é público. Use um tópico longo e aleatório.
>    - **Neste repositório de estudos:** `dados/` da loja está no `.gitignore`. Não faça commit
>      aqui da lista real de skins, do Riot ID ou do saldo; eles vão só para o repositório privado.
>      `estudos-php` é público: quando o privado estiver pronto, mova o robô para lá e tire
>      `projetos/loja-valorant` daqui, com confirmação antes de apagar.
> 5. O front está pronto em `app/`: saldo de VP, Riot ID, preços, loja de hoje, botão para ver a
>    loja de ontem, lista de desejos e ajustes. Foi testado com um GitHub de mentira. Saldo,
>    preços e Riot ID nunca rodaram com dados reais. Falta: testar o aviso pelo ntfy, ligar o
>    Actions (com commit do `dados/loja.json`) e testar o app no celular.
> 6. Uma ação por mensagem. Quando o login e a leitura da loja funcionarem, apague este aviso,
>    faça commit e push.

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

- **Data e computador:** 12/11/2026, `computador 2`
- **Assunto:** projeto `projetos/treino-ingles` (curso de inglês por voz com IA). Desde 11/11 ele
  trocou os exercícios por projetos: quer "fazer coisas que realmente funcionam".
  **Não passar mais exercício numerado solto.** O `03-banco-de-dados/ex07-filtro-de-idade.php` foi
  criado e não foi feito: perguntar se pode apagar.
- **Treino de inglês (o Claude escreve o código e ele comanda; não pode ter custo nenhum):**
  - Usa a IA da Groq no plano gratuito. A chave fica em `projetos/treino-ingles/chave.txt`, que está
    no `.gitignore`. No `vilela` o arquivo não existe: criar outra chave em `console.groq.com`.
    Nunca pedir a chave no chat nem mostrar o conteúdo do arquivo.
  - **Versão 2, pronta e testada em 12/11:** trilha de 24 lições em 4 níveis mais a conversa livre;
    a professora Emma na tela (desenho em SVG que mexe a boca enquanto a voz toca); cada lição passa
    por `ensinar` e `praticar` até ser concluída; o progresso fica guardado no navegador. Abre com
    `iniciar.bat` (`localhost:8123`). O `README.md` do projeto explica como usar e onde mexer.
  - **O que foi feito em 12/11:**
    - Teste da tela nova (`public/app.js` e `public/estilo.css`, escritos em 11/11) e três correções:
      1. `src/ia.php`: quem decide o ponto da lição agora é o servidor, e a IA só sugere. A IA às
         vezes pulava um item, queria praticar antes de ensinar tudo e se despedia uma fala antes
         de a lição fechar. `descreverPonto()` diz a ela o item atual e o seguinte; o passo anda no
         máximo um por vez; se ela adiantar, o servidor pede a fala de novo, uma vez; na prática, o
         passo conta as respostas certas (0 a 3) e a lição só conclui com 3.
      2. `public/app.js`: "Refazer" numa lição já concluída começa do zero.
      3. `public/estilo.css`: em tela estreita, o título da aula fica numa linha só dele.
    - **Teste automático em `testes/`** (Git Bash, a partir da pasta do projeto):
      `bash testes/rodar.sh mentira` (sem IA), `real` (lição 1 inteira com a IA) e `fotos`. Usa voz e
      microfone de mentira, para o computador não falar alto. Em 12/11 passaram os 15 cenários.
  - **Nunca testado:** a voz e o microfone de verdade. É o teste que ele vai fazer.
  - **Os dois cliques no `iniciar.bat` não funcionaram para ele em 12/11** e a causa não foi
    descoberta. O arquivo funciona (abri com `cmd /c start`). Perguntar o que aconteceu: se abriu
    como texto, foi dentro do VS Code, e os dois cliques precisam ser no Explorador de Arquivos.
  - **Melhorias que sugeri (ele ainda não escolheu):** 1. a voz: testar no Edge, que tem vozes mais
    naturais que o Chrome, e se ficar melhor fazer o `iniciar.bat` abrir no Edge; 2. revisão das
    lições anteriores no começo de cada lição; 3. a Emma reagir (sorrir no acerto, cara de "quase"
    no erro). Ele perguntou se dá para falar em português: dá, a transcrição descobre o idioma e a
    Emma responde curto e volta para o inglês. Ofereci um modo só de perguntas em português.
  - **Pontos fracos conhecidos da IA gratuita:** na prática, às vezes repete a mesma situação, e de
    vez em quando põe uma palavra em inglês dentro de uma fala em português.
  - Limites da conta gratuita (medidos em 11/11): 8000 tokens por minuto por modelo, e cada fala da
    aula gasta uns 1300; 20 transcrições por minuto. Por isso as instruções da IA são curtas e
    existe um modelo de reserva.
- **Loja do Valorant (parada desde 06/11):** o aviso no topo deste arquivo tem login, privacidade e
  o que falta no robô.
- **O que foi feito em 06/11:**
  - **Banco:** `03-banco-de-dados/ex05-tocantins.php` concluído. Além do pedido, incluiu a idade
    e o contador `$qnt` sem ninguém falar. Erros no caminho: `echo $pessoas` (não dá para
    mostrar o resultado inteiro, só com `foreach`) e um `and IDADE` sobrando no `WHERE`.
  - **Vistos, mas ainda não praticados:** `&&` e `in_array`. Não contam como aprendidos.
  - **Loja do Valorant (código escrito pelo Claude):** `robo.php` lê a loja e o saldo, guarda hoje
    e ontem em `dados/loja.json` e avisa pelo ntfy. `app/` tem loja do dia, preços, VP, Riot ID,
    botão da loja de ontem, lista de desejos, ajustes e tela bloqueada sem a chave. `testes/`
    tem o GitHub de mentira (`router.php`), o roteiro do navegador (`roteiro.js`) e o gerador do
    exemplo (`gerar-exemplo.php`). Passou nos testes, **sem nada real**: login, leitura da
    loja, ntfy, GitHub de verdade e celular nunca rodaram.
  - **Teste do app:** copie `app/` para uma pasta temporária com os arquivos de `testes/`, troque
    a URL de `API_ARQUIVOS` por `/github/`, inclua `roteiro.js` antes de `</body>`, desligue o
    service worker na cópia e rode `php -S` com `router.php` + Chrome `--headless=new --dump-dom`.
    O `roteiro.js` precisa de ajuste depois do novo visual.
  - **Banco agora:** 501 pessoas (as 500 + Carla, 29 anos). O próximo `id` vai ser **506**.
- **Próximo passo:** ele testar o treino de inglês com a voz e o microfone de verdade e dizer o que
  achou. Depois, escolher a próxima melhoria (lista acima).
- **Próximos passos da loja do Valorant (na ordem combinada):**
  1. **Refazer o visual do app, com `exemplo.json`.** Foi aprovado ("dê seu melhor"), mas **não
     foi salvo**: o `app/index.html` ainda é o visual antigo. A referência são 3 prints mandados no
     chat; não foram salvos porque mostram dados da conta, então peça de novo. Usar como
     referência de layout, com identidade própria, sem copiar marca e sem anúncios:
     - **Geral:** fundo preto, cartões `#1c1c1e` com raio de 20px, vermelho `#ff4655`, fonte do
       sistema (apagar `app/fontes` e tirar do `sw.js`). Barra de baixo flutuante em pílula, com
       ícone e texto: Loja, Coleção e Ajustes. Battle Pass e Perfil ficam para depois.
     - **Loja:** título grande e Riot ID. Painel com VP, Kingdom Credits e Radianite
       (`media.valorant-api.com/currencies/<id>/displayicon.png`), relógio ao vivo "Troca em
       hh:mm:ss" e "Total" da loja. Abas Diária, Acessórios e Pacotes. Na Diária, cartões grandes:
       imagem centralizada, fundo na cor da raridade (`contentTierUuid` da skin +
       `highlightColor` de `/v1/contenttiers`), ícone da raridade, nome, preço e coração. O botão
       da loja de ontem continua embaixo, fechado no início.
     - **Coleção (só para ver):** dois resumos (valor em VP das skins; lista de desejos, que abre a
       tela com busca), Loadout em fila horizontal, Equipado (cartão e título) e grade com Skins,
       Buddies, Sprays, Cartões, Títulos, Flex e Agentes, cada um abrindo sua lista com "voltar".
     - **Ajustes:** Conta, Avisos no celular e Acesso. Sem chave, nada da conta aparece.
     - **`sw.js`:** a lista de skins tem 3,6 MB, então abrir a cópia guardada e atualizar por trás.
       Nunca guardar respostas do GitHub.
     - **Fora, combinado:** editar loadout pelo app (exigiria a sessão da Riot no celular), várias
       contas e anúncios.
  2. **Testar login e leitura da loja** no `vilela` (aviso do topo). É o maior risco: sem isso,
     nada tem dados reais.
  3. **Se funcionar, ligar os dados novos no robô**, gravando no formato do `app/exemplo.json`:
     `kc` e `radianita` (carteira, ids `85ca954a-41f2-ce94-9b45-8ca3dd39a00d` e
     `e59aa87c-4cbf-517a-5983-6e81511be9b7`), `AccessoryStore` e `FeaturedBundle` (mesma resposta
     da loja), coleção e loadout (`valapidocs.techchrism.me`: `owned-items`, `player-loadout`).
     Por último, Battle Pass (`contracts`) e perfil (`player-mmr`, `account-xp`).
  - **`cadastro-pessoas`, para quando quiser voltar:** alterar pela página (id + idade nova) e
    consertar a linha 9 do `index.php`, que lê `$_GET["uf"]` sem conferir com `isset`.

- **No computador `vilela`:** antes do primeiro exercício de banco, conferir se `php -m`
  mostra `pdo_sqlite` (ver `CLAUDE.md`). Se ele quiser a tela de consulta, instalar as
  extensões SQLite Viewer e SQLite (alexcvzz) no VS Code de lá. O `readline` do projeto
  precisa funcionar no PHP de lá (`php -r "var_dump(function_exists('readline'));"`).
- **Pendências da loja:** mudar `loja-valorant` para privado; criar o público `minha-loja`;
  confirmar se pode criar um tópico novo no ntfy; passar a lista real de skins.
- **Dúvidas pendentes:** nenhuma.
- **Perfil do GitHub:** em 22/10 ele escolheu "desenvolvedor" como objetivo (antes estava
  "Engenharia de Dados"). Perfil ajustado, agora igual ao portfólio.
- **Como ensinar (pedido dele):** desde 22/10 ele quer **ritmo mais rápido e desafios mais
  difíceis**, sem etapas, usando o banco. Mas a explicação de assunto novo continua **um pedaço
  por mensagem**, curta e concreta. Quando não entende, pede "como se fosse para uma criança"
  (analogias simples funcionaram: telefone para a conexão, planilha para tabela e coluna,
  cofrinho para soma, campeonato para maior/menor). **Desde 06/11: não pedir para explicar
  linhas de código** ("chega disso, quero praticar"), a não ser que seja pedido. Prática em
  projeto de uso real anima mais que exercício solto. **No projeto da loja, o Claude escreve o
  código** e a direção vem dos pedidos. Ele gostou de **caça ao bug** (código quebrado para consertar). Quando ele
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

- 12/11/2026 (`computador 2`): treino de inglês, versão 2 concluída e testada (trilha de lições, professora Emma na tela, teste automático).
- 11/11/2026 (`computador 2`): começo do projeto `treino-ingles`: versão 1 pronta (conversa por voz com correção) e versão 2 começada.
- 09/11/2026 (`computador 2`): ex06 de banco concluído (caça ao bug no navegador, Raio-X do estado).
- 06/11/2026 (`computador 2`): ex05 de banco concluído; começo do projeto `loja-valorant`.
- 30/10/2026 (`computador 2`): projeto `cadastro-pessoas`, parte 5: lista lembra o estado (`selected`), `isset`, cadastro pela página com POST.
- 29/10/2026 (`computador 2`): projeto `cadastro-pessoas`: `UPDATE` no `alterar.php`; começo da parte 5, busca por estado no navegador (`$_GET`, `<form>`, `<select>`).
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
