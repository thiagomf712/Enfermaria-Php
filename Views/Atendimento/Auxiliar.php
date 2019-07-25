<?php

if (session_id() == '') {
    session_start();
}

function AdicionarSintoma() {
    if (isset($_SESSION['sintomas'])) {
        $_SESSION['sintomas'] += 1;
    } else {
        $_SESSION['sintomas'] = 2;
    }

    return RenderizarSintoma();
}

function CarregarSintoma() {
    if (!isset($_SESSION['sintomas'])) {
        $_SESSION['sintomas'] = 1;
    }

    return RenderizarSintoma();
}

function RemoverSintoma() {
    if (isset($_SESSION['sintomas'])) {
        if ($_SESSION['sintomas'] <= 2) {
            $_SESSION['sintomas'] = 1;
        } else {
            $_SESSION['sintomas'] -= 1;
        }
    }
}

function DesabilitarSintomas() {
    if (isset($_SESSION['sintomas'])) {
        unset($_SESSION['sintomas']);
    }
}

function RenderizarSintoma() {
    $numeroSintomas = (isset($_SESSION['sintomas'])) ? $_SESSION['sintomas'] : 1;
    $sintomas = unserialize($_SESSION['listaSintomas']);

    $render = '<div class="form-row">                            
            <div class="form-group col-md">
                <label for="sintoma' . $numeroSintomas . '">Sintoma</label>
                <select class="form-control" id="sintoma' . $numeroSintomas . '" name="sintoma' . $numeroSintomas . '">';

    for ($y = 0; $y < count($sintomas); $y++) {
        $render .= '
                    <option value="' . $sintomas[$y]["Id"] . '">' . $sintomas[$y]["Nome"] . '</option>';
    }

    $render .= '</select>
            </div>

            <div class="form-group col-md">	
                <label for="especificacao' . $numeroSintomas . '">Especificação</label>
                <input type="text" name="especificacao' . $numeroSintomas . '" id="especificacao' . $numeroSintomas . '" class="form-control" maxlength="50"/>
            </div>	
        </div>';

    echo json_encode($render, JSON_UNESCAPED_UNICODE);
}

call_user_func($_POST['function']);

