<?php

// Exercício 3: Média do aluno
// Crie um array $notas com 3 notas de um aluno (ex: 8, 6, 7).
// Mostre, cada um em uma linha:
// 1. Quantas notas o aluno tem
// 2. A média das notas
// 3. A situação do aluno, usando a média:
//    - 7 ou mais: "Aprovado"
//    - 5 ou mais (e menor que 7): "Recuperação"
//    - menor que 5: "Reprovado"

$notas = [8, 4, 5];
$quantidade =  count($notas);
$media = ($notas[0] + $notas[1] + $notas[2]) / $quantidade;

echo "O aluno tem " . $quantidade . " notas.\n"
. "A média do aluno foi " . $media .".\n";

if ($media >= 7) {
    echo "Aluno aprovado.";
} elseif ($media >= 5) {
    echo "Aluno em Recuperação.";
}  else {
    echo "Aluno Reprovado";
}