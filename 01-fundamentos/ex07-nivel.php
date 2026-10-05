<?php

// Exercício 7: Nível do jogador
// Num jogo, o nível do jogador depende dos pontos que ele tem:
//    - menos de 100 pontos: "Bronze"
//    - de 100 até 499 pontos: "Prata"
//    - de 500 até 999 pontos: "Ouro"
//    - 1000 pontos ou mais: "Diamante"
//
// Crie a variável $pontos e mostre, cada um em uma linha:
// 1. Os pontos do jogador. Ex: "Pontos: 350"
// 2. O nível dele. Ex: "Nível: Prata"
// 3. Quantos pontos faltam para o próximo nível. Ex: "Faltam 150 pontos para Ouro"
//    Se ele já for Diamante, mostre: "Você está no nível máximo!"


$pontos = 1000;

echo "Você tem " . $pontos . " pontos.\n";

if ($pontos < 100) {
    $nivel1 = 100 - $pontos;
    echo "Seu nível é: Bronze.\n"
. "Faltam " . $nivel1 . " pontos para você subir para Prata.\n";
} elseif ($pontos <= 499 ) {
    $nivel2 = 500 - $pontos;
    echo "O seu nível é: Prata.\n"
. "Faltam " . $nivel2 . " pontos para você subir para Ouro.\n";
} elseif ($pontos <= 999 ) {
    $nivel3 = 1000 - $pontos;
    echo "O seu nível é: Ouro.\n"
. "Faltam " . $nivel3 . " pontos para você subir para Diamante.\n";
} else {
    echo "Seu nível é: Diamante.\n"
. "Você está no nível máximo.";
}