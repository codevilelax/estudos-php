# Resumo: `for`

Resumo do que já pratiquei nos exercícios 27 a 33. Dá para ler pelo celular.

## O que é

O `for` repete um bloco de código, igual ao `while`, mas junta as 3 partes do loop
numa linha só, separadas por `;`:

```php
for ($n = 1; $n <= 10; $n++) {
    echo $n . "\n";
}
echo "Treino concluído!";
```

1. **Começo:** `$n = 1` (roda uma vez, antes de tudo).
2. **Condição:** `$n <= 10` (até quando repetir).
3. **Passo:** `$n++` (roda no fim de cada volta).

O que fica depois do `}` roda uma vez só, quando o loop termina.

## O mesmo loop com `while` e com `for`

```php
$n = 1;
while ($n <= 10) {
    echo $n . "\n";
    $n++;
}
```

```php
for ($n = 1; $n <= 10; $n++) {
    echo $n . "\n";
}
```

Os dois mostram de 1 até 10. No `for` fica mais difícil esquecer o passo.

## O atalho `++`

- `$senha++` é o mesmo que `$senha = $senha + 1` (ex31).
- Para andar de outro jeito, escrevo a conta inteira no passo:
  - De 20 em 20: `$volume = $volume + $aumento` (ex29)
  - Para trás: `$i = $i - 1` com `>` na condição (ex28)
  - Para trás de 15 em 15: `$tempo = $tempo - $diminuiPorAviso` com `>=` (ex30)

## `if` / `elseif` / `else` dentro do `for`

Cada volta passa pelo `if`, e cada número recebe a sua resposta (ex29 a ex31):

```php
for ($senha = 1; $senha <= 6; $senha++) {
    echo "Senha " . $senha . " - ";
    if ($senha < $minhaSenha) {
        echo "já chamada\n";
    }
    elseif ($senha == $minhaSenha) {
        echo "sua vez!\n";
    }
    else {
        echo "aguarde\n";
    }
}
```

O PHP testa de cima para baixo e para no primeiro que der certo.
Por isso a ordem dos casos importa (ex30: primeiro `>= 30`, depois `>= 1`, o resto é 0).

## Conta dentro do loop

Dá para usar o contador numa conta, a cada volta (ex32 e ex33):

```php
for ($pessoas = 1; $pessoas <= 6; $pessoas++) {
    $vlr = $precoIngresso * $pessoas;
    echo $pessoas . " pessoa(s): R$ " . $vlr . "\n";
}
```

O contador (`$pessoas`) muda sozinho; o preço (`$precoIngresso`) fica fixo.

## Cuidado com a divisa

O valor exato decide entre `<` e `<=`:

- Gastar exatamente R$ 40 ainda cabe no orçamento: `$vlr <= $orcamento` (ex33).
- Chegar exatamente na meta já conta: `$km < $meta` vai para "continua treinando",
  o resto é "meta batida!" (ex32).
- Na prova, 0 minutos também precisa aparecer: `$tempo >= 0` na condição (ex30).

## Próximo

`foreach`, para passar pelos itens de um array (ex34).
