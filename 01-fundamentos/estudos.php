<?php

$aluno = "Pedro";

$nota1 = 1; $nota2 = 5; $nota3 = 0;
$media = ($nota1 + $nota2 + $nota3) / 3;

if ($media >= 7) {
    $situacao = "Aprovado";
} elseif ($media >= 5) {
    $situacao = "Recuperação";
} else {
    $situacao = "Reprovado";
}

echo "Aluno: $aluno" . PHP_EOL;
echo "Média: " . number_format($media, 1, ',', '.') . PHP_EOL;
echo "Situação: $situacao" . PHP_EOL;
