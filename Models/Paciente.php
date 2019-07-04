<?php

class Paciente extends Pessoa {
    private $ra;
    private $dataNascimento;
    private $Email;
    private $Telefone;
    
    public function getRa() {
        return $this->ra;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function getEmail() {
        return $this->Email;
    }

    public function getTelefone() {
        return $this->Telefone;
    }

    public function setRa(int $ra) {
        $this->ra = $ra;
    }

    public function setDataNascimento(DateTime $dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    public function setEmail(string $Email) {
        $this->Email = $Email;
    }

    public function setTelefone(string $Telefone) {
        $this->Telefone = $Telefone;
    }

    public function __construct(int $id, string $nome, int $ra, 
            DateTime $dataNascimento, string $Email, string $Telefone) {
        parent::__construct($id, $nome);
        $this->ra = $ra;
        $this->dataNascimento = $dataNascimento;
        $this->Email = $Email;
        $this->Telefone = $Telefone;
    }

}
