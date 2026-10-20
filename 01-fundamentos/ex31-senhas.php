<?php

// Exercício 31: Fila de senhas (for com $senha++)
// Sem etapas: tente fazer tudo sozinho.
//
// No banco, as senhas são chamadas em ordem, da 1 até a 6.
// A sua senha é a 4.
// Crie a variável $minhaSenha (4) antes do loop.
// Use um loop for com o atalho $senha++ para passar pelas senhas, e um
// if / elseif / else para mostrar ao lado:
//    - senhas antes da sua: "já chamada"
//    - a sua senha: "sua vez!"
//    - senhas depois da sua: "aguarde"
// Quando o loop terminar, mostre "Fila encerrada.".
//
// Saída esperada:
// Senha 1 - já chamada
// Senha 2 - já chamada
// Senha 3 - já chamada
// Senha 4 - sua vez!
// Senha 5 - aguarde
// Senha 6 - aguarde
// Fila encerrada.

$minhaSenha = 4;

for ( $senha = 1; $senha <= 6; $senha++) {
    echo "Senha " . $senha . " - ";
    if ( $senha < $minhaSenha ) {
        echo "já chamada\n";
    }
    elseif ( $senha == $minhaSenha ) {
        echo "sua vez!\n";
    }
    else {
        echo "aguarde\n";
    }
}
echo "Fila encerrada.";

