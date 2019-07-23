<?php

require_once 'Pessoa.php';

class Paciente extends Pessoa {

    private $ra;
    private $dataNascimento;
    private $email;
    private $telefone;

    //relacionamentos
    private $endereco;
    private $fichaMedica;
    
    public function getRa() {
        return $this->ra;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelefone() {
        return $this->telefone;
    }
    
    public function getEndereco() {
        return $this->endereco;
    }

    public function getFichaMedica() {
        return $this->fichaMedica;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setFichaMedica($fichaMedica) {
        $this->fichaMedica = $fichaMedica;
    }

    
    public function __construct(int $id, string $nome, int $ra,
            $dataNascimento, string $email, string $telefone) {
        parent::__construct($id, $nome, null);
        $this->ra = $ra;
        $this->dataNascimento = $dataNascimento;
        $this->email = $email;
        $this->telefone = $telefone;
    }

}
