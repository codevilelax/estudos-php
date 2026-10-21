<?php

// Exercício 33: Ingressos do cinema (último exercício de for)
// Sem etapas: tente fazer tudo sozinho.
//
// Você quer chamar amigos para o cinema e vai pagar os ingressos de todo mundo.
// Cada ingresso custa R$ 10 e você tem R$ 40 para gastar.
// Crie as variáveis $precoIngresso (10) e $orcamento (40) antes do loop.
// Use um loop for com $pessoas++ para testar de 1 até 6 pessoas, calcule o
// total dentro do loop e use um if / else para mostrar ao lado:
//    - se o total cabe no orçamento: "cabe no orçamento"
//    - se não: "passou do orçamento"
// Quando o loop terminar, mostre "Fim da conta.".
//
// Atenção: gastar exatamente R$ 40 ainda cabe no orçamento.
//
// Saída esperada:
// 1 pessoa(s): R$ 10 - cabe no orçamento
// 2 pessoa(s): R$ 20 - cabe no orçamento
// 3 pessoa(s): R$ 30 - cabe no orçamento
// 4 pessoa(s): R$ 40 - cabe no orçamento
// 5 pessoa(s): R$ 50 - passou do orçamento
// 6 pessoa(s): R$ 60 - passou do orçamento
// Fim da conta.

$precoIngresso = 10; $orcamento = 40;

for ( $pessoas = 1; $pessoas <= 6; $pessoas++){
    $vlr = $precoIngresso * $pessoas;
    echo $pessoas . " pessoa(s): R$ ". $vlr . " - ";
    if ( $vlr <= $orcamento ){
        echo "cabe no orçamento\n";
    }
    else {
        echo "passou do orçamento\n";
    }
}
echo "Fim da conta.";
