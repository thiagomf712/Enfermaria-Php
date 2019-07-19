<?php

require_once 'Pessoa.php';

class Funcionario extends Pessoa{
    
    public function __construct(int $id, string $nome, $usuario = null) {
        parent::__construct($id, $nome, $usuario);
    }
}
