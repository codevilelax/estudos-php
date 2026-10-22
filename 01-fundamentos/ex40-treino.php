<?php

// Exercício 40: Treino da semana (somar com foreach)
// Sem etapas: tente fazer tudo sozinho.
//
// Você correu 5 dias na semana e quer ver o total crescendo a cada dia.
// Crie o array $kms com estes valores: 3, 5, 2, 4, 6.
// Use um loop foreach para somar os km no $total e mostrar, em cada linha,
// quanto correu no dia e o total até agora.
// Quando o loop terminar, mostre "Total da semana: 20 km", usando o $total
// (não escreva o 20 direto no echo).
//
// Saída esperada:
// Corri 3 km - total até agora: 3 km
// Corri 5 km - total até agora: 8 km
// Corri 2 km - total até agora: 10 km
// Corri 4 km - total até agora: 14 km
// Corri 6 km - total até agora: 20 km
// Total da semana: 20 km

$kms = [3, 5, 2, 4, 6];
$total = 0;

foreach ($kms as $km) {
    $total += $km;
    echo "Corri " . $km . " km - total até agora: " . $total . " km" .  "\n";
}
echo "Total da semana: " . $total . " km";