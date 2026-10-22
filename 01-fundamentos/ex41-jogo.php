<?php

// Exercício 41: Vida no jogo (+= e -=)
//
// Seu personagem começa com 100 de vida, leva alguns golpes e depois toma uma poção.
// Crie as variáveis $vida (100) e $pocao (50) e o array $danos com estes
// valores: 20, 15, 30.
// Use um loop foreach para tirar cada dano da $vida com -= e mostrar a vida
// depois de cada golpe.
// Quando o loop terminar, some a $pocao na $vida com += e mostre a vida final.
//
// Use só += e -= (nada de $vida = $vida - ...).
//
// Saída esperada:
// Levou 20 de dano - vida: 80
// Levou 15 de dano - vida: 65
// Levou 30 de dano - vida: 35
// Tomou uma poção de 50 - vida: 85

$vida = 100; $pocao = 50;
$danos = [20, 15, 30];

foreach ($danos as $dano) {
    $vida -= $dano;
    echo "Levou " . $dano . " de dano" ." - " . "vida: ". $vida . "\n";
} 
$vida += $pocao ;
echo "Tomou uma poção de " . $pocao . " - vida: " . $vida;