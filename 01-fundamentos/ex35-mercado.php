<?php

// Exercício 35: Lista do mercado (foreach)
//
// Crie um array $compras com estes 5 itens: "arroz", "feijão", "leite", "pão", "café".
// Antes do loop, mostre "Lista do mercado:".
// Use um loop foreach para mostrar cada item com "- " na frente.
// Quando o loop terminar, mostre "Total: 5 itens", usando count para
// contar os itens (não escreva o 5 direto no echo).
//
// Saída esperada:
// Lista do mercado:
// - arroz
// - feijão
// - leite
// - pão
// - café
// Total: 5 itens

$compras = ["arroz", "feijão", "leite", "pão", "café"];
$quantidade = count($compras);

echo "Lista do mercado:\n";

foreach ($compras as $compra) {
    echo "- " . $compra . "\n";
}
echo "Total: " . $quantidade . " itens";