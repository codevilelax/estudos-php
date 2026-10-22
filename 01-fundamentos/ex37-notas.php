<?php

// Exercício 37: Notas da turma (foreach com if / else)
// Sem etapas: tente fazer tudo sozinho.
//
// O professor quer saber quem passou na prova.
// Crie a variável $notaMinima (6) e o array $notas com estes valores:
// 7, 4, 6, 9, 5, 10.
// Use um loop foreach para passar por cada nota e um if / else para mostrar:
//    - se a nota é 6 ou mais: "aprovado"
//    - se não: "reprovado"
// Quando o loop terminar, mostre "Fim das notas.".
//
// Saída esperada:
// Nota 7 - aprovado
// Nota 4 - reprovado
// Nota 6 - aprovado
// Nota 9 - aprovado
// Nota 5 - reprovado
// Nota 10 - aprovado
// Fim das notas.

$notaMinima = 6;
$notas = [7, 4, 6, 9, 5, 10];

foreach ($notas as $nota) {
    echo "Nota " . $nota . " - ";
    if ($nota < $notaMinima) {
        echo "reprovado\n";
    }
    else {
        echo "aprovado\n";
    }
}
echo "Fim das notas.";