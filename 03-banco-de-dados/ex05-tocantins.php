<?php

// Exercício 5: Pessoas do Tocantins
//
// Mostre o nome e a idade de cada pessoa do Tocantins (uf = 'TO').
// No fim, mostre quantas pessoas apareceram.
//
// A conexão com o banco é igual à do ex04 (pode copiar de lá).
//
// Saída esperada:
// Gabriela Araújo Nunes - 40 anos
// Adriana Ferreira Lopes - 69 anos
// Diego Almeida Pinto - 58 anos
// Laura Cavalcanti Alves - 19 anos
// Total: 4 pessoas

$banco = new PDO("sqlite:" . __DIR__ . "/banco/estudos.sqlite");
$banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pessoas = $banco->query("SELECT * FROM pessoas WHERE uf = 'TO'");

$qnt = 0;

foreach ($pessoas as $pessoa) {
    $qnt += 1;
    echo $pessoa["nome"] . " - " . $pessoa["idade"] . " anos\n";
    
}
echo "Total: " . $qnt . " pessoas";
