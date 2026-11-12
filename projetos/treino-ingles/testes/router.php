<?php

// Roteador de teste (usado pelo rodar.sh). Serve a pasta public de verdade, mas coloca
// dois scripts de teste na página (um antes e um depois do app.js) e guarda em arquivo
// o resultado que o teste manda. Nada daqui é usado quando o app abre pelo iniciar.bat.

$caminho = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$saida = getenv("TESTE_SAIDA") ?: sys_get_temp_dir();

if ($caminho == "/" || $caminho == "/index.html") {
    $html = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/index.html");
    $html = str_replace(
        '<script src="app.js"></script>',
        '<script src="/__teste/antes.js"></script><script src="app.js"></script><script src="/__teste/roteiro.js"></script>',
        $html
    );
    header("Content-Type: text/html; charset=utf-8");
    header("Cache-Control: no-store");
    echo $html;
    return true;
}

if ($caminho == "/__teste/antes.js" || $caminho == "/__teste/roteiro.js") {
    header("Content-Type: text/javascript; charset=utf-8");
    header("Cache-Control: no-store");
    readfile(__DIR__ . "/" . basename($caminho));
    return true;
}

// Moldura do tamanho de um celular: no computador, a janela do Chrome não fica tão estreita.
if ($caminho == "/__teste/moldura") {
    $largura = (int) ($_GET["largura"] ?? 390);
    $altura = (int) ($_GET["altura"] ?? 844);
    header("Content-Type: text/html; charset=utf-8");
    echo '<!DOCTYPE html><meta charset="utf-8"><body style="margin:0;background:#555">'
        . '<iframe src="/?' . htmlspecialchars($_SERVER["QUERY_STRING"]) . '" style="display:block;border:0;width:' . $largura . 'px;height:' . $altura . 'px"></iframe>';
    return true;
}

if ($caminho == "/__teste/resultado") {
    $nome = preg_replace('/[^a-z0-9-]/', "", $_GET["nome"] ?? "sem-nome");
    file_put_contents($saida . "/resultado-" . $nome . ".json", file_get_contents("php://input"));
    echo "ok";
    return true;
}

return false;
