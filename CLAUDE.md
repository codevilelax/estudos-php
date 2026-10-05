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

## Exercícios

Não entregue a solução completa, a menos que eu peça.

Antes de qualquer resposta, me dê uma dica para eu tentar sozinho.

Cada exercício fica em um arquivo próprio, numerado, na pasta do assunto (ex: `01-fundamentos/ex02-compras.php`). Ao passar um exercício novo, crie o arquivo com o enunciado em comentário no topo.

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
