<?php

// Projeto: Cadastro de pessoas
// Parte 2: Cadastrar uma pessoa nova
//
// O programa pergunta o nome, a idade, a cidade e o estado, um de cada vez,
// e cadastra essa pessoa nova no banco com INSERT.
// No fim, mostra a pessoa que foi cadastrada.
//
// Regras:
// - Cada dado vem do readline, nada escrito na mão no SQL.
// - Use o jeito seguro: prepare com ? e execute (um ? para cada dado).
// - A conexão com o banco é igual à do buscar.php (pode copiar de lá).
//
// Cadastre esta pessoa:
// Digite o nome: Carla Mendes
// Digite a idade: 28
// Digite a cidade: Bonito
// Digite o estado: MS
// Pessoa cadastrada: Carla Mendes - 28 anos - Bonito/MS
//
// Depois, rode o buscar.php com MS: a Carla tem que aparecer na lista,
// e agora vão ser 6 pessoas.

$banco = new PDO("sqlite:" . __DIR__ . "/../../03-banco-de-dados/banco/estudos.sqlite");
$banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$nome = readline("Digite seu nome: ");
$idade = readline("Digite sua idade: ");
$cidade = readline("Digite sua cidade: ");
$uf = readline("Digite seu estado: ");

$insert = $banco->prepare("INSERT INTO pessoas (nome, idade, cidade, uf) VALUES (?, ?, ?, ?)");
$insert->execute([$nome, $idade, $cidade, $uf]);

echo "Pessoa cadastrada: " . $nome . " - " . $idade . " anos - " . $cidade . "/" . $uf;
