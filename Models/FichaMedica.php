<?php

class FichaMedica {
    private $id;
    private $planoSaude;
    private $problemaSaude;
    private $medicamento;
    private $alergia;
    private $cirurgia;
    
    //relacionamentos
    private $paciente;
    
    public function __get($name) {
        return $this->$name;
    }
        
    public function __construct($id = 0, $planoSaude = "", $problemaSaude = "", $medicamento = "", $alergia = "", $cirurgia = "", $paciente = null) {
        $this->id = $id;
        $this->planoSaude = $planoSaude;
        $this->problemaSaude = $problemaSaude;
        $this->medicamento = $medicamento;
        $this->alergia = $alergia;
        $this->cirurgia = $cirurgia;
        $this->paciente = $paciente;
    }

}
