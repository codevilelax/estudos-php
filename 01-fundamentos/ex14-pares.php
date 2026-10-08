<?php

// Exercício 14: Números pares
// Use um loop while para mostrar os números pares de 2 até 20.
// Cada número aparece em uma linha.
//
// Saída esperada:
// 2
// 4
// 6
// (...)
// 20

$par = 2;

while ( $par <= 20 ) {
    echo $par . "\n";
    $par = $par + 2;
}