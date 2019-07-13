<?php

class Usuario {
    private $id;
    private $login;
    private $senha;
    private $nivelAcesso;
    
    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getNivelAcesso() {
        return $this->nivelAcesso;
    }

    public function __construct(int $id, string $login = "", string $senha = "",
            int $nivelAcesso = NivelAcesso::Vizualizar) {
        $this->id = $id;
        $this->login = $login;
        $this->senha = $senha;
        $this->nivelAcesso = $nivelAcesso;
    }
    
    public function DefinirUsuarioPadrao(Paciente $paciente) {
        $this->login = "ec." . $paciente->getRa();
        $this->senha = (string) $paciente->getRa();
        $this->nivelAcesso = NivelAcesso::Vizualizar;
    }
}
