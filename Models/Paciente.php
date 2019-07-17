<?php

require_once 'Pessoa.php';

class Paciente extends Pessoa {

    private $ra;
    private $dataNascimento;
    private $email;
    private $telefone;

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

    public function __construct(int $id, string $nome, int $ra,
            $dataNascimento, string $email, string $telefone) {
        parent::__construct($id, $nome, null);
        $this->ra = $ra;
        $this->dataNascimento = $dataNascimento;
        $this->email = $email;
        $this->telefone = $telefone;
    }

}
