<?php

class Funcionario extends Pessoa{
    
    public function __construct(int $id, string $nome, Usuario $usuario) {
        parent::__construct($id, $nome, $usuario);
    }
}
