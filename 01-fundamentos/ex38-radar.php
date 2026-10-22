<?php

// Exercício 38: Radar da avenida (foreach com if / else)
// Sem etapas: tente fazer tudo sozinho.
//
// Um radar marcou a velocidade de alguns carros numa avenida de 60 km/h.
// Crie a variável $limite (60) e o array $velocidades com estes valores:
// 45, 72, 60, 58, 90.
// Use um loop foreach para passar por cada velocidade e um if / else para mostrar:
//    - se o carro passou do limite: "multado"
//    - se não: "dentro do limite"
// Quando o loop terminar, mostre "Fim do radar.".
//
// Atenção: quem passou exatamente a 60 km/h não é multado.
//
// Saída esperada:
// 45 km/h - dentro do limite
// 72 km/h - multado
// 60 km/h - dentro do limite
// 58 km/h - dentro do limite
// 90 km/h - multado
// Fim do radar.

$limite = 60;
$velocidades = [45, 72, 60, 58, 90];

foreach ($velocidades as $velocidade) {
    echo $velocidade . " km/h - ";
    if ($velocidade <= $limite) {
        echo "dentro do limite\n";
    }
    else {
        echo "multado\n";
    }
}
echo "Fim do radar.";