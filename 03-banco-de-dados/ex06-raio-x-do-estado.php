<?php

// Exercício 6: Caça ao bug no navegador - Raio-X do estado
//
// Esta página devia mostrar um resumo do estado escolhido: quantas pessoas
// tem, a média de idade e quem é a pessoa mais velha. Mas ela tem 5 erros.
//
// Abra a página no navegador, veja o que aparece (mensagem de erro ou número
// errado), conserte um erro, salve e atualize a página (F5).
// Alguns erros só aparecem depois que você conserta outro.
//
// Regra: não reescreva o código do zero. Só conserte o que está errado.
//
// Dica: se aparecerem várias mensagens, comece pela primeira. Ela diz a linha.
// Se um número sair errado sem mensagem nenhuma, procure as linhas que mexem
// na caixinha daquele número.
//
// Como tem que ficar:
// - Abrindo a página sem escolher nada: só o título e a lista de estados,
//   sem mensagem nenhuma.
// - Escolhendo SP e clicando em Ver:
//     Pessoas: 118
//     Média de idade: 51 anos
//     Mais velha: Ana Carvalho Souza, 84 anos
// - Escolhendo BA:
//     Pessoas: 27
//     Média de idade: 48 anos
//     Mais velha: Helena Rocha Cardoso, 85 anos

// Esta linha faz os erros aparecerem na página (sem ela, o PHP daqui esconde).
ini_set("display_errors", 1);

$banco = new PDO("sqlite:" . __DIR__ . "/banco/estudos.sqlite");
$banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Raio-X do estado</title>
    <style>
        body { font-family: sans-serif; background: #111; color: #eee; padding: 30px; }
        select, button { font-size: 18px; padding: 6px 12px; }
        .cartao { background: #1c1c1e; border-radius: 16px; padding: 10px 24px; margin-top: 24px; max-width: 420px; }
        .numero { font-size: 32px; font-weight: bold; color: #ff4655; }
    </style>
</head>
<body>

<h1>Raio-X do estado</h1>

<form>
    <select name="uf">
<?php
$estados = $banco->query("SELECT DISTINCT uf FROM pessoas ORDER BY uf");
foreach ($estados as $estado) {
    if (isset($_GET["uf"]) && $estado["uf"] == $_GET["uf"]) {
        echo "<option selected>" . $estado["uf"] . "</option>";
    } else {
        echo "<option>" . $estado["uf"] . "</option>";
    }
}
?>
    </select>
    <button>Ver</button>
</form>

<?php
if (isset($_GET["uf"])){
$uf = $_GET["uf"];


$consulta = $banco->prepare("SELECT * FROM pessoas WHERE uf = ?");
$consulta->execute([$uf]);

$total = 0;
$somaIdades = 0;
$maiorIdade = 0;
$maisVelha = "";

foreach ($consulta as $pessoa) {
    $total += 1;
    $somaIdades += $pessoa["idade"];

    if ($pessoa["idade"] > $maiorIdade) {
        $maiorIdade = $pessoa["idade"];
        $maisVelha = $pessoa["nome"];
    }
}

if ($total == 0) {
    echo "<p>Ninguém encontrado em " . $uf . "</p>";
} else {
    $media = $somaIdades / $total;

    echo "<div class='cartao'>";
    echo "<h2>" . $uf . "</h2>";
    echo "<p>Pessoas: <span class='numero'>" . $total . "</span></p>";
    // round arredonda o número: 50.7 vira 51
    echo "<p>Média de idade: <span class='numero'>" . round($media) . "</span> anos</p>";
    echo "<p>Mais velha: " . $maisVelha . ", " . $maiorIdade . " anos</p>";
    echo "</div>";
}}
?>

</body>
</html>
