#!/usr/bin/env bash
# Teste automático da tela, no Chrome escondido. Roda no Git Bash:
#
#   bash testes/rodar.sh mentira   cenários com respostas de mentira (não gasta a IA, 30 segundos)
#   bash testes/rodar.sh real      lição 1 inteira, conversa livre e microfone, com a IA de verdade
#                                  (uns 3 minutos e 20 pedidos da cota gratuita)
#   bash testes/rodar.sh fotos     fotos das telas, em tamanho de computador e de celular
#
# Como funciona: sobe um servidor na porta 8124 com o router.php, que coloca na página o
# antes.js (prepara o teste) e o roteiro.js (clica, digita, grava e confere). O resultado
# de cada cenário vai para um arquivo resultado-NOME.json na pasta de saída.
#
# Coisas que valem lembrar:
# - A voz é trocada por uma de mentira (antes.js), para o computador não falar alto.
#   Voz e microfone de verdade só dá para testar à mão.
# - O microfone do teste é um arquivo de áudio que o Chrome toca (vozes.ps1 cria).
# - As fotos usam tempo acelerado e podem pegar uma animação no meio (a barra de
#   progresso às vezes sai vazia). Vale a medida do cenário "completo", não a foto.

T="$(cd "$(dirname "$0")" && pwd)"
PUBLICO="$(cd "$T/../public" && pwd)"
SAIDA="${TMP:-/tmp}/treino-ingles-teste"
mkdir -p "$SAIDA"
SAIDA="$(cd "$SAIDA" && pwd)"
SW="$(cygpath -w "$SAIDA")"
export TESTE_SAIDA="$(cygpath -m "$SAIDA")"

CHROME="/c/Program Files/Google/Chrome/Application/chrome.exe"
[ -f "$CHROME" ] || CHROME="/c/Program Files (x86)/Google/Chrome/Application/chrome.exe"
PORTA=8124
COMUNS=(--headless=new --no-first-run --no-default-browser-check --disable-extensions --mute-audio)
MICROFONE=(--use-fake-ui-for-media-stream --use-fake-device-for-media-stream)

matar() {
    if [ -n "$1" ] && [ -e "/proc/$1/winpid" ]; then
        taskkill //F //T //PID "$(cat "/proc/$1/winpid")" >/dev/null 2>&1
    fi
}

php -d upload_max_filesize=10M -d post_max_size=12M -S localhost:$PORTA -t "$PUBLICO" "$T/router.php" >"$SAIDA/servidor.log" 2>&1 &
SERVIDOR=$!
trap 'matar $SERVIDOR' EXIT
sleep 1

# cenario <nome do resultado> <limite em segundos> <query> [flags do chrome...]
cenario() {
    local nome="$1" limite="$2" query="$3"
    shift 3
    rm -f "$SAIDA/resultado-$nome.json"
    "$CHROME" "${COMUNS[@]}" --user-data-dir="$SW\\perfil-$nome" --window-size=1280,800 "$@" "http://localhost:$PORTA/?$query" >/dev/null 2>&1 &
    local navegador=$!
    local i=0
    while [ ! -s "$SAIDA/resultado-$nome.json" ] && [ $i -lt $((limite * 2)) ]; do
        sleep 0.5
        i=$((i + 1))
    done
    sleep 0.3
    matar $navegador

    if [ -s "$SAIDA/resultado-$nome.json" ]; then
        php -r '
            $r = json_decode(file_get_contents($argv[1]), true);
            echo str_pad($argv[2], 14), $r["passou"] ? "PASSOU" : "FALHOU", "  ", $r["total"], " conferências", isset($r["caminho"]) ? "  caminho: " . $r["caminho"] : "", "\n";
            foreach ($r["falhas"] as $f) {
                echo "   X ", $f["descricao"], " => ", mb_substr(json_encode($f["detalhe"] ?? null, JSON_UNESCAPED_UNICODE), 0, 500), "\n";
            }
            foreach ($r["errosJs"] as $e) {
                echo "   erro de JavaScript: ", $e, "\n";
            }
        ' "$SAIDA/resultado-$nome.json" "$nome"
    else
        echo "$nome: SEM RESULTADO depois de ${limite}s"
    fi
}

