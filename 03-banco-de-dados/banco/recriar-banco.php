<?php

// Recria o banco estudos.sqlite do zero, com as 500 pessoas originais
// (que ficam no arquivo dados-iniciais.sql).
//
// ATENÇÃO: isso apaga TODAS as mudanças que você fez no banco.
// Use só se quiser começar de novo (por exemplo, se apagou dados sem querer).
//
// Para rodar:
// php "C:\Users\pedro.vilela\Desktop\estudos\php\03-banco-de-dados\banco\recriar-banco.php"

$arquivoBanco = __DIR__ . "/estudos.sqlite";
$arquivoDados = __DIR__ . "/dados-iniciais.sql";

if (file_exists($arquivoBanco)) {
    echo "Isso vai apagar todas as mudanças feitas no banco.\n";
    echo "Digite SIM para continuar: ";
    $resposta = trim(fgets(STDIN));

    if ($resposta !== "SIM") {
        echo "Cancelado. O banco não foi mexido.\n";
        exit;
    }

    unlink($arquivoBanco);
}

$banco = new PDO("sqlite:" . $arquivoBanco);
$banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$banco->exec(file_get_contents($arquivoDados));

$total = $banco->query("SELECT COUNT(*) FROM pessoas")->fetchColumn();
echo "Banco recriado com " . $total . " pessoas.\n";
