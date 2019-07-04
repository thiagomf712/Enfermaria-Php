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

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setRegime(Regime $regime) {
        $this->regime = $regime;
    }

    public function setLogradouro(string $logradouro) {
        $this->logradouro = $logradouro;
    }

    public function setNumero(string $numero) {
        $this->numero = $numero;
    }

    public function setComplemento(string $complemento) {
        $this->complemento = $complemento;
    }

    public function setBairro(string $bairro) {
        $this->bairro = $bairro;
    }

    public function setCidade(string $cidade) {
        $this->cidade = $cidade;
    }

    public function setEstado(string $estado) {
        $this->estado = $estado;
    }

    public function setCep(string $cep) {
        $this->cep = $cep;
    }

    public function __construct(int $id, Regime $regime = Regime::Interno,
            string $logradouro = "Estr. Mun Pastor Walter Boger", string $numero = "s/n",
            string $complemento = null, string $bairro = "Lagoa Bonita",
            string $cidade = "Engenheiro Coelho", string $estado = "São Paulo",
            string $cep = "13448-900") {
        $this->id = $id;
        $this->regime = $regime;
        $this->logradouro = $logradouro;
        $this->numero = $numero;
        $this->complemento = $complemento;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->cep = $cep;
    }

}