# foto <arquivo> <query> [largura] [altura]
foto() {
    local largura="${3:-1280}" altura="${4:-800}"
    rm -f "$SAIDA/$1.png"
    "$CHROME" "${COMUNS[@]}" --user-data-dir="$SW\\perfil-foto" --hide-scrollbars --window-size="$largura,$altura" \
        --virtual-time-budget=8000 --screenshot="$SW\\$1.png" "http://localhost:$PORTA/?teste=foto&$2" >/dev/null 2>&1
    if [ -s "$SAIDA/$1.png" ]; then echo "foto $1: ok"; else echo "foto $1: FALHOU"; fi
}

# celular <arquivo> <query> [largura] [altura]: a mesma foto, dentro de uma moldura estreita
celular() {
    local largura="${3:-390}" altura="${4:-844}"
    rm -f "$SAIDA/$1.png"
    "$CHROME" "${COMUNS[@]}" --user-data-dir="$SW\\perfil-foto" --hide-scrollbars --window-size="$((largura + 110)),$altura" \
        --virtual-time-budget=8000 --screenshot="$SW\\$1.png" "http://localhost:$PORTA/__teste/moldura?teste=foto&largura=$largura&altura=$altura&$2" >/dev/null 2>&1
    if [ -s "$SAIDA/$1.png" ]; then echo "foto $1: ok"; else echo "foto $1: FALHOU"; fi
}

case "$1" in
mentira)
    cenario trilha 30 "teste=trilha"
    cenario sem-servidor 30 "teste=sem-servidor&falso=sem-servidor"
    cenario estragado 30 "teste=estragado&semente=estragado"
    cenario metade 30 "teste=metade&semente=metade"
    cenario tudo 30 "teste=tudo&semente=tudo"
    cenario pular 40 "teste=pular&falso=ok&demora=1500"
    cenario erro 40 "teste=erro&falso=erro-abertura"
    cenario completo 60 "teste=completo&falso=ok"
    cenario andamento 40 "teste=andamento&semente=andamento&falso=ok"
    cenario fim 40 "teste=fim&semente=fim&falso=ok&demora=800"
    ;;
real)
    if [ ! -s "$SAIDA/ingles.wav" ] || [ ! -s "$SAIDA/portugues.wav" ]; then
        powershell -NoProfile -ExecutionPolicy Bypass -File "$(cygpath -w "$T/vozes.ps1")" -Pasta "$SW"
    fi
    cenario real-licao 420 "teste=real-licao&pausa=8000"
    cenario real-livre 90 "teste=real-livre"
    cenario real-mic 120 "teste=real-mic&esperado=beach&segundos=5" "${MICROFONE[@]}" "--use-file-for-fake-audio-capture=$SW\\ingles.wav%noloop"
    cenario real-mic-pt 150 "teste=real-mic&licao=1&esperado=boa%20tarde&segundos=5&sufixo=-pt" "${MICROFONE[@]}" "--use-file-for-fake-audio-capture=$SW\\portugues.wav%noloop"
    ;;
fotos)
    foto 1-trilha "x=1"
    foto 2-trilha-metade "semente=metade"
    foto 3-aula "falso=ok&acao=abrir,conversar,ouvir&falaLonga=1"
    foto 4-aula-fim "falso=ok&acao=abrir,conversar,terminar"
    foto 5-gravando "semente=andamento&acao=abrir,gravando"
    foto 6-teclado-erro "semente=andamento&acao=abrir,teclado,erro"
    foto 7-livre "semente=tudo&acao=abrir"
    celular c1-trilha "x=1"
    celular c2-aula "falso=ok&acao=abrir,conversar,ouvir&falaLonga=1"
    celular c3-aula-guardada "semente=andamento&acao=abrir,teclado"
    celular c4-fim "falso=ok&acao=abrir,conversar,terminar"
    celular c5-estreito "semente=andamento&acao=abrir" 320 640
    celular c6-tablet "semente=andamento&acao=abrir" 700 800
    ;;
*)
    echo "uso: bash testes/rodar.sh mentira | real | fotos"
    ;;
esac

echo "Resultados e fotos em: $SW"

# Garantia: nenhum Chrome de teste fica aberto (só os que usam os perfis da pasta de saída).
powershell -NoProfile -Command "Get-CimInstance Win32_Process -Filter \"name='chrome.exe'\" | Where-Object { \$_.CommandLine -like '*treino-ingles-teste\\perfil-*' } | ForEach-Object { Stop-Process -Id \$_.ProcessId -Force -ErrorAction SilentlyContinue }" >/dev/null 2>&1
