<?php
require_once '../Models/Usuario.php';

session_start();

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Enfermaria</title>

        <link rel="stylesheet" href="../Css/bootstrap.css" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary">
            <a class="navbar-brand mb-0 h1" href="#">Enfermaria</a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarItens" aria-controls="navbarItens" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarItens" style="">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <!--NA = 1 :: Atendimento pessoal-->
                        <!--NA >= 2 :: lista com todos os atendimentos-->
                        <a class="nav-link" href="#">Atendimento</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Paciente</a>
                        <div class="dropdown-menu">
                            <?php if ($usuario->getNivelAcesso() == 1) : ?>
                                <a class="dropdown-item" href="#">Informações pessoais</a>                    
                            <?php elseif ($usuario->getNivelAcesso() >= 2) : ?>
                                <a class="dropdown-item" href="#">Lista de pacientes</a>
                                <a class="dropdown-item" href="#">Cadastrar novo paciente</a>                           
                            <?php endif; ?>
                        </div>         
                    </li>
                    <?php if ($usuario->getNivelAcesso() >= 3) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Sintoma</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Lista de sitomas</a>
                                <a class="dropdown-item" href="#">Cadastrar novo sintoma</a>
                            </div>         
                        </li>
                    <?php endif; ?>
                    <?php if ($usuario->getNivelAcesso() == 4) : ?>    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Funcionario</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Lista de funcionarios</a>
                                <a class="dropdown-item" href="#">Cadastrar novo funcionario</a>
                            </div>         
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Usuario</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Lista de usuarios</a>
                                <a class="dropdown-item" href="#">Cadastrar novo usuario</a>
                            </div>         
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="Usuario/Login.php">Sair</a>
                    </li>
                </ul>
            </div>
        </nav>

        <script src="../JavaScript/bootstrap.js"></script>
    </body>
</html>
