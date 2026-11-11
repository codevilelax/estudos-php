<?php

// Exercício 7: Filtro de idade no navegador
//
// Faça uma página que mostra as pessoas de um estado dentro de uma faixa de idade.
//
// O formulário tem:
// - a lista de estados (pode copiar do ex06);
// - dois campos de número para a idade, "De" e "Até":
//     De: <input type="number" name="de">
// - o botão Ver.
//
// Regras:
// - No SQL, filtre só pelo estado (WHERE uf = ?) e ordene pela idade.
// - A faixa de idade você filtra no PHP, dentro do foreach, usando && ("e"):
//     if (condição 1 && condição 2)   -> só entra se as DUAS forem verdade.
// - As idades das pontas contam: "de 30 até 40" inclui quem tem 30 e quem tem 40.
// - Mostre cada pessoa numa linha:  Nome - 30 anos - Cidade
// - No fim, o total:  16 pessoas encontradas
// - Se ninguém passar no filtro:  Ninguém encontrado.
// - Se o "De" for maior que o "Até", mostre só:  A idade "De" tem que ser menor que a "Até".
// - Abrindo a página sem escolher nada: só o título e o formulário, sem mensagem.
// - Pode contar que a pessoa sempre preenche os dois campos.
//
// Como tem que ficar:
// - SP, de 30 até 40: 16 pessoas. A primeira é Juliana Santos (30) e a última,
//   Bianca Araújo Martins (40).
// - SP, de 31 até 39: 12 pessoas.
// - BA, de 20 até 30: 5 pessoas.
// - AP, de 18 até 30: Ninguém encontrado.
// - SP, de 50 até 20: a mensagem da idade.
//
// Desafio extra: depois de clicar em Ver, os números digitados continuam nos
// campos (do mesmo jeito que o estado escolhido continua na lista).

// A conexão já está pronta (é igual à dos outros exercícios).
ini_set("display_errors", 1);

$banco = new PDO("sqlite:" . __DIR__ . "/banco/estudos.sqlite");
$banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
