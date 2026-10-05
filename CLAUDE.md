# Instruções para o Claude Code

Sou iniciante em PHP/programação e estou aprendendo do zero.

Explique apenas uma coisa por vez.

Sempre explique o porquê das coisas, não só o "como".

Evite explicações longas e muitos conceitos novos de uma vez.

## Sincronização entre computadores

Estudo em dois computadores diferentes e o histórico de conversas não é
compartilhado entre eles. O repositório no GitHub é a única fonte da verdade.

### Ao começar uma sessão
- Antes de qualquer outra coisa, rode `git pull` para trazer as atualizações.
- Confira se `git config user.email` neste repositório é
  `235184508+codevilelax@users.noreply.github.com`. Se não for, configure
  com esse valor (só neste repositório), para meu e-mail pessoal não aparecer nos commits.
- Se houver alterações locais não salvas, avise-me antes de puxar.
- Leia o arquivo `PROGRESSO.md` e me diga em poucas linhas onde parei
  e qual era o próximo passo.

### Ao terminar uma sessão
Quando eu disser "terminei", "vou parar" ou algo parecido:
1. Atualize o `PROGRESSO.md` (formato abaixo).
2. Faça commit de tudo com uma mensagem descritiva em português.
3. Rode `git push` e confirme que subiu.

### Formato do PROGRESSO.md
Mantenha no topo a seção "Onde parei", sempre substituída pela mais recente:
- Data e computador usado
- Assunto que eu estava estudando
- O que foi feito na sessão (incluindo o último exercício)
- Próximo passo (o que eu ia fazer em seguida)
- Dúvidas pendentes, se houver

Abaixo, mantenha um histórico curto das sessões anteriores (uma linha cada).

## Perfil do GitHub

Meu perfil fica no repositório `codevilelax/codevilelax` (arquivo `README.md`).
Ao terminar uma sessão, depois do push acima, veja se aprendi algo novo que
valha aparecer no perfil.

- Só conte o que eu já pratiquei em exercícios concluídos. Nunca coloque um
  assunto que acabei de começar ou que ainda está nos planos.
- Exemplos do que vale: concluir um assunto inteiro (ex: fundamentos, POO),
  usar Composer ou Laravel de verdade em exercícios, terminar um projeto em `projetos`.
- O que atualizar: a linha "📚 Aprendendo..." em "Sobre mim", os ícones em
  "Tecnologias" (do devicon) e, se fizer sentido, "Estudos em andamento".
- Pode fazer commit e push direto, sem pedir aprovação. Depois me diga em uma
  linha o que mudou.
- Se não houver nada novo, não mexa no perfil.

Como mexer no repositório do perfil:
- Ele fica em `../codevilelax`. Se a pasta não existir neste computador, clone com
  `gh repo clone codevilelax/codevilelax ../codevilelax`. Rode `git pull` antes de editar.
- Faça os commits com o e-mail privado do GitHub, configurado só nesse repositório:
  `git config user.email "235184508+codevilelax@users.noreply.github.com"`.
- Nunca coloque no perfil telefone, e-mail pessoal ou endereço.

## Exercícios

Não entregue a solução completa, a menos que eu peça.

Antes de qualquer resposta, me dê uma dica para eu tentar sozinho.

Cada exercício fica em um arquivo próprio, numerado, na pasta do assunto (ex: `01-fundamentos/ex02-compras.php`). Ao passar um exercício novo, crie o arquivo com o enunciado em comentário no topo. Não coloque no enunciado uma linha para eu anotar os valores que testei.

Quando eu cometer um erro:
- diga onde está o erro;
- explique de forma simples;
- deixe eu tentar corrigir antes de mostrar a resposta.

## Estrutura dos estudos

- `01-fundamentos` — variáveis, arrays, condicionais, loops, funções
- `02-web` — formulários, GET/POST, sessões
- `03-banco-de-dados` — MySQL, PDO
- `04-poo` — classes, objetos, herança
- `05-composer` — pacotes e autoload
- `06-laravel` — framework Laravel
- `projetos` — projetos práticos
