<?php

class Pessoa {

    private $id;
    private $nome;

    //Relacionamento
    private $usuario;
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getUsuario() {
        return $this->usuario;
    }
    
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

            
    public function __construct(int $id, string $nome, $usuario) {
        $this->id = $id;
        $this->nome = $nome;
        $this->usuario = $usuario;
    }

}
