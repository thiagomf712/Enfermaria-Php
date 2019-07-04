<?php

class Atendimento {
    private $id;
    private $data; //Data e hora
    private $procedimento;
    
    public function getId() {
        return $this->id;
    }

    public function getData() {
        return $this->data;
    }

    public function getProcedimento() {
        return $this->procedimento;
    }

    public function __construct(int $id, DateTime $data, string $procedimento) {
        $this->id = $id;
        $this->data = $data;
        $this->procedimento = $procedimento;
    }

}
