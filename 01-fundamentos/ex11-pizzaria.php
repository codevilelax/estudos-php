<?php

// Exercício 11: Frete da pizzaria
// Uma pizzaria calcula o frete pelo valor do pedido e pela distância.
//
// Primeiro, olhe a distância:
//    - Mais de 10 km: "Fora da área de entrega".
//      Nesse caso, o valor do pedido não importa.
//
// Se a distância for 10 km ou menos, o frete depende do valor do pedido.
// Atenção: as regras abaixo estão fora de ordem de propósito.
//    - de 50 até menos de 80 reais: "Frete: R$ 5" 2 
//    - menos de 30 reais: "Frete: R$ 12" 4 
//    - 80 reais ou mais: "Frete grátis!" 1
//    - de 30 até menos de 50 reais: "Frete: R$ 8" 3 
//
// Antes de escrever o código, desenhe no caderno a ordem em que o PHP
// deve fazer os testes.
//
// Crie as variáveis $valorPedido e $distancia.
// Mostre, cada um em uma linha:
// 1. O valor do pedido. Ex: "Pedido: R$ 45"
// 2. A distância. Ex: "Distância: 4 km"
// 3. O frete, seguindo as regras acima.

$vlrPed= 20; $distancia= 11;

echo "Pedido: R$ " . $vlrPed .".\n"
. "Distância: " . $distancia ." km.\n";

if ($distancia > 10) {
    echo "Fora de área de entrega.";
} else if ($vlrPed >= 80) {
    echo "Frete grátis.";
} else if ($vlrPed >= 50) {
    echo "Frete R$ 5.";
} else if ($vlrPed >= 30) {
    echo "Frete R$ 8.";
} else {
    echo "Frete R$ 12.";
}