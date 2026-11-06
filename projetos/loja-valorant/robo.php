<?php

// Projeto: Loja do Valorant
// Lê a loja do dia, compara com o desejos.txt e avisa no celular pelo ntfy.
//
// Teste sem usar a conta (loja de mentira, sem enviar aviso):
//   php robo.php --teste
//
// De verdade (precisa destas variáveis de ambiente):
//   RIOT_SSID    cookie da sessão da Riot. É como uma chave da conta: nunca no código nem no git.
//   NTFY_TOPICO  tópico do ntfy que recebe o aviso.
//   RIOT_SHARD   servidor da conta (opcional). Brasil usa "na".

const LOJA_DE_TESTE = ["Reaver Vandal", "Ion Sheriff", "Prime Phantom", "Glitchpop Dagger"];

const ENDERECO_LOGIN = "https://auth.riotgames.com/authorize?redirect_uri=https%3A%2F%2Fplayvalorant.com%2Fopt_in"
    . "&client_id=play-valorant-web-prod&response_type=token%20id_token&nonce=1&scope=account%20openid";

const PLATAFORMA = '{"platformType":"PC","platformOS":"Windows","platformOSVersion":"10.0.19042.1.256.64bit","platformChipset":"Unknown"}';

// Faz a requisição e devolve o status, os cabeçalhos e o corpo da resposta.
function pedir($url, $opcoes = [])
{
    $curl = curl_init($url);
    curl_setopt_array($curl, $opcoes + [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_TIMEOUT => 30,
    ]);

    $resposta = curl_exec($curl);
    if ($resposta === false) {
        throw new Exception("Falha na conexão com " . parse_url($url, PHP_URL_HOST) . ": " . curl_error($curl));
    }

    $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    $tamanhoCabecalho = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    curl_close($curl);

    return [
        "status" => $status,
        "cabecalhos" => substr($resposta, 0, $tamanhoCabecalho),
        "corpo" => substr($resposta, $tamanhoCabecalho),
    ];
}

function pedirJson($url, $opcoes = [])
{
    $resposta = pedir($url, $opcoes);
    if ($resposta["status"] != 200) {
        throw new Exception("Resposta " . $resposta["status"] . " de " . parse_url($url, PHP_URL_HOST));
    }
    return json_decode($resposta["corpo"], true);
}

// Monta a lista "id da skin => nome da skin". Essa API é pública e não usa a conta.
function buscarNomes()
{
    $nomes = [];
    foreach (pedirJson("https://valorant-api.com/v1/weapons/skinlevels")["data"] as $skin) {
        $nomes[$skin["uuid"]] = $skin["displayName"];
    }
    return $nomes;
}

// Usa o cookie da sessão para pegar os tokens e ler a loja. Devolve os ids das 4 skins.
function lerLojaDaConta($ssid, $shard)
{
    $login = pedir(ENDERECO_LOGIN, [CURLOPT_HTTPHEADER => ["Cookie: ssid=" . $ssid, "User-Agent: Mozilla/5.0"]]);
    if (!preg_match('/access_token=([^&\s]+)/', $login["cabecalhos"], $achou)) {
        throw new Exception("Sessão da Riot expirada ou recusada. Faça login de novo.");
    }
    $token = $achou[1];
    $autorizacao = "Authorization: Bearer " . $token;

    $direitos = pedirJson("https://entitlements.auth.riotgames.com/api/token/v1", [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => "{}",
        CURLOPT_HTTPHEADER => [$autorizacao, "Content-Type: application/json"],
    ]);
    $usuario = pedirJson("https://auth.riotgames.com/userinfo", [CURLOPT_HTTPHEADER => [$autorizacao]]);
    $versao = pedirJson("https://valorant-api.com/v1/version")["data"]["riotClientVersion"];

    $cabecalhos = [
        $autorizacao,
        "X-Riot-Entitlements-JWT: " . $direitos["entitlements_token"],
        "X-Riot-ClientVersion: " . $versao,
        "X-Riot-ClientPlatform: " . base64_encode(PLATAFORMA),
        "Content-Type: application/json",
    ];
    $base = "https://pd." . $shard . ".a.pvp.net/store";

    // A documentação da comunidade mostra a v2, mas a Riot pode ter mudado. Tenta a v3 primeiro.
    $loja = pedir($base . "/v3/storefront/" . $usuario["sub"], [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => "{}",
        CURLOPT_HTTPHEADER => $cabecalhos,
    ]);
    if ($loja["status"] != 200) {
        $loja = pedir($base . "/v2/storefront/" . $usuario["sub"], [CURLOPT_HTTPHEADER => $cabecalhos]);
    }
    if ($loja["status"] != 200) {
        throw new Exception("A loja respondeu " . $loja["status"]);
    }

    return json_decode($loja["corpo"], true)["SkinsPanelLayout"]["SingleItemOffers"];
}

function avisar($topico, $titulo, $mensagem)
{
    pedir("https://ntfy.sh/" . $topico, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $mensagem,
        CURLOPT_HTTPHEADER => ["Title: " . $titulo],
    ]);
}

$teste = in_array("--teste", $argv);
$topico = getenv("NTFY_TOPICO");

try {
    $nomes = buscarNomes();
    $nomesEmMinusculo = array_map("mb_strtolower", $nomes);

    $desejos = file(__DIR__ . "/desejos.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $desejosEmMinusculo = array_map("mb_strtolower", array_map("trim", $desejos));

    // Nome escrito errado nunca daria aviso, então é melhor falar logo.
    foreach ($desejos as $desejo) {
        if (!in_array(mb_strtolower(trim($desejo)), $nomesEmMinusculo)) {
            echo "Atenção: \"" . $desejo . "\" não existe na lista de skins do jogo.\n";
        }
    }

    if ($teste) {
        echo "(teste: loja de mentira)\n";
        $loja = LOJA_DE_TESTE;
    } else {
        $ssid = getenv("RIOT_SSID");
        if (!$ssid) {
            throw new Exception("Falta a variável de ambiente RIOT_SSID.");
        }
        $shard = getenv("RIOT_SHARD") ?: "na";
        $loja = [];
        foreach (lerLojaDaConta($ssid, $shard) as $id) {
            $loja[] = $nomes[$id] ?? "Skin desconhecida (" . $id . ")";
        }
    }

    $achadas = [];
    foreach ($loja as $skin) {
        if (in_array(mb_strtolower($skin), $desejosEmMinusculo)) {
            $achadas[] = $skin;
            echo $skin . " - QUERO!\n";
        } else {
            echo $skin . "\n";
        }
    }
    echo "Skins da lista hoje: " . count($achadas) . "\n";

    if (count($achadas) > 0) {
        if ($teste) {
            echo "(teste: aviso não enviado)\n";
        } elseif ($topico) {
            avisar($topico, "Skin na sua loja!", implode(", ", $achadas));
        }
    }
} catch (Exception $erro) {
    echo "Erro: " . $erro->getMessage() . "\n";
    // Sem esse aviso, o robô poderia parar de funcionar sem você saber.
    if (!$teste && $topico) {
        avisar($topico, "Robo da loja com problema", $erro->getMessage());
    }
    exit(1);
}
