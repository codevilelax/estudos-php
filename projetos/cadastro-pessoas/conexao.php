<?php

$banco = new PDO("sqlite:" . __DIR__ . "/../../03-banco-de-dados/banco/estudos.sqlite");
$banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);