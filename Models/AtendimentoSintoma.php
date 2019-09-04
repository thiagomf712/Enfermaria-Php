<?php

class AtendimentoSintoma implements JsonSerializable {
    private $id;
    private $especificacao;
    private $atendimento;
    private $sintoma;
    
    public function __get($name) {
        return $this->$name;
    }
    
    public function setAtendimento($atendimento) {
        $this->atendimento = $atendimento;
    }

    
    public function __construct($id = 0, $especificacao = '', $sintoma = null, $atendimento = null) {
        $this->id = $id;
        $this->especificacao = $especificacao;
        $this->atendimento = $atendimento;
        $this->sintoma = $sintoma;
    }
    
    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
