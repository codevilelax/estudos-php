<?php

// Exercício 3: O censo de Curitiba
// Sem etapas: tente fazer tudo sozinho.
//
// Busque no banco todas as pessoas que moram em Curitiba, em ordem de nome.
// Mostre o nome e a idade de cada uma.
// No fim, mostre:
// - quantas pessoas moram em Curitiba;
// - quantas delas têm 60 anos ou mais;
// - quem é a pessoa mais velha (nome e idade).
//
// Regra: no SQL, só filtre a cidade e ordene por nome. As contas e a pessoa
// mais velha têm que sair do PHP (nada de COUNT, MAX ou "idade >=" no SQL).
//
// Parte 2: depois que funcionar, escreva no fim do arquivo, em comentário,
// a tradução pro português de duas linhas suas: o foreach e o if que acha
// a pessoa mais velha.
//
// Saída esperada:
// Camila Lopes Barros - 63 anos
// Débora Vieira Silva - 65 anos
// Eduarda Rocha Santana - 67 anos
// Eduardo Dias Pires - 83 anos
// Guilherme Fernandes Gonçalves - 41 anos
// Igor Castro Vieira - 39 anos
// Mariana Pereira Melo - 30 anos
// Tatiane Marques Barbosa - 44 anos
// Thiago Lopes Azevedo - 19 anos
// Vanessa Mendes Alves - 41 anos
// Pessoas em Curitiba: 10
// Com 60 anos ou mais: 4
// Mais velha: Eduardo Dias Pires, com 83 anos

$banco = new PDO("sqlite:" . __DIR__ . "/banco/estudos.sqlite");
$banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pessoas = $banco->query("SELECT * FROM pessoas WHERE cidade = 'Curitiba' ORDER BY nome");

$qnt = 0;
$velho = 0;
$maiorIdade = 0;
$nomeMaisVelho = "";

foreach ($pessoas as $pessoa){
    $qnt += 1;
    echo $pessoa["nome"] . " - " . $pessoa["idade"] . " anos\n";
 if ($pessoa["idade"] >= 60){
        $velho += 1;
    }
    if ($pessoa["idade"] > $maiorIdade){
        $maiorIdade = $pessoa["idade"];
        $nomeMaisVelho = $pessoa["nome"];
    }
} 
echo "Pessoas em Curitiba: " . $qnt . "\n"
. "Com 60 anos ou mais: " . $velho . "\n"
. "Mais velha: " . $nomeMaisVelho . ", com " . $maiorIdade . " anos";

// $qnt; $velho; É como se fosse um cofre vazio, e cada vez que eu passo por ele, eu somo 1 nele.
// $maiorIdade; $nomeMaisVelho; Guardam o campeão, e cada vez que aparece alguém mais velho, eu troco o que estava guardado.
// No foreach, para cada pessoa da lista $pessoas, eu coloco ela na $pessoa, uma de cada vez, e faço tudo que está dentro das chaves
// if-1 conto cada pessoa que tem 60 anos ou mais, guardando 1 no "cofre" $velho
// if-2 se a idade da pessoa for maior que a $maiorIdade, ela vira a mais velha e eu guardo a idade e o nome dela. Uso para saber o nome, e idade do mais velho