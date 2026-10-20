<?php

// Exercício 30: Tempo da prova (for contando para baixo, com três casos)
// Sem etapas: tente fazer tudo sozinho.
//
// A prova tem 60 minutos. A cada aviso do professor, o tempo que falta
// diminui 15 minutos, até chegar a 0.
// Crie a variável $diminuiPorAviso (15) antes do loop.
// Use um loop for para mostrar quanto tempo falta a cada aviso, e um
// if / elseif / else para mostrar ao lado:
//    - 30 minutos ou mais: "com calma"
//    - de 1 até 29 minutos: "acelera"
//    - 0 minutos: "acabou"
// Quando o loop terminar, mostre "Entreguem a prova!".
//
// Saída esperada:
// Faltam 60 min - com calma
// Faltam 45 min - com calma
// Faltam 30 min - com calma
// Faltam 15 min - acelera
// Faltam 0 min - acabou
// Entreguem a prova!

$diminuiPorAviso = 15;

for ( $tempo = 60; $tempo >= 0; $tempo = $tempo - $diminuiPorAviso) {
    echo "Faltam " . $tempo . " min - ";
    if ( $tempo >= 30 ) {
        echo "com calma" . "\n";
    }
    elseif ( $tempo >= 1 ) {
        echo "acelera" . "\n";
    }
    else {
        echo "acabou" . "\n";
    }
}
echo "Entreguem a prova!";
