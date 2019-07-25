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
    
    if (isset($_SESSION['filtro'])) {
        unset($_SESSION['filtro']);
    }
    
    if (isset($_SESSION['filtroOrdenado'])) {
        unset($_SESSION['filtroOrdenado']);
    }
    
    if (isset($_SESSION['valorFiltrado'])) {
        unset($_SESSION['valorFiltrado']);
    }
    
    if (isset($_SESSION['sintomas'])) {
        unset($_SESSION['sintomas']);
    }
    
    if (isset($_SESSION['listaSintomas'])) {
        unset($_SESSION['listaSintomas']);
    }
}

function DesabilitarFiltro() {
    if (isset($_SESSION['filtro'])) {
        unset($_SESSION['filtro']);
    }
    
    if (isset($_SESSION['filtroOrdenado'])) {
        unset($_SESSION['filtroOrdenado']);
    }
    
    if (isset($_SESSION['valorFiltrado'])) {
        unset($_SESSION['valorFiltrado']);
    }
}

call_user_func($_POST['function']);
