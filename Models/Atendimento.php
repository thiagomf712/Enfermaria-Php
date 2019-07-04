<?php

class Atendimento {
    private $id;
    private $data; //Data e hora
    private $procedimento;
    
    //Relacionamentos
    private $paciente;
    private $funcionario;
    
    private $listaSintomas;
    
    public function getId() {
        return $this->id;
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

    public function getListaSintomas() {
        return $this->listaSintomas;
    }

        
    public function __construct(int $id, DateTime $data, string $procedimento,
            Paciente $paciente, Funcionario $funcionario) {
        $this->id = $id;
        $this->data = $data;
        $this->procedimento = $procedimento;
        $this->paciente = $paciente;
        $this->funcionario = $funcionario;  
        
        $this->listaSintomas = array();
    }

    public function AdicionarSintoma(AtendimentoSintoma $sintoma) {
        $this->listaSintomas[] = $sintoma;
    }
    
    public function RemoverSintoma(AtendimentoSintoma $sintoma) {
        foreach ($this->listaSintomas as $value) {
            if ($value == $sintoma) {
                unset($this->listaSintomas[]);
            }
        }    
    }
}
