<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');

session_start();

unset($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Login - Enfermaria</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../Css/forms.css?version=12" />
        <link rel="stylesheet" href="../../Css/bootstrap.css" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    </head>
    <body>

        <div class="mx-auto p-4 formGeral" id="loginForm">
            <form method="POST" action="../../Controllers/UsuarioController.php" class="needs-validation" novalidate onsubmit="return ValidarForm('login', 'senha')">
                <input type="hidden" name="metodoUsuario" value="Login"/>
                <div class="form-group">
                    <label for="login" >Usuario</label>
                    <input type="text" class="form-control" id="login" name="login" required maxlength="20" minlength="4"/>
                    <div class="invalid-feedback" id="erroLogin"></div>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required maxlength="20" minlength="4"/>
                    <div class="invalid-feedback" id="erroSenha"></div>
                </div>
                <div class="form-group mt-4">
                    <input class="btn btn-primary btn-block btn-lg" type="submit" value="Fazer login" />
                </div>
            </form>
        </div>        

        <?php include_once '../Compartilhado/ModalErro.php'; ?>

        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>       
        <script src="../../JavaScript/Usuario/login.js?version=15"></script>  
    </body>
</html>
