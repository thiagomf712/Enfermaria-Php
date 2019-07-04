<?php

class Funcionario extends Pessoa{
    
    public function __construct(int $id, string $nome) {
        parent::__construct($id, $nome);
    }
}
