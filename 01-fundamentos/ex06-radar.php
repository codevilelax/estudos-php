<?php

// Exercício 6: Radar de velocidade
// Numa rua com limite de 60 km/h, o radar funciona assim:
//    - até 60 km/h: "Velocidade permitida"
//    - mais de 60 e até 80 km/h: "Multa leve"
//    - mais de 80 e menos de 120 km/h: "Multa grave"
//    - 120 km/h ou mais: "Carteira suspensa"
//
// Crie uma variável $velocidade e mostre a mensagem certa.
//
// Desafio: descubra sozinho quais valores você precisa testar
// para ter certeza de que o programa está certo.
// Anote aqui embaixo os valores que você testou:
//140; 50; 70; 90; 61;

$velocidade = 61;

if ($velocidade <= 60) {
    echo "Velocidade permitida.";
} elseif ($velocidade <= 80) {
    echo "Multa leve.";
} elseif ($velocidade < 120) {
    echo "Multa grave";
} else {
    echo "Carteira suspensa.";
}