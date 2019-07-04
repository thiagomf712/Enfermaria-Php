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

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setNome(string $nome) {
        $this->nome = $nome;
    }

    public function __construct(int $id, string $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }

}
