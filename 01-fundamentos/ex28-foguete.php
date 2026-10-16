<?php

// Exercício 28: Foguete (for contando para baixo)
// Use um loop for para fazer a contagem regressiva do foguete, de 10 até 1.
// Cada número aparece em uma linha.
// Quando o loop terminar, mostre "Decolar!".
//
// Saída esperada:
// 10
// 9
// 8
// (...)
// 1
// Decolar!

for ($i = 10; $i > 0; $i = $i - 1){
    echo $i ."\n";
}
echo "Decolar!";