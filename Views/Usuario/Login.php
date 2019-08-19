<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');

session_start();

unset($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!-- Required meta tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="../../fontawesome/css/all.min.css">

        <!-- Estilo persinalizado -->
        <link rel="stylesheet" href="../../Css/estilo.css">

        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <title>Login - Unaspmed</title>
    </head>
    <body>

        <!-- Area de login -->
        <div id="area-login" class="container">

            <!-- Logo do site -->
            <div class="row">
                <div id="area-imagem" class="col-5">                     
                    <img src="../../img/unasp.jpeg" alt="logo" class="img-fluid">
                </div>           
            </div>

            <!-- Formulario -->
            <div class="row">
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                    <form method="POST" action="../../Controllers/UsuarioController.php" class="needs-validation" novalidate onsubmit="return ValidarForm('login', 'senha')">
                        <input type="hidden" name="metodoUsuario" value="Login"/>

                        <!-- Input Login -->
                        <div class="form-group">
                            <label for="login" >Usuario</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <i class="fas fa-user input-group-text"></i>
                                </div>

                                <input type="text" class="form-control" id="login" name="login" required maxlength="20" minlength="4" aria-describedby="loginHelp"/>
                                <div class="invalid-feedback" id="erroLogin"></div>
                            </div>
                            <small id="loginHelp" class="form-text text-muted">Paciente: ec.Ra</small>     
                        </div>

                        <!-- Input Senha -->
                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <i class="fas fa-lock input-group-text"></i>
                                </div>

                                <input type="password" class="form-control" id="senha" name="senha" required maxlength="20" minlength="4" aria-describedby="senhaHelp"/>
                                <div class="invalid-feedback" id="erroSenha"></div>
                            </div>       
                            <small id="senhaHelp" class="form-text text-muted">Paciente: ec.Ra</small>                   
                        </div>

                        <!-- Input Submit -->
                        <div class="form-group mt-5 d-flex justify-content-center">
                            <input class="btn btn-primary" type="submit" value="Entrar" />
                        </div>
                    </form>
                </div>        
            </div>
        </div>

        <!-- Rodapé -->
        <?php include_once '../Compartilhado/Footer.php'; ?>    

        <!-- Janela que aparece ao acontecer um erro no Backend (Precisa ser inserido depois do Jquery) -->
        <?php include_once '../Compartilhado/ModalErro.php'; ?>

        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>       
        <script src="../../JavaScript/Usuario/login.js"></script>  
    </body>
</html>
