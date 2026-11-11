<?php

// Devolve a lista de níveis e lições para a tela montar a trilha.
// Só vai o que aparece na tela: o plano de aula fica no servidor.

require __DIR__ . "/../../src/curso.php";

header("Content-Type: application/json; charset=utf-8");
header("Cache-Control: no-store");

$niveis = [];
foreach (NIVEIS as $numero => $nivel) {
    $niveis[$numero] = ["numero" => $numero, "nome" => $nivel["nome"], "licoes" => []];
}

foreach (LICOES as $licao) {
    $niveis[$licao["nivel"]]["licoes"][] = [
        "id" => $licao["id"],
        "titulo" => $licao["titulo"],
        "resumo" => $licao["resumo"],
    ];
}

echo json_encode(["niveis" => array_values($niveis)], JSON_UNESCAPED_UNICODE);
