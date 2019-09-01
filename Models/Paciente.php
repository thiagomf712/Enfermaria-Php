<?php

require_once 'Pessoa.php';

class Paciente extends Pessoa implements JsonSerializable {

    private $ra;
    private $dataNascimento;
    private $email;
    private $telefone;
    //relacionamentos
    private $endereco;
    private $fichaMedica;

    public function __get($name) {
        return $this->$name;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setFichaMedica($fichaMedica) {
        $this->fichaMedica = $fichaMedica;
    }

    public function __construct($id = 0, $nome = "", $ra = null, $dataNascimento = null, $email = "", $telefone = "") {
        parent::__construct($id, $nome, null);
        $this->ra = $ra;
        $this->dataNascimento = $dataNascimento;
        $this->email = $email;
        $this->telefone = $telefone;
    }

}
