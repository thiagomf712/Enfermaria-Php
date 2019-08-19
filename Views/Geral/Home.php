<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../Usuario/Login.php");
}

$usuario = unserialize($_SESSION['usuario']);
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

        <title>Unaspmed</title>
    </head>
    <body>       
        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>

        <!-- Carousel -->
        <div id="carousel" class="carousel slide d-none d-sm-block" data-ride="carousel">

            <!-- Indicadores -->
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
            </ol>

            <!-- Itens do carousel -->
            <div class="carousel-inner">

                <!-- Slide 1 -->
                <div id="slide1" class="carousel-item active">
                    <div class="carousel-caption">
                        <h3 class="display-4">Unaspmed</h3>
                    </div>          
                </div>

                <!-- Slide 2 -->
                <div id="slide2" class="carousel-item">
                    <div class="carousel-caption">
                        <h3 class="display-4">Data de lançamento</h3>
                        <p class="lead">12/08/2019</p>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div id="slide3" class="carousel-item">
                    <div class="carousel-caption">
                        <h3 class="display-4">Sua saúde em suas mãos.</h3>
                    </div>
                </div>
            </div>

            <!-- Controles -->
            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <!-- Rodapé -->
        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>       
        <script src="../../JavaScript/Usuario/login.js"></script>  
    </body>
</html>
