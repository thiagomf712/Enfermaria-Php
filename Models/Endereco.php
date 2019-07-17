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
    

    public function getId() {
        return $this->id;
    }

    public function getRegime() {
        return $this->regime;
    }

    public function getLogradouro() {
        return $this->logradouro;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCep() {
        return $this->cep;
    }
    
    public function getPaciente() {
        return $this->paciente;
    }

    
    public function __construct(int $id, int $regime, string $logradouro, string $numero, string $complemento, string $bairro,
            string $cidade, string $estado, string $cep, Paciente $paciente) {
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
