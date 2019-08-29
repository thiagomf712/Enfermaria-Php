<?php

require_once 'Enums/NivelAcesso.php';

class Usuario implements JsonSerializable{
    private $id;
    private $login;
    private $senha;
    private $nivelAcesso;
    
    public function __get($name) {
        return $this->$name;
    }

    public function __construct($id = 0, $login = "", $senha = "", $nivelAcesso = NivelAcesso::Vizualizar) {
        $this->id = $id;
        $this->login = $login;
        $this->senha = $senha;
        $this->nivelAcesso = $nivelAcesso;
    }
    
    public function DefinirUsuarioPadrao(Paciente $paciente) {
        $this->login = "ec." . $paciente->getRa();
        $this->senha = "ec." . $paciente->getRa();
        $this->nivelAcesso = NivelAcesso::Vizualizar;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
