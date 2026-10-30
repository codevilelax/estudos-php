Selecione um estado:
<?php require __DIR__ . "/conexao.php"; ?>

<form>
    <select name="uf">
<?php
$estados = $banco->query("SELECT DISTINCT uf FROM pessoas ORDER BY uf");
foreach ($estados as $estado){
    if ($estado["uf"] == $_GET["uf"]){
        echo "<option selected>" . $estado["uf"] . "</option>";
    } else {
        echo "<option>" . $estado["uf"] . "</option>";
    }
}
?>
</select>
<button>Buscar</button>
</form>

<?php

// Projeto: Cadastro de pessoas
// Parte 5: Levar pro navegador
// Passo 1: a busca por estado, agora numa página
//
// No navegador não existe readline: ninguém digita no terminal.
// O estado vem no fim do endereço da página, assim:
//   http://localhost:8000/?uf=MS
// E o PHP pega esse valor com:
//   $_GET["uf"]
//
// Faça a mesma busca do buscar.php, mas:
// - no lugar do readline, use $_GET["uf"];
// - no lugar do "\n", use "<br>" (no navegador, "\n" não pula linha).
//
// Abrindo http://localhost:8000/?uf=MS, tem que aparecer na página
// a lista das pessoas de MS (a Carla Mendes com 29 anos no meio) e, no fim:
// Encontradas: 6 pessoas
//
// Depois, troque o MS do endereço por BA e veja a página mudar sozinha.
//
// Próximo desafio: depois de buscar, a lista volta para AL.
// Dentro do foreach dos estados, use if / else: se o estado for o mesmo de $_GET["uf"],
// escreva o <option> com selected (ex: <option selected>MG</option>); se não, escreva normal.

if (isset($_GET["uf"])){
$uf = $_GET["uf"];

$consulta = $banco->prepare("SELECT * FROM pessoas WHERE uf = ? ORDER BY nome");
$consulta->execute([$uf]);

$encontradas = 0;

foreach ($consulta as $pessoa) {
    $encontradas += 1;
    echo $pessoa["nome"] . " - " . $pessoa["idade"] . " anos - " . $pessoa["cidade"] . "<br>";
}



// o if serve para quando o usuario escrever um estado que nao tem ninguem no banco
// (o cofre $encontradas ficou 0), mostrar a mensagem abaixo.
// else, caso tenha gente desse estado, mostra so a quantidade.
// (os nomes e os dados de cada pessoa quem mostra e o foreach, antes do if)

if ($encontradas == 0) {
    echo "Nenhuma pessoa encontrada em " . $uf . "<br>";
} else {
    echo "Encontradas: " . $encontradas . " pessoas";
}
}
?>
<form method="post">
    Nome: <input name="nome" required><br>
        Idade: <input name="idade" required><br>
            Cidade: <input name="cidade" required><br>
                Estado: <input name="uf" required><br>
<button>Finalizar Cadastro</button>
</form>

<?php
if (isset($_POST["nome"])){
$nome = $_POST["nome"];
$idade = $_POST["idade"];
$cidade = $_POST["cidade"];
$uf = $_POST["uf"];

$insert = $banco->prepare("INSERT INTO pessoas (nome, idade, cidade, uf) VALUES (?, ?, ?, ?)");
$insert->execute([$nome, $idade, $cidade, $uf]);

echo "Pessoa cadastrada: " . $nome . " - " . $idade . " anos - " . $cidade . "/" . $uf;
}