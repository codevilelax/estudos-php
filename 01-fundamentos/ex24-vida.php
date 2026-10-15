<?php

// Exercício 24: Vida no jogo (if e else dentro do while)
// Agora sem etapas: tente fazer tudo sozinho.
//
// O personagem começa com 100 de vida e perde 25 a cada golpe que leva,
// até a vida chegar a 0.
// Crie as variáveis $vida (100) e $danoPorGolpe (25).
// Use um loop while para mostrar a vida, de golpe em golpe, e um if / else
// para mostrar ao lado:
//    - 50 ou mais: "tranquilo"
//    - menos de 50: "perigo"
// Quando o loop terminar, mostre "Game over!".
//
// Saída esperada:
// Vida: 100 - tranquilo
// Vida: 75 - tranquilo
// Vida: 50 - tranquilo
// Vida: 25 - perigo
// Vida: 0 - perigo
// Game over!

$vida = 100;
$danoPorGolpe = 25;

while ( $vida >= 0 ) {
    echo "Vida: " . $vida . " - ";
    if ( $vida >= 50 ) {
        echo "tranquilo" . "\n";
    }
    else {
        echo "perigo" . "\n";
    }
    $vida = $vida - $danoPorGolpe;
} 
echo "Game over!";

