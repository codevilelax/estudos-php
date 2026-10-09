<?php

// Exercício 16: Cofrinho
// Você guarda R$ 50 por mês no cofrinho.
// Use um loop while para mostrar quanto tem no cofrinho no fim de cada mês,
// do mês 1 até o mês 12.
// Crie a variável $valorMensal com o valor guardado por mês (50).
// Cada mês aparece em uma linha.
//
// Saída esperada (com $valorMensal = 50):
// Mês 1: R$ 50
// Mês 2: R$ 100
// Mês 3: R$ 150
// (...)
// Mês 12: R$ 600

$valorMensal = 50;
$mes = 0;

while ($mes < 12) {
    $mes = $mes + 1;
    echo "Mês " . $mes . ": R$ " . $valorMensal * $mes ."\n";
}
    
