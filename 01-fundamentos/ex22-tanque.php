<?php

// Exercício 22: Tanque de gasolina (if e else dentro do while)
// O carro começa com 50 litros no tanque e gasta 10 litros a cada hora de viagem,
// até o tanque ficar vazio (0 litros).
// Crie a variável $gastoPorHora com quanto o carro gasta por hora (10).
// Faça em duas etapas. Só passe para a etapa 2 quando a etapa 1 funcionar.
//
// Etapa 1: use um loop while para mostrar só os litros,
// cada valor em uma linha. Rode e confira:
// 50 litros
// 40 litros
// 30 litros
// 20 litros
// 10 litros
// 0 litros
//
// Etapa 2: dentro do loop, coloque um if / else para mostrar,
// ao lado de cada valor:
//    - 20 litros ou menos: "abastecer"
//    - mais de 20 litros: "ok"
//
// Saída esperada no final:
// 50 litros - ok
// 40 litros - ok
// 30 litros - ok
// 20 litros - abastecer
// 10 litros - abastecer
// 0 litros - abastecer

$litros = 50;
$gastoPorHora = 10;

while ( $litros >= 0 ) {
    echo $litros . " litros - ";

    if ( $litros <= 20 ) {
        echo "abastecer\n";
    }
    else {
        echo "ok\n";
    }
    $litros = $litros - $gastoPorHora;
}

