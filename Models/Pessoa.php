<?php

class Pessoa {

    private $id;
    private $nome;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function __construct(int $id, string $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }

}
