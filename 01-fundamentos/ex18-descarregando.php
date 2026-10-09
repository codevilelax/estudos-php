<?php

// Exercício 18: Bateria descarregando
// O celular começa com 100% de bateria e perde 20% a cada hora de jogo.
// Use um loop while para mostrar a bateria, de hora em hora, até chegar a 0%.
// Quando o loop terminar, mostre "Celular desligou!".
// Crie a variável $gastoPorHora com quanto a bateria perde por hora (20).
// Cada valor aparece em uma linha.
//
// Saída esperada (com $gastoPorHora = 20):
// Bateria: 100%
// Bateria: 80%
// Bateria: 60%
// Bateria: 40%
// Bateria: 20%
// Bateria: 0%
// Celular desligou!


$gastoPorHora = 20;
$bateria = 100;

while ( $bateria >= 0) {
    echo "Bateria: " . $bateria . "%\n";
    $bateria = $bateria - $gastoPorHora;
} echo "Celular desligou!";
