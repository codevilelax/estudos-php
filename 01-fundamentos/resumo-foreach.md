# Resumo: `foreach`

Resumo do que já pratiquei nos exercícios 34 a 41. Dá para ler pelo celular.

## O que é

O `foreach` passa por **cada item** de um array, um de cada vez.
Quando acaba a lista, o PHP sai do loop e segue para a linha depois do `}`.

```php
$frutas = ["maçã", "banana", "uva"];

foreach ($frutas as $fruta) {
    echo $fruta . "\n";
}
```

- `$frutas` (plural): o array inteiro.
- `$fruta` (singular): o item da volta atual.

## Diferença para o `while`

No `while` eu preciso cuidar do começo, da condição e do passo.
No `foreach` não tem contador: ele anda sozinho e para quando os itens acabam.
Por isso não tem como dar loop infinito.

## Algo antes e depois do loop

O que fica **antes** do `foreach` roda uma vez, no começo; o que fica **depois** do `}`
roda uma vez, no fim (ex34 e ex35):

```php
echo "Lista do mercado:\n";

foreach ($compras as $compra) {
    echo "- " . $compra . "\n";
}
echo "Total: " . count($compras) . " itens";
```

`count` conta quantos itens o array tem, sem eu escrever o número na mão.

## `if` / `else` dentro do `foreach`

Cada item passa pelo `if`, e cada um recebe a sua resposta (ex36, ex37 e ex38):

```php
foreach ($idades as $idade) {
    echo "Idade " . $idade . " - ";
    if ($idade < $idadeMinima) {
        echo "não pode entrar\n";
    }
    else {
        echo "pode entrar\n";
    }
}
```

Cuidado com o valor exato: quem tem 18 pode entrar (`<` e não `<=`), quem passa a
60 km/h não é multado (`<=`).

## Somar com o `foreach`

O total começa em 0 **antes** do loop, e cada volta soma o item nele (ex39 e ex40):

```php
$total = 0;

foreach ($depositos as $deposito) {
    $total += $deposito;
}
echo "Total no cofrinho: R$ " . $total;
```

- `$total += $deposito;` é o mesmo que `$total = $total + $deposito;`.
- `$vida -= $dano;` é o mesmo que `$vida = $vida - $dano;` (ex41).
- Se o `echo` do total ficar **dentro** do loop, ele mostra o total até agora em cada
  volta (ex40). **Depois** do `}`, mostra só o total final.

## Erros que já cometi

- Inverter a ordem do `+=`: o cofrinho (`$total`) fica à **esquerda**, o item à direita.

## Próximo

Banco de dados com SQLite (`03-banco-de-dados`).
