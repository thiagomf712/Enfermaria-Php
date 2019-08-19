<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Controllers/UsuarioController.php');

if (session_id() == '') {
    session_start();
}

$id = isset($_GET['usuario']) ? $_GET['usuario'] : 0;

$usuarioAlt = UsuarioController::RetornarUsuario($id);

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

        <title>Editar - Usuario</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>    

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                <form method="POST" action="../../Controllers/UsuarioController.php" class="needs-validation" novalidate onsubmit="return ValidarForm()">
                    <input type="hidden" name="metodoUsuario" value="Editar"/>

                    <!-- Informações do usuario -->
                    <fieldset>
                        <legend class="mb-4">Informações do usuario</legend>

                        <input type="hidden" name="id" value="<?php echo $usuarioAlt->getId() ?>"/>

                        <!-- Senha -->
                        <div class="form-group">
                            <label for="senha">Nova Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" maxlength="20" minlength="4"/>
                            <div class="invalid-feedback" id="erroSenha"></div>
                        </div>

                        <!-- Confirmar Senha -->
                        <div class="form-group">
                            <label for="confirmarSenha">Digite a senha novamente</label>
                            <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" maxlength="20" minlength="4"/>
                            <div class="invalid-feedback" id="erroConfirmarSenha"></div>
                        </div>
                    </fieldset>

                    <!-- Botões -->
                    <div class="form-row">
                        <div class="form-group col-sm mt-4">
                            <input class="btn btn-secondary btn-block" type="submit" value="Salvar alterações" />
                        </div>
                        <div class="form-group col-sm mt-sm-4">
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
        <script src="../../JavaScript/Usuario/editarUsuario.js"></script>  
    </body>
</html>