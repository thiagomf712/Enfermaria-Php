<?php

class Sintoma {
    private $id;
    private $nome;
    private $procedimento;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getProcedimento() {
        return $this->procedimento;
    }
    
    public function __construct(int $id, string $nome, string $procedimento) {
        $this->id = $id;
        $this->nome = $nome;
        $this->procedimento = $procedimento;
    }
}
