<?php

if (session_id() == '') {
    session_start();
}

function DesabilitarOrdenacao() {
    if (isset($_SESSION['ordenado'])) {
        unset($_SESSION['ordenado']);
    }

    if (isset($_SESSION['coluna'])) {
        unset($_SESSION['coluna']);
    }

    if (isset($_SESSION['estado'])) {
        unset($_SESSION['estado']);
    }
}

call_user_func($_POST['function']);