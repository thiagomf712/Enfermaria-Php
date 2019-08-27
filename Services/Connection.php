<?php

class Connection {

    private $host = "localhost";
    private $dbname = "enfermariaphp";
    private $user = "root";
    private $pass = "";

    public function Conectar() {
        try {
            $dns = "mysql:host=$this->host;dbname=$this->dbname";

            $conn = new PDO($dns, $this->user, $this->pass);
            $conn->exec("SET CHARACTER SET utf8");

            return $conn;
        } catch (PDOException $e) {
            throw new Exception("Erro ao conectar ao banco de dados");
        }
    }

}