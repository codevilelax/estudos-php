<?php

// Exercício 19: Aniversários
// Em 2026 você tem 15 anos.
// Use um loop while para mostrar a sua idade em cada ano, até fazer 18 anos.
// Crie as variáveis $ano (2026) e $idade (15).
// Cada ano aparece em uma linha.
//
// Saída esperada (com $ano = 2026 e $idade = 15):
// 2026: 15 anos
// 2027: 16 anos
// 2028: 17 anos
// 2029: 18 anos

$ano = 2026;
$idade = 15;

while ( $idade <= 18) {
    echo $ano . ": " . $idade ." anos\n";
    $idade = $idade + 1;
    $ano = $ano +1;
}

