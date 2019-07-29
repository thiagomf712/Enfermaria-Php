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

function AdicionarSintomaCarregado() {
    if (isset($_SESSION['sintomas'])) {
        $_SESSION['sintomas'] += 1;
    } else {
        $_SESSION['sintomas'] = 2;
    }

    return RenderizarSintomaCarregado();
}

function CarregarSintoma() {
    if (!isset($_SESSION['sintomas'])) {
        $_SESSION['sintomas'] = 1;
    }

    if (isset($_POST['varios']) && $_POST['varios'] == "sim") {
        AdicionarSintomaCarregado();
    } else {
        return RenderizarSintoma();
    }
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

    if (isset($_SESSION['sintomasCarregados'])) {
        unset($_SESSION['sintomasCarregados']);
    }
}

function RenderizarSintoma() {
    $numeroSintomas = (isset($_SESSION['sintomas'])) ? $_SESSION['sintomas'] : 1;
    $sintomas = unserialize($_SESSION['listaSintomas']);

    $render = '<div class="form-row" id="div' . $numeroSintomas . '">                            
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

function RenderizarSintomaCarregado() {
    $numeroSintomas = (isset($_SESSION['sintomas'])) ? $_SESSION['sintomas'] : 1;
    $sintomas = unserialize($_SESSION['listaSintomas']);

    $sintomasCarregados = unserialize($_SESSION['sintomasCarregados']);
    $index = $_POST['index'];

    $render = '<div class="form-row"  id="div' . $numeroSintomas . '">
            <input type="hidden" name="idRegistro' . $numeroSintomas . '" value="' . $sintomasCarregados[$index]["Id"] . '" />
            <div class="form-group col-md">
                <label for="sintoma' . $numeroSintomas . '">Sintoma</label>
                <select class="form-control" id="sintoma' . $numeroSintomas . '" name="sintoma' . $numeroSintomas . '">';

    for ($y = 0; $y < count($sintomas); $y++) {
        if ($sintomasCarregados[$index]["SintomaId"] == $sintomas[$y]["Id"]) {
            $render .= '
                    <option value="' . $sintomas[$y]["Id"] . '" selected>' . $sintomas[$y]["Nome"] . '</option>';
        } else {
            $render .= '
                    <option value="' . $sintomas[$y]["Id"] . '">' . $sintomas[$y]["Nome"] . '</option>';
        }
    }

    $render .= '</select>
            </div>

            <div class="form-group col-md">	
                <label for="especificacao' . $numeroSintomas . '">Especificação</label>
                <input type="text" name="especificacao' . $numeroSintomas . '" id="especificacao' . $numeroSintomas . '" class="form-control" maxlength="50" value="' . $sintomasCarregados[$index]["Especificacao"] . '"/>
            </div>	
        </div>';

    echo json_encode($render, JSON_UNESCAPED_UNICODE);
}

call_user_func($_POST['function']);

