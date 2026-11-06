<?php
// GitHub de mentira para testar o salvamento da lista e dos ajustes.
$caminho = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
if (strpos($caminho, "/github/") !== 0) {
    return false;
}
$nome = substr($caminho, 8);

$arq = __DIR__ . "/estado.json";
$estado = is_file($arq) ? json_decode(file_get_contents($arq), true) : [
    "arquivos" => [
        "desejos.txt" => ["texto" => "Reaver Vandal\nSkin Ação\n", "versao" => 1],
        "dados/loja.json" => ["texto" => json_encode([
            "riot_id" => "RealNome#123",
            "vp" => 1000,
            "hoje" => ["data" => "2026-11-06", "expira" => gmdate("c", time() + 7200), "skins" => [
                ["id" => "ba42fe63-457a-78ce-4499-47950a698129", "nome" => "Reaver Vandal", "preco" => 1775],
                ["id" => "2b555f97-46bb-5949-3531-979f5bc817f0", "nome" => "Ion Sheriff", "preco" => 1275],
                ["id" => "48ce4a70-4207-623b-4739-bfb937812432", "nome" => "Glitchpop Dagger", "preco" => 3550],
                ["id" => "82db01d1-4192-167b-9f53-78ba374c39ac", "nome" => "Spectrum Phantom", "preco" => 2675],
            ]],
            "ontem" => ["data" => "2026-11-05", "expira" => null, "skins" => [
                ["id" => "c9678d8c-4327-f397-b0ec-dca3c3d6fb15", "nome" => "Prime Vandal", "preco" => 1775],
                ["id" => "c00e786e-4e6f-0ef7-0ce3-32ba9918ba41", "nome" => "Oni Phantom", "preco" => 1775],
                ["id" => "851b390a-4852-66bd-8b72-4f96f0919710", "nome" => "Forsaken Vandal", "preco" => 1775],
                ["id" => "b3d3ff38-4202-20d8-2f41-c783477e5636", "nome" => "Elderflame Vandal", "preco" => 2475],
            ]],
        ]), "versao" => 1],
    ],
    "falhar" => null,
];
$salvar = function () use (&$estado, $arq) { file_put_contents($arq, json_encode($estado)); };

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if (isset($_GET["falhar"])) {
    $estado["falhar"] = $_GET["falhar"];
    if ($estado["falhar"] === "409") {
        if ($nome === "desejos.txt") {
            $estado["arquivos"][$nome]["texto"] .= "Vinda De Outro Lugar\n";
        } else {
            $config = json_decode($estado["arquivos"][$nome]["texto"], true);
            $config["campo_de_fora"] = true;
            $estado["arquivos"][$nome]["texto"] = json_encode($config);
        }
        $estado["arquivos"][$nome]["versao"]++;
    }
    $salvar();
    echo "{}";
    return true;
}
if (isset($_GET["ver"])) {
    echo json_encode($estado["arquivos"][$nome] ?? null);
    return true;
}

if (($_SERVER["HTTP_AUTHORIZATION"] ?? "") !== "Bearer token-teste") {
    http_response_code(401);
    echo "{}";
    return true;
}

$atual = $estado["arquivos"][$nome] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!$atual) {
        http_response_code(404);
        echo "{}";
        return true;
    }
    echo json_encode(["content" => chunk_split(base64_encode($atual["texto"]), 20, "\n"), "sha" => "v" . $atual["versao"]]);
    return true;
}

$corpo = json_decode(file_get_contents("php://input"), true);
if ($estado["falhar"] === "500") {
    $estado["falhar"] = null;
    $salvar();
    http_response_code(500);
    echo "{}";
    return true;
}
$esperado = $atual ? "v" . $atual["versao"] : null;
if (($corpo["sha"] ?? null) !== $esperado) {
    http_response_code($atual && empty($corpo["sha"]) ? 422 : 409);
    echo "{}";
    return true;
}
$estado["falhar"] = null;
$versao = ($atual["versao"] ?? 0) + 1;
$estado["arquivos"][$nome] = ["texto" => base64_decode($corpo["content"]), "versao" => $versao];
$salvar();
echo json_encode(["content" => ["sha" => "v" . $versao]]);
return true;
