<?php

// Exercício 2: Lista de compras
// Crie um array $compras com 4 ou mais itens e mostre, cada um em uma linha:
// 1. A quantidade de itens da lista
// 2. O primeiro item
// 3. O último item
// 4. "Lista grande" se tiver mais de 5 itens, senão "Lista pequena"
// O programa deve continuar funcionando se você adicionar ou remover itens.

$compras = ["Mouse", "Teclado", "Notebook", "Monitor"];
$quantidade = count($compras);

echo $compras[0] .".\n"
. $compras[$quantidade - 1] .".\n"
. "A quantidade de itens na lista é " . $quantidade . ".\n";

if ($quantidade > 5) {
    echo "Lista grande.";
} else {
    echo "Lista pequena.";
}