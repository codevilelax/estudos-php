<?php

// Exercício 2: Os mais velhos de Minas
// Sem etapas: tente fazer tudo sozinho.
//
// Busque no banco as 10 pessoas mais velhas que moram em MG, da mais velha
// para a mais nova (quem tiver a mesma idade fica em ordem de nome).
// Mostre o nome, a idade e a cidade de cada uma.
// No fim, mostre a média de idade dessas 10 pessoas.
//
// Regra: a média tem que ser calculada no PHP, dentro e depois do foreach
// (nada de AVG ou COUNT no SQL).
//
// Saída esperada:
// Patrícia Moura - 84 anos - Contagem
// Wesley Farias Araújo - 84 anos - Uberlândia
// Guilherme Freitas Machado - 83 anos - Belo Horizonte
// Yasmin Carvalho Mendes - 83 anos - Contagem
// Bianca Ramos - 82 anos - Belo Horizonte
// Lúcia Andrade Soares - 82 anos - Uberlândia
// Bianca Rocha Ribeiro - 81 anos - Belo Horizonte
// Guilherme Azevedo Rocha - 81 anos - Juiz de Fora
// Ana Ribeiro - 76 anos - Uberlândia
// Débora Azevedo Freitas - 74 anos - Belo Horizonte
// Média de idade: 81 anos


$banco = new PDO("sqlite:" . __DIR__ . "/banco/estudos.sqlite");
$banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pessoas = $banco->query("SELECT * FROM pessoas WHERE uf = 'MG' ORDER BY idade DESC, nome LIMIT 10");

$sIdade = 0;
$qnt = 0;

foreach ($pessoas as $pessoa) {
    $sIdade += $pessoa["idade"];
    $qnt += 1;
    echo $pessoa["nome"] ." - ". $pessoa["idade"] . " anos" ." - ". $pessoa["cidade"] . "\n";
}
echo "Média de idade: " . $sIdade / $qnt . " anos";