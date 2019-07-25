<?php

class Atendimento {
    private $id;
    private $data; 
    private $hora; 
    private $procedimento;
    
    //Relacionamentos
    private $paciente;
    private $funcionario;
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    
    public function getData() {
        return $this->data;
    }

    public function getProcedimento() {
        return $this->procedimento;
    }
    
    public function getPaciente() {
        return $this->paciente;
    }

    public function getFuncionario() {
        return $this->funcionario;
    }

    public function getHora() {
        return $this->hora;
    }

    
        
    public function __construct(int $id, $data, $hora, string $procedimento,
            $paciente, $funcionario) {
        $this->id = $id;
        $this->hora = $hora;
        $this->data = $data;
        $this->procedimento = $procedimento;
        $this->paciente = $paciente;
        $this->funcionario = $funcionario;  
        
    }
}
