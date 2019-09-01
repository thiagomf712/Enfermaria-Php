<?php

class Sintoma implements JsonSerializable {

    private $id;
    private $nome;

    public function __get($name) {
        return $this->$name;
    }

    public function __construct($id = 0, $nome = "") {
        $this->id = $id;
        $this->nome = $nome;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}
