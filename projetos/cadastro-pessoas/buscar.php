<?php

// Projeto: Cadastro de pessoas
// Parte 1: Buscar pessoas de um estado
//
// O programa pergunta o estado, busca no banco as pessoas daquele estado, em
// ordem de nome, e mostra o nome, a idade e a cidade de cada uma.
// No fim, mostra quantas pessoas foram encontradas.
// Se não achar ninguém, mostra só: Nenhuma pessoa encontrada em XX.
// (no lugar do XX, o estado que a pessoa digitou)
//
// Regras:
// - O estado vem do readline, nada de 'MS' escrito na mão no SQL.
// - Use o jeito seguro: prepare com ? e execute.
//
// Exemplo 1 (digitando MS):
// Digite o estado: MS
// Bianca Rodrigues - 23 anos - Campo Grande
// Felipe Pires Araújo - 55 anos - Dourados
// Gabriel Campos Ferreira - 44 anos - Campo Grande
// Luana Campos - 72 anos - Campo Grande
// Lúcia Azevedo Vieira - 35 anos - Dourados
// Encontradas: 5 pessoas
//
// Exemplo 2 (digitando XX):
// Digite o estado: XX
// Nenhuma pessoa encontrada em XX

$banco = new PDO("sqlite:" . __DIR__ . "/../../03-banco-de-dados/banco/estudos.sqlite");
$banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$uf = readline("Digite o estado: ");

$consulta = $banco->prepare("SELECT * FROM pessoas WHERE uf = ? ORDER BY nome");
$consulta->execute([$uf]);

$encontradas = 0;

foreach ($consulta as $pessoa) {
    $encontradas += 1;
    echo $pessoa["nome"] . " - " . $pessoa["idade"] . " anos - " . $pessoa["cidade"] . "\n";
}

// Próxima sessão: trocar este echo por um if / else
// (se $encontradas == 0, mostra "Nenhuma pessoa encontrada em XX").
echo "Encontradas: " . $encontradas . " pessoas";
