<?php

class AtendimentoSintoma {
    private $id;
    private $especificacao;
    private $atendimento;
    private $sintoma;
    
    public function getId() {
        return $this->id;
    }

    public function getEspecificacao() {
        return $this->especificacao;
    }

    public function getAtendimento() {
        return $this->atendimento;
    }

    public function getSintoma() {
        return $this->sintoma;
    }
    
    public function setAtendimento($atendimento) {
        $this->atendimento = $atendimento;
    }

    
    public function __construct(int $id, string $especificacao, $sintoma, $atendimento = null) {
        $this->id = $id;
        $this->especificacao = $especificacao;
        $this->atendimento = $atendimento;
        $this->sintoma = $sintoma;
    }

}
