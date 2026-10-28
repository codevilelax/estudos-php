<?php

// Projeto: Cadastro de pessoas
// Parte 3: Apagar uma pessoa
//
// O programa pergunta o id da pessoa e apaga essa pessoa do banco com DELETE.
// No fim, mostra qual id foi apagado.
//
// Regras:
// - O id vem do readline, nada escrito na mão no SQL.
// - Use o jeito seguro: prepare com ? e execute.
// - Não esqueça o WHERE! Sem ele, o DELETE apaga todo mundo.
// - A conexão com o banco é igual à do buscar.php (pode copiar de lá).
//
// Apague o cadastro de id 502:
// Digite o id da pessoa: 502
// Pessoa de id 502 apagada.
//
// Depois, rode o buscar.php com SP: o id 502 não pode mais aparecer na lista,
// e o total tem que ser 118 pessoas (hoje são 119).

require __DIR__ . "/conexao.php";

$id = readline("Digite o id da pessoa: ");

$delete = $banco->prepare("DELETE FROM pessoas WHERE id = ?");
$delete->execute([$id]);

echo "Pessoa de id " . $id . " apagada.";
