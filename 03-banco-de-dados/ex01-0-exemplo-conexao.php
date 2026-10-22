<?php

// Exemplo: conectar no banco e mostrar 5 pessoas
// Rode e veja o resultado. Depois a gente lê linha por linha.

// 1. Conectar no banco (o arquivo estudos.sqlite, na pasta banco)
$banco = new PDO("sqlite:" . __DIR__ . "/banco/estudos.sqlite");

// 2. Pedir para o PHP mostrar o erro quando o SQL estiver errado
$banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 3. Fazer uma pergunta ao banco, em SQL
$pessoas = $banco->query("SELECT nome, idade, cidade, uf FROM pessoas LIMIT 5");

// 4. Passar por cada pessoa com o foreach
foreach ($pessoas as $pessoa) {
    echo $pessoa["nome"] . " - " . $pessoa["idade"] . " anos - " . $pessoa["cidade"] . "/" . $pessoa["uf"] . "\n";
}
