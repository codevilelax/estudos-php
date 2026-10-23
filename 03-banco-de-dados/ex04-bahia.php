<?php

// Exercício 4: Caça aos erros na Bahia
//
// Este código devia mostrar a pessoa mais nova e a mais velha da Bahia, e a
// diferença de idade entre as duas. Mas ele tem 6 erros.
//
// Rode, leia o que aparece (mensagem de erro ou resultado errado), conserte
// um erro e rode de novo. Alguns erros só aparecem depois que você conserta
// o anterior.
//
// Regra: não reescreva o código do zero. Só conserte o que está errado.
//
// Parte 2: depois que funcionar, escreva em comentário, no fim do arquivo,
// a lista dos 6 erros: onde estava cada um e por que estava errado.
//
// Saída esperada:
// Mais nova: Bianca Lopes, com 16 anos
// Mais velha: Helena Rocha Cardoso, com 85 anos
// Diferença de idade: 69 anos

$banco = new PDO("sqlite:" . __DIR__ . "/banco/estudos.sqlite");
$banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pessoas = $banco->query("SELECT * FROM pessoas WHERE uf = 'BA'");

$maiorIdade = 0;
$nomeMaisVelha = "";
$menorIdade = 999;
$nomeMaisNova = "";

foreach ($pessoas as $pessoa){
    if ($pessoa["idade"] > $maiorIdade) {
        $maiorIdade = $pessoa["idade"];
        $nomeMaisVelha = $pessoa["nome"];
    }
    if ($pessoa["idade"] < $menorIdade) {
        $menorIdade = $pessoa["idade"];
        $nomeMaisNova = $pessoa["nome"];
    }
}

$diferenca = $maiorIdade - $menorIdade;

echo "Mais nova: " . $nomeMaisNova . ", com " . $menorIdade . " anos\n";
echo "Mais velha: " . $nomeMaisVelha . ", com " . $maiorIdade . " anos\n";
echo "Diferença de idade: " . $diferenca . " anos\n";

//na linha 25, no meu banco os UF são listados com letras maiúsculas, 'ba' -> 'BA'
//na linha 29 $menorIdade começava com 0, e ninguém tem menos que 0 anos, então ninguém ganhava do campeão. Com 999 a primeira pessoa sempre ganha
//linha 30 faltava um ";"
//linha 39 variavel $pessoa estava $pessoas
//linha 43 a operação estava invertida, dava -69. Tem que ser o maior menos o menor
//o echo que esta agora na linha 45, estava dentro do foreach, por isso repetia uma vez pra cada pessoa