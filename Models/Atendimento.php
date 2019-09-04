<?php

class Atendimento implements JsonSerializable {
    private $id;
    private $data; 
    private $hora; 
    private $procedimento;
    
    //Relacionamentos
    private $paciente;
    private $funcionario;
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
        
    public function __construct($id = 0, $data = null, $hora = null, $procedimento = "", $paciente = null, $funcionario = null) {
        $this->id = $id;
        $this->hora = $hora;
        $this->data = $data;
        $this->procedimento = $procedimento;
        $this->paciente = $paciente;
        $this->funcionario = $funcionario;      
    }
    
    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
