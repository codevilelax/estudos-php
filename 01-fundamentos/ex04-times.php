<?php

// Exercício 4: Times de futebol
// Crie dois arrays: $timeA e $timeB, cada um com nomes de jogadores
// (podem ter quantidades diferentes de jogadores).
// Mostre, cada um em uma linha:
// 1. Quantos jogadores tem o time A
// 2. Quantos jogadores tem o time B
// 3. Qual time tem mais jogadores e quantos a mais. Ex: "O time A tem 2 jogadores a mais."
//    Se os dois tiverem a mesma quantidade, mostre: "Os times estão equilibrados."
// 4. O nome do capitão de cada time (o capitão é o primeiro jogador da lista)

$timeA = ["Carlos", "Rafael", "Bruno", "Diego", "Lucas", "Thiago", "Mateus"];
$timeB = ["André", "Felipe", "Gustavo", "Rodrigo", "Vinícius"];

$qntA = count( $timeA );
$qntB = count( $timeB );
$dif = $qntA - $qntB;
$dif2 = $qntB - $qntA;

echo "O time A tem " . $qntA . " jogadores.\n"
. "O time B tem " . $qntB . " jogadores.\n";

if ($qntA > $qntB) {
    echo "O time A tem " . $dif . " Jogadores à mais que o time B.\n";
} elseif ($qntA < $qntB) {
    echo "O time B tem ". $dif2 . " Jogadores à mais que o time A.\n";
} else {
    echo "Ambos os times tem a mesma quantidade de jogadores, sendo ". $qntA . " em cada time.\n";
}

echo "O capitao do time A é " . $timeA[0] . ".\n" 
. "O capitao do time B é " . $timeB[0] . ".\n";