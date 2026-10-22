<?php

// Exercício 1: Faixas de idade (primeiro desafio com o banco)
// Sem etapas: junte o que você viu no exemplo com o que já sabe dos fundamentos.
//
// Conecte no banco e busque o nome e a idade das 20 primeiras pessoas.
// Para cada pessoa, mostre o nome, a idade e a faixa:
//    - até 29 anos: "jovem"
//    - de 30 a 59 anos: "adulto"
//    - 60 anos ou mais: "idoso"
// No fim, mostre quantas pessoas caíram em cada faixa.
//
// Saída esperada:
// Igor Ferreira - 42 anos - adulto
// Sérgio Fernandes Silva - 25 anos - jovem
// Carlos Santana Gonçalves - 54 anos - adulto
// Felipe Andrade - 73 anos - idoso
// Cláudia Gomes Souza - 54 anos - adulto
// Patrícia Campos Moreira - 46 anos - adulto
// Antônio Lima Freitas - 23 anos - jovem
// Wesley Farias Araújo - 84 anos - idoso
// Eduarda Barbosa Pinto - 33 anos - adulto
// Fernando Correia Fernandes - 68 anos - idoso
// Marcela Ferreira Lima - 77 anos - idoso
// Antônio Barbosa Moura - 85 anos - idoso
// Clara Lima Andrade - 67 anos - idoso
// Isabela Nunes Soares - 35 anos - adulto
// Gabriel Campos Ferreira - 44 anos - adulto
// Beatriz Pires - 25 anos - jovem
// Fábio Teixeira Gonçalves - 66 anos - idoso
// Priscila Martins Almeida - 62 anos - idoso
// Camila Ramos Nunes - 53 anos - adulto
// Otávio Dias Pinto - 17 anos - jovem
// Jovens: 4
// Adultos: 8
// Idosos: 8

$banco = new PDO("sqlite:" . __DIR__ . "/banco/estudos.sqlite");
$banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pessoas = $banco->query("SELECT * FROM pessoas LIMIT 20");

$jovens = 0;
$adultos = 0;
$idosos = 0;

foreach ($pessoas as $pessoa) {
    echo $pessoa["nome"] . " - " . $pessoa["idade"] . " anos - ";
    if ($pessoa["idade"] <= 29) {
        echo "jovem\n";
        $jovens += 1;
    }
    elseif ($pessoa["idade"] <= 59) {
        echo "adulto\n";
        $adultos += 1;
    }
    else {
        echo "idoso\n";
        $idosos += 1;
    }
}
echo "Jovens: " . $jovens . "\n" 
. "Adultos: ". $adultos . "\n"
. "Idosos: " . $idosos;