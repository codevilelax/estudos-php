<?php

// Exercício 8: Playlist
// Crie um array $musicas com 5 nomes de músicas.
// Mostre, cada um em uma linha:
// 1. Quantas músicas a playlist tem. Ex: "A playlist tem 5 músicas"
// 2. A primeira música. Ex: "Primeira música: Nome da música"
// 3. A última música. Ex: "Última música: Nome da música"
// 4. Se a playlist tiver 10 músicas ou mais: "Playlist completa!"
//    Senão: "Faltam X músicas para completar 10." (X = quantas faltam)
//
// O programa deve continuar funcionando se você adicionar ou remover músicas.

$musicas = $musicas = ["Cerol", "Mlks de sp", "tropa da lacoste", "diario de um cafajeste", "vergonha pra midia", "Malvadão 3", "Tubarão te amo", "Bipolar", "Vai embrazando", "Plantão"];
$quantidade = count($musicas);

echo "A playlist tem " . $quantidade . " músicas.\n"
. "A primeira música é " . $musicas[0] . ".\n"
. "A última música é " . $musicas[$quantidade - 1] . ".\n";

if ($quantidade >= 10) {
    echo "Playlist completa!";
} else {
    echo "Faltam " . (10 - $quantidade) . " músicas para completar 10.";
}