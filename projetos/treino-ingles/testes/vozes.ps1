# Cria os dois áudios que servem de "microfone de mentira" no teste (rodar.sh real).
# Usa as vozes que já vêm no Windows e grava direto em arquivo: não toca som nenhum.
param([string]$Pasta)

Add-Type -AssemblyName System.Speech

$formato = New-Object System.Speech.AudioFormat.SpeechAudioFormatInfo(
    48000,
    [System.Speech.AudioFormat.AudioBitsPerSample]::Sixteen,
    [System.Speech.AudioFormat.AudioChannel]::Stereo
)

function Gravar($idioma, $texto, $arquivo) {
    $voz = New-Object System.Speech.Synthesis.SpeechSynthesizer
    $instalada = $voz.GetInstalledVoices() | Where-Object { $_.VoiceInfo.Culture.Name -like "$idioma*" } | Select-Object -First 1
    if (-not $instalada) {
        Write-Output "Sem voz de $idioma instalada no Windows: $arquivo ficou sem criar."
        return
    }
    $voz.SelectVoice($instalada.VoiceInfo.Name)
    $voz.Rate = -1
    $voz.SetOutputToWaveFile((Join-Path $Pasta $arquivo), $formato)
    $voz.Speak($texto)
    $voz.Dispose()
}

Gravar "en" "Yesterday I goed to the beach with my friends." "ingles.wav"
# O "ê" é montado pelo código da letra, porque o PowerShell antigo lê este arquivo sem acentos.
Gravar "pt" ("Como eu falo boa tarde em ingl" + [char]0xEA + "s?") "portugues.wav"
