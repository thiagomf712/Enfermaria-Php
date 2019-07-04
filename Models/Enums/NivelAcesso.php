<?php

class NivelAcesso extends SplEnum{
    const __default = self::Vizualizar;
    
    const Vizualizar = 1;
    const EditarAdicioar = 2;
    const Excluir = 3;
    const Master = 4;
}
