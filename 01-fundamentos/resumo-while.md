# Resumo: `while`

Resumo do que já pratiquei nos exercícios 13 a 19. Dá para ler pelo celular.

## O que é

O `while` repete um bloco de código **enquanto** a condição for verdadeira.
Quando a condição fica falsa, o PHP sai do loop e segue para a linha depois do `}`.

```php
$contador = 1;

while ($contador <= 5) {
    echo $contador . "\n";
    $contador = $contador + 1;
}
```

## As 3 partes de todo loop

1. **Começo:** a variável contadora antes do `while` (`$contador = 1;`).
2. **Condição:** até quando repetir (`$contador <= 5`).
3. **Passo:** mudar o contador dentro do loop (`$contador = $contador + 1;`).

Se esquecer o passo, a condição nunca fica falsa: **loop infinito**.
Para parar no terminal: `Ctrl + C`.

## Dois jeitos de contar de 1 até 10

Começa em 1, usa `<=`, soma **depois** do `echo` (ex17):

```php
$i = 1;
while ($i <= 10) {
    echo $i . "\n";
    $i = $i + 1;
}
```

Começa em 0, usa `<`, soma **antes** do `echo` (ex15 e ex16):

```php
$i = 0;
while ($i < 10) {
    $i = $i + 1;
    echo $i . "\n";
}
```

Os dois mostram de 1 até 10. O importante é combinar o começo, a condição e
o lugar da soma.

## Outros jeitos de andar

- De 2 em 2: `$par = $par + 2;` (ex14)
- Para trás: `$feliz = $feliz - 1;` com `>=` na condição (ex13 e ex18)
- Duas variáveis mudando juntas: `$idade` e `$ano` (ex19)

## Algo depois do loop

O que fica **depois** do `}` roda uma vez só, quando o loop termina (ex13 e ex18):

```php
while ($bateria >= 0) {
    echo "Bateria: " . $bateria . "%\n";
    $bateria = $bateria - $gastoPorHora;
}
echo "Celular desligou!";
```

## Erros que já cometi

- Aumentar a variável **fixa** (`$numero`, `$valorMensal`) em vez do contador.
  O valor fixo não muda; só o contador anda.
- Esquecer de aumentar o contador (loop infinito).
- Começar o contador no **fim** (12) em vez do começo.
- Somar antes do `echo` sem ajustar o começo, e perder o primeiro número.
- Esquecer o `}`: erro `unexpected end of file`.
- Linha em branco antes do `<?php`: ela aparece na saída.
- Esquecer de salvar o arquivo antes de rodar.

## Próximo

`if` dentro do `while` (ex20 e ex21).
