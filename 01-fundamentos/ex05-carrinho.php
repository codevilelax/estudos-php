<?php

// Exercício 5: Carrinho de compras
// Uma loja dá desconto conforme o valor total da compra:
//    - 100 reais ou mais: 10% de desconto
//    - 50 reais ou mais (e menos de 100): 5% de desconto
//    - menos de 50 reais: sem desconto
//
// Usando o array $precos abaixo, mostre, cada um em uma linha:
// 1. Quantos produtos tem no carrinho
// 2. O valor total da compra (sem desconto)
// 3. Quanto de desconto o cliente ganhou (em reais)
// 4. O valor final a pagar

$precos = [25, 40, 15, 30];
$total = $precos[0] + $precos[1] + $precos[2] + $precos[3];
$produtos = count($precos);

echo "A quantidade de produtos no carrinho é de " . $produtos . ".\n";

echo "O valor total da compra foi de R$ " . $total ." sem desconto.\n";

if ($total >= 100) {
    $desconto1 = $total * 0.1;
    echo "Você ganhou um desconto de R$ " . $desconto1 .". O total da compra é de R$ " . ($total - $desconto1) . ".\n";
} elseif ($total >= 50) {
    $desconto2 = $total * 0.05;
    echo "Você ganhou um desconto de R$ ". $desconto2 .". O total da compra é de R$ " . ($total - $desconto2) . ".\n";
} else {
    echo "Compras a baixo de R$ 50 não tem desconto.";
}
