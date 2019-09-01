<?php

class Endereco {

    private $id;
    private $regime;
    private $logradouro;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $estado;
    private $cep;
    
    //Relacionamentos
    private $paciente;
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function __construct($id = 0, $regime = 1, $logradouro = "", $numero = "", $complemento = "", $bairro = "",
           $cidade = "", $estado = "", $cep = "", $paciente = null) {
        $this->id = $id;
        $this->regime = $regime;
        $this->logradouro = $logradouro;
        $this->numero = $numero;
        $this->complemento = $complemento;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->cep = $cep;
        $this->paciente = $paciente;
    }

}
