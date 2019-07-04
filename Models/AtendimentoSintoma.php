<?php

class AtendimentoSintoma {
    private $id;
    private $especificacao;
    private $Atendimento;
    private $Sintoma;
    
    public function getId() {
        return $this->id;
    }

    public function getEspecificacao() {
        return $this->especificacao;
    }

    public function getAtendimento() {
        return $this->Atendimento;
    }

    public function getSintoma() {
        return $this->Sintoma;
    }

    public function __construct(int $id, string $especificacao, Atendimento $Atendimento,
            Sintoma $Sintoma) {
        $this->id = $id;
        $this->especificacao = $especificacao;
        $this->Atendimento = $Atendimento;
        $this->Sintoma = $Sintoma;
    }

}
