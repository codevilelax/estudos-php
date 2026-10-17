<?php

// Exercício 25: Corrida (aquecimento antes do for)
// Sem etapas: tente fazer tudo sozinho.
//
// O corredor começa no km 0 e avança 2 km a cada volta,
// até chegar ao km 10.
// Crie as variáveis $km (0) e $kmPorVolta (2).
// Use um loop while para mostrar o km de volta em volta, e um if / else
// para mostrar ao lado:
//    - menos de 6 km: "no ritmo"
//    - 6 km ou mais: "cansado"
// Quando o loop terminar, mostre "Chegou!".
//
// Saída esperada:
// Km 0 - no ritmo
// Km 2 - no ritmo
// Km 4 - no ritmo
// Km 6 - cansado
// Km 8 - cansado
// Km 10 - cansado
// Chegou!

$km = 0; $kmPorVolta = 2;

while ( $km <= 10 ) {
    echo "Km " . $km . " - ";
    if ( $km < 6 ) {
        echo "no ritmo\n";
    }
    else {
        echo "cansado\n";
    }
    $km = $km + $kmPorVolta;
}
echo "Chegou!";
