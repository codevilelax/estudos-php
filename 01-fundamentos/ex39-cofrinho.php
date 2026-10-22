<?php

// Exercício 39: Cofrinho da semana (somar com foreach)
//
// Você guardou dinheiro no cofrinho durante 5 dias e quer saber quanto juntou.
//
// Etapa 1:
// Crie o array $depositos com estes valores: 10, 5, 20, 15, 30.
// Use um loop foreach para mostrar uma linha para cada depósito:
//    "Guardou R$ 10"
// Rode e confira antes de passar para a etapa 2.
//
// Etapa 2:
// Crie a variável $total começando em 0 (antes do loop).
// Dentro do loop, some cada depósito no $total.
// Quando o loop terminar, mostre "Total no cofrinho: R$ 80", usando o $total
// (não escreva o 80 direto no echo).
//
// Saída esperada:
// Guardou R$ 10
// Guardou R$ 5
// Guardou R$ 20
// Guardou R$ 15
// Guardou R$ 30
// Total no cofrinho: R$ 80

$depositos = [10, 5, 20, 15, 30];
$total = 0;

foreach ($depositos as $deposito) {
    $total += $deposito;
    echo "Guardou R$ " . $deposito . "\n";
}
echo "Total no cofrinho: R$ " . $total;