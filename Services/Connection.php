<?php

function Connection() {
    $host = 'localhost';
    $database = 'enfermariaphp';
    $dns = 'mysql:host='.$host.';dbname='.$database.';charset=utf8';
    $user = 'root';
    $password = '';

    try {
        $connection = new PDO($dns, $user, $password);
        return $connection;
    } catch (Exception $e) {
        throw new Exception("Erro ao conectar ao banco de dados: ");
    }
}
