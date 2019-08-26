<?php

require_once 'Pessoa.php';

class Funcionario extends Pessoa{
    
    public function __construct($id = 0, $nome = "", $usuario = null) {
        parent::__construct($id, $nome, $usuario);
    }
}
