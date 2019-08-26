<?php

class Pessoa {

    private $id;
    private $nome;

    //Relacionamento
    private $usuario;
    
    public function __get($name) {
        return $this->$name;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
        
    public function __construct($id = 0, $nome = "", $usuario = null) {
        $this->id = $id;
        $this->nome = $nome;
        $this->usuario = $usuario;
    }

}
