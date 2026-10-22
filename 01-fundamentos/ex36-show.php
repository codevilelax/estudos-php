<?php

// Exercício 36: Entrada do show (foreach com if / else)
//
// Você trabalha na entrada de um show que só aceita maiores de idade.
// Crie a variável $idadeMinima (18) e o array $idades com estes valores:
// 15, 18, 22, 17, 30.
// Use um loop foreach para passar por cada idade e um if / else para mostrar:
//    - se a pessoa tem a idade mínima ou mais: "pode entrar"
//    - se não: "não pode entrar"
// Quando o loop terminar, mostre "Fim da fila.".
//
// Atenção: quem tem exatamente 18 anos pode entrar.
//
// Saída esperada:
// Idade 15 - não pode entrar
// Idade 18 - pode entrar
// Idade 22 - pode entrar
// Idade 17 - não pode entrar
// Idade 30 - pode entrar
// Fim da fila.

$idadeMinima = 18; 
$idades = [15, 18, 22, 17, 30];

foreach ($idades as $idade) {
    echo "Idade " . $idade . " - ";
    if ($idade < $idadeMinima) {
        echo "não pode entrar\n";
    }
    else {
        echo "pode entrar\n";
    }
}
echo "Fim da fila.";