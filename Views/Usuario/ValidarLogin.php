<?php

if (session_id() == '') {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../Usuario/Login.php");
}
