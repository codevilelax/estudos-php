<?php

// Exercício 26: Forno (último while)
// Sem etapas: tente fazer tudo sozinho.
//
// O forno começa a 20 graus e esquenta 40 graus a cada minuto,
// até chegar a 220 graus.
// Crie as variáveis $temperatura (20) e $aumentoPorMinuto (40).
// Use um loop while para mostrar a temperatura de minuto em minuto, e um
// if / elseif / else para mostrar ao lado:
//    - menos de 100 graus: "frio"
//    - de 100 até menos de 180 graus: "esquentando"
//    - 180 graus ou mais: "pronto"
// Quando o loop terminar, mostre "Pode colocar o bolo!".
//
// Saída esperada:
// 20 graus - frio
// 60 graus - frio
// 100 graus - esquentando
// 140 graus - esquentando
// 180 graus - pronto
// 220 graus - pronto
// Pode colocar o bolo!

$temperatura = 20; $aumentoPorMinuto = 40;

while ($temperatura <= 220) {
    echo $temperatura . " graus " . "-";
    if ($temperatura < 100) {
        echo " frio\n";
    } elseif ($temperatura < 180) {
        echo " esquentando\n";
    } else {
        echo " pronto\n";
    }
    $temperatura = $temperatura + $aumentoPorMinuto;
}
echo "Pode colocar o bolo!";
