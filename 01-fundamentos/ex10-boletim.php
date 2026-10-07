<?php

// Exercício 10: Boletim com faltas (revisão)
// Descubra a situação do aluno no fim do ano.
//
// Primeiro, olhe as faltas:
//    - Mais de 10 faltas: "Reprovado por faltas".
//      Nesse caso, a média não importa.
//
// Se o aluno tiver 10 faltas ou menos, olhe a média:
//    - 7 ou mais: "Aprovado"
//    - de 5 até menos de 7: "Recuperação"
//    - menos de 5: "Reprovado por nota"
//
// Crie um array $notas com 3 notas e uma variável $faltas.
// Mostre, cada um em uma linha:
// 1. A média do aluno. Ex: "Média: 7"
// 2. O número de faltas. Ex: "Faltas: 4"
// 3. A situação do aluno, seguindo as regras acima.

$notas = [4, 7, 5];
$quantidadeNotas = count($notas);
$media = ($notas[0] + $notas[1] + $notas[2]) / $quantidadeNotas;
$faltas = 10;

echo "A média do aluno foi: " . round($media, 2) . ".\n"
. "O aluno teve " . $faltas . " faltas.\n";

if ($faltas > 10) {
    echo "Reprovado por faltas!";
} elseif ($media >= 7) {
    echo "Aprovado!";
} elseif ($media >= 5) {
    echo "Recuperação.";
} else {
    echo "Reprovado por nota";
}