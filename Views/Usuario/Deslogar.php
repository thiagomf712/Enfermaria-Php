<?php

if (session_id() == '') {
    session_start();
}

unset($_SESSION['usuario']);

header('Location: Login.php');
