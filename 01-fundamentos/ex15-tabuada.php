<?php

// Exercício 15: Tabuada
// Use um loop while para mostrar a tabuada de um número, de 1 até 10.
// Crie a variável $numero com o número da tabuada (ex: 7).
// Cada conta aparece em uma linha.
//
// Saída esperada (com $numero = 7):
// 7 x 1 = 7
// 7 x 2 = 14
// 7 x 3 = 21
// (...)
// 7 x 10 = 70

$numero = 9;
$contador = 0;

while ($contador < 10) {
    $contador = $contador + 1;
    echo $numero ." X ". $contador ." = " . $numero * $contador . "\n";
}

