<?php

// Exercício 12: Bateria do celular
// Mostre uma mensagem de acordo com a carga da bateria.
//
// As regras:
//    - menos de 20%: "Bateria fraca! Coloque para carregar."
//    - de 20% até menos de 50%: "Bateria média."
//    - de 50% até menos de 90%: "Bateria boa."
//    - 90% ou mais: "Bateria cheia!"
//
// Crie a variável $bateria.
// Mostre, cada um em uma linha:
// 1. A carga da bateria. Ex: "Bateria: 45%"
// 2. A mensagem, seguindo as regras acima.


$bateria = 89;

echo "Bateria: " . $bateria ."%\n";

if ($bateria >= 90) {
    echo "Bateria cheia!";
} else if ($bateria >= 50) {
    echo "Bateria boa.";
} else if ($bateria >= 20) {
    echo "Bateria média.";
} else {
    echo "Bateria fraca! Coloque para carregar.";
}

