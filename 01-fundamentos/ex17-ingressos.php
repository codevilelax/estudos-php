<?php

// Exercício 17: Ingressos de cinema
// Cada ingresso de cinema custa R$ 25.
// Use um loop while para mostrar quanto custa comprar de 1 até 8 ingressos.
// Crie a variável $precoIngresso com o preço de um ingresso (25).
// Cada quantidade aparece em uma linha.
//
// Saída esperada (com $precoIngresso = 25):
// 1 ingresso(s): R$ 25
// 2 ingresso(s): R$ 50
// 3 ingresso(s): R$ 75
// (...)
// 8 ingresso(s): R$ 200

$vlrIngresso = 25;
$ingressos = 1;

while ($ingressos <= 8) {
    echo $ingressos . " ingresso(s): R$ " . $vlrIngresso * $ingressos . "\n";
    $ingressos = $ingressos + 1;
}

