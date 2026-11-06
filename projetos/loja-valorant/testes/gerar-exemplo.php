<?php
function api($c) { return json_decode(file_get_contents("https://valorant-api.com/v1/" . $c), true)["data"]; }
$skins = api("weapons/skins");
$porNome = [];
foreach ($skins as $s) { $porNome[$s["displayName"]] = $s; }
$skin = function ($nome, $preco = null) use ($porNome) {
    if (!isset($porNome[$nome])) { fwrite(STDERR, "SEM SKIN: $nome\n"); return null; }
    $s = $porNome[$nome];
    $x = ["id" => $s["levels"][0]["uuid"], "nome" => $nome];
    if ($preco !== null) { $x["preco"] = $preco; }
    return $x;
};
$hoje = [$skin("Reaver Vandal", 1775), $skin("Ion Sheriff", 1275), $skin("Glitchpop Dagger", 3550), $skin("Spectrum Phantom", 2675)];
$ontem = [$skin("Prime Vandal", 1775), $skin("Oni Phantom", 1775), $skin("Forsaken Vandal", 1775), $skin("Elderflame Vandal", 2475)];

$pegar = function ($lista, $n, $mapa) { $r = []; foreach (array_slice(array_values($lista), 40, $n) as $i) { $x = $mapa($i); if ($x["icone"] ?? true) { $r[] = $x; } } return $r; };
$buddies = $pegar(api("buddies"), 6, function ($b) { return ["id" => $b["levels"][0]["uuid"] ?? $b["uuid"], "nome" => $b["displayName"], "icone" => $b["displayIcon"]]; });
$sprays = $pegar(array_filter(api("sprays"), function ($s) { return $s["fullTransparentIcon"] || $s["displayIcon"]; }), 6, function ($s) { return ["id" => $s["uuid"], "nome" => $s["displayName"], "icone" => $s["fullTransparentIcon"] ?: $s["displayIcon"]]; });
$cartoes = $pegar(api("playercards"), 6, function ($c) { return ["id" => $c["uuid"], "nome" => $c["displayName"], "icone" => $c["largeArt"] ?: $c["displayIcon"]]; });
$titulos = [];
foreach (array_slice(array_values(array_filter(api("playertitles"), function ($t) { return $t["titleText"]; })), 20, 6) as $t) { $titulos[] = ["id" => $t["uuid"], "nome" => $t["titleText"]]; }
$flex = $pegar(api("flex"), 3, function ($f) { return ["id" => $f["uuid"], "nome" => $f["displayName"], "icone" => $f["displayIcon"]]; });
$flex = array_slice(array_map(function ($f) { return ["id" => $f["uuid"], "nome" => $f["displayName"], "icone" => $f["displayIcon"]]; }, api("flex")), 0, 3);
$agentes = [];
foreach (array_slice(api("agents?isPlayableCharacter=true"), 0, 7) as $a) { $agentes[] = ["id" => $a["uuid"], "nome" => $a["displayName"], "icone" => $a["displayIcon"]]; }

$colecaoSkins = array_values(array_filter([$skin("Reaver Vandal"), $skin("Oni Phantom"), $skin("Prime Vandal"), $skin("Ion Sheriff"), $skin("Forsaken Vandal")]));

$armas = api("weapons");
$escolhidas = ["Vandal" => "Reaver Vandal", "Phantom" => "Oni Phantom", "Sheriff" => "Ion Sheriff"];
$loadout = [];
foreach ($armas as $a) {
    $n = $a["displayName"];
    if (!in_array($n, ["Vandal", "Phantom", "Operator", "Sheriff", "Classic", "Spectre"])) { continue; }
    $nomeSkin = $escolhidas[$n] ?? ("Standard " . $n);
    $s = $porNome[$nomeSkin] ?? null;
    $loadout[] = ["arma" => $n, "skin" => $s ? $nomeSkin : $n, "icone" => $s ? ($s["levels"][0]["displayIcon"] ?: $s["displayIcon"]) : $a["displayIcon"]];
}

$pacotes = [];
foreach (["Reaver", "Prime", "Oni", "Glitchpop", "Ion"] as $alvo) {
    foreach (api("bundles") as $b) {
        if (stripos($b["displayName"], $alvo) === 0 && $b["displayIcon"]) { $pacotes[] = ["id" => $b["uuid"], "nome" => $b["displayName"], "icone" => $b["displayIcon"], "preco" => 7100, "itens" => 7, "expira" => null]; break; }
    }
    if (count($pacotes) == 2) { break; }
}

$acessorios = ["expira" => null, "itens" => [
    ["tipo" => "Buddy", "nome" => $buddies[0]["nome"], "icone" => $buddies[0]["icone"], "preco" => 10],
    ["tipo" => "Spray", "nome" => $sprays[0]["nome"], "icone" => $sprays[0]["icone"], "preco" => 5],
    ["tipo" => "Cartão", "nome" => $cartoes[0]["nome"], "icone" => $cartoes[0]["icone"], "preco" => 5],
    ["tipo" => "Título", "nome" => $titulos[0]["nome"], "icone" => null, "preco" => 2],
]];

$d = [
    "riot_id" => "SeuNome#BR1",
    "vp" => 2350, "kc" => 45, "radianita" => 20,
    "desejos" => ["Reaver Vandal", "Glitchpop Dagger", "Elderflame Vandal"],
    "hoje" => ["data" => "2026-11-06", "expira" => null, "skins" => $hoje],
    "ontem" => ["data" => "2026-11-05", "expira" => null, "skins" => $ontem],
    "acessorios" => $acessorios,
    "pacotes" => $pacotes,
    "colecao" => [
        "valor_vp" => 8275,
        "equipado" => ["cartao" => $cartoes[1]["nome"], "titulo" => $titulos[1]["nome"]],
        "loadout" => $loadout,
        "skins" => $colecaoSkins,
        "buddies" => $buddies, "sprays" => $sprays, "cartoes" => $cartoes, "titulos" => $titulos, "flex" => $flex, "agentes" => $agentes,
    ],
];
file_put_contents($argv[1], json_encode($d, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");
echo "pacotes: " . implode(", ", array_column($pacotes, "nome")) . "\n";
echo "loadout: " . implode(", ", array_column($loadout, "skin")) . "\n";
foreach (["buddies","sprays","cartoes","titulos","flex","agentes"] as $k) { echo "$k: " . count($d["colecao"][$k]) . " -> " . $d["colecao"][$k][0]["nome"] . "\n"; }
foreach (api("contenttiers") as $t) { echo $t["displayName"] . " | " . $t["highlightColor"] . " | " . $t["displayIcon"] . "\n"; }
