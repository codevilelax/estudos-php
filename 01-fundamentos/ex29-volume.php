<?php

// Exercício 29: Volume (for com if / else)
// O volume da música começa em 0 e sobe 20 a cada aperto no botão,
// até chegar a 100.
// Crie a variável $aumento (20) antes do loop.
// Use um loop for para mostrar o volume a cada aperto, e um if / else
// para mostrar ao lado:
//    - menos de 60: "baixo"
//    - 60 ou mais: "alto"
// Quando o loop terminar, mostre "Volume no máximo!".
//
// Saída esperada:
// Volume 0 - baixo
// Volume 20 - baixo
// Volume 40 - baixo
// Volume 60 - alto
// Volume 80 - alto
// Volume 100 - alto
// Volume no máximo!

$aumento = 20;

for ($volume = 0; $volume <= 100; $volume = $volume + $aumento) {
    echo "Volume " . $volume . " - ";
    if ($volume < 60) {
        echo "baixo" . "\n";
    }
    else {
        echo "alto" . "\n";
    }
}
echo "Volume no máximo!";
