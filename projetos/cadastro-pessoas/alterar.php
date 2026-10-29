<?php

// Projeto: Cadastro de pessoas
// Parte 3: Alterar uma pessoa
//
// O programa pergunta o id da pessoa e a idade nova, e troca a idade
// dessa pessoa no banco com UPDATE.
// No fim, mostra qual id foi alterado e a idade nova.
//
// Regras:
// - O id e a idade vêm do readline, nada escrito na mão no SQL.
// - Use o jeito seguro: prepare com ? e execute (um ? para cada dado).
// - Não esqueça o WHERE! Sem ele, o UPDATE muda a idade de todo mundo.
// - Use o require da conexão, igual aos outros arquivos.
//
// A Carla Mendes (id 501) fez aniversário: mude a idade dela de 28 para 29.
// Digite o id da pessoa: 501
// Digite a idade nova: 29
// Pessoa de id 501 agora tem 29 anos.
//
// Depois, rode o buscar.php com MS: a Carla tem que aparecer com 29 anos.

require __DIR__ . "/conexao.php";

$id = readline("id da pessoa: ");
$idade = readline("Digite sua nova idade: ");

$update = $banco->prepare("UPDATE pessoas SET idade = ? WHERE id = ?");
$update->execute([$idade, $id]);

echo "Pessoa de id " . $id . " agora tem " . $idade . " anos.";