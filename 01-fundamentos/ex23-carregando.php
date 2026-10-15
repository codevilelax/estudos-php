<?php

// Exercício 23: Celular carregando (if e else dentro do while)
// O celular começa com 0% de bateria e ganha 20% a cada hora na tomada,
// até chegar a 100%.
// Crie as variáveis $bateria (0) e $cargaPorHora (20).
// Faça em duas etapas. Só passe para a etapa 2 quando a etapa 1 funcionar.
//
// Etapa 1: use um loop while para mostrar só a bateria,
// cada valor em uma linha. Rode e confira:
// Bateria: 0%
// Bateria: 20%
// Bateria: 40%
// Bateria: 60%
// Bateria: 80%
// Bateria: 100%
//
// Etapa 2: dentro do loop, coloque um if / else para mostrar,
// ao lado de cada valor:
//    - menos de 100%: "carregando"
//    - 100%: "carga completa"
//
// Saída esperada no final:
// Bateria: 0% - carregando
// Bateria: 20% - carregando
// Bateria: 40% - carregando
// Bateria: 60% - carregando
// Bateria: 80% - carregando
// Bateria: 100% - carga completa

$bateria = 0;
$cargaPorHora = 20;

while ( $bateria <= 100 ) {
    echo "Bateria: " . $bateria . "% - ";
    if ( $bateria < 100 ) {
        echo "carregando\n";
    }
    else {
        echo "carga completa\n";
    }
    $bateria = $bateria + $cargaPorHora;
}