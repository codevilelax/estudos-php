<?php

// Exercício 14: Contagem regressiva (primeiro loop)
// Use um loop while para fazer uma contagem regressiva de 10 até 1.
// Cada número aparece em uma linha.
// Quando o loop terminar, mostre "Feliz Ano Novo!".
//
// Saída esperada:
// 10
// 9
// 8
// (...)
// 1
// Feliz Ano Novo!

$feliz = 10;

while ($feliz >= 1) {
    echo $feliz . "\n";
    $feliz = $feliz - 1;
} 
    echo "Feliz ano novo!";
