<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');
require_once(__ROOT__ . '/Models/Enums/NivelAcesso.php');

require_once(__ROOT__ . '/Controllers/SintomaController.php');

if (session_id() == '') {
    session_start();
}

$id = isset($_GET['sintoma']) ? $_GET['sintoma'] : 0;

$sintoma = SintomaController::RetornarSintoma($id);

if (!isset($_SESSION['usuario'])) {
    header("Location: ../Usuario/Login.php");
}

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <!-- Required meta tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css?version=2">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="../../fontawesome/css/all.min.css">

        <!-- Estilo persinalizado -->
        <link rel="stylesheet" href="../../Css/estilo.css?version=12">

        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <title>Editar - Sintoma</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>    

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                <form method="POST" action="../../Controllers/SintomaController.php" class="needs-validation" novalidate onsubmit="return ValidarForm()">
                    <input type="hidden" name="metodoSintoma" value="Editar"/>
                    <fieldset>
                        <legend class="mb-4">Informações do Sintoma</legend>

                        <input type="hidden" name="id" value="<?php echo $sintoma->getId(); ?>"/>

                        <!-- Nome -->
                        <div class="form-group">
                            <label for="nome" >Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required maxlength="50" minlength="3" value="<?php echo $sintoma->getNome(); ?>"/>
                            <div class="invalid-feedback" id="erroNome"></div>
                        </div>
                    </fieldset>           

                    <!-- Botões -->
                    <div class="form-row">
                        <div class="form-group mt-4 col-sm">
                            <input class="btn btn-primary btn-secondary btn-block" type="submit" value="Salvar alterações" />
                        </div>
                        <div class="form-group mt-sm-4 col-sm">
                            <button type="button" class="btn btn-secondary btn-block" onclick="history.go(-1);">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>    

        <!-- Rodapé -->    
        <?php include_once '../Compartilhado/Footer.php'; ?>

        <!-- Janela que aparece ao acontecer um erro no Backend (Precisa ser inserido depois do Jquery) -->
        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?> 

        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>   
        <script src="../../JavaScript/Sintoma/cadastroSintoma.js"></script>  
    </body>
</html>