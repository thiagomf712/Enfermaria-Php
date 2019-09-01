<?php

require_once 'Enums/NivelAcesso.php';

class Usuario implements JsonSerializable {

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

        if ($paciente->ra < 10) {
            $this->login = "ec.0" . $paciente->ra;
            $this->senha = "ec.0" . $paciente->ra;
        } else {
            $this->login = "ec." . $paciente->ra;
            $this->senha = "ec." . $paciente->ra;
        }

        $this->nivelAcesso = NivelAcesso::Vizualizar;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}
