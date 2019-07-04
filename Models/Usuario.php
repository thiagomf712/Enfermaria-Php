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

    public function __construct(int $id, string $login, string $senha, NivelAcesso $nivelAcesso) {
        $this->id = $id;
        $this->login = $login;
        $this->senha = $senha;
        $this->nivelAcesso = $nivelAcesso;
    }
    
    public function DefinirUsuarioPadrao(int $id, Paciente $paciente) {
        $this->id = $id;
        $this->login = "ec." . $paciente->getRa();
        $this->senha = (string) $paciente->getRa();
        $this->nivelAcesso = NivelAcesso::Vizualizar;
    }
}
