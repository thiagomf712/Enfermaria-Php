<?php

class Sintoma {
    private $id;
    private $nome;
    private $procedimento;
    
    //Relacionamentos
    private $ocorrencias;


    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getProcedimento() {
        return $this->procedimento;
    }
    
    public function getOcorrencias() {
        return $this->ocorrencias;
    }

    
    public function __construct(int $id, string $nome, string $procedimento) {
        $this->id = $id;
        $this->nome = $nome;
        $this->procedimento = $procedimento;
        $this->ocorrencias = array();
    }
    
    public function AdicionarOcorrencia(AtendimentoSintoma $ocorrencia) {
        $this->listaSintomas[] = $ocorrencia;
    }
    
    public function RemoverOcorrencia(AtendimentoSintoma $ocorrencia) {
        foreach ($this->ocorrencias as $value) {
            if ($value == $ocorrencia) {
                unset($this->ocorrencias[]);
            }
        }    
    }
}
