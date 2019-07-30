<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');

session_start();

if(!isset($_SESSION['usuario'])) {
    header("Location: ../Usuario/Login.php");
}

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Cadastro - Sintomas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../Css/forms.css?version=13" /> 
        <link rel="stylesheet" href="../../Css/bootstrap.css" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    

    </head>
    <body>
        <?php include_once '../Compartilhado/Navbar.php'; ?> 
        
        <div class="mx-auto p-4 formGeral form-medio">
            <form method="POST" action="../../Controllers/SintomaController.php" class="needs-validation" novalidate onsubmit="return ValidarForm()">
                <input type="hidden" name="metodoSintoma" value="Cadastrar"/>
                <fieldset>
                    <legend class="mb-4">Informações do sintoma</legend>

                    <div class="form-group">
                        <label for="nome" >Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required maxlength="50" minlength="3"/>
                        <div class="invalid-feedback" id="erroNome"></div>
                    </div>
                </fieldset>

                <div class="form-row">
                    <div class="form-group mt-4 col-md">
                        <input class="btn btn-primary btn-block btn-lg" type="submit" value="Cadastrar Sintoma" />
                    </div>
                    <div class="form-group mt-4 col-md">
                        <a class="btn btn-primary btn-block btn-lg" href="../Geral/Home.php">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
        
        
        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?>
        
        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>   
        <script src="../../JavaScript/Sintoma/cadastroSintoma.js?version=13"></script> 
    </body>
</html>
