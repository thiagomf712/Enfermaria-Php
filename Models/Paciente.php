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

    public function __construct(int $id, string $nome, int $ra, 
            DateTime $dataNascimento, string $Email, string $Telefone, Usuario $usuario) {
        parent::__construct($id, $nome, $usuario);
        $this->ra = $ra;
        $this->dataNascimento = $dataNascimento;
        $this->Email = $Email;
        $this->Telefone = $Telefone;
    }

}
