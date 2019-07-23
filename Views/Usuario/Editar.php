<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Controllers/UsuarioController.php');

if (session_id() == '') {
session_start();
}

$id = isset($_GET['usuario']) ? $_GET['usuario'] : 0;;

$usuarioAlt = UsuarioController::RetornarUsuario($id);

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Editar - Usuario</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../Css/forms.css" /> 
        <link rel="stylesheet" href="../../Css/bootstrap.css" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    

    </head>
    <body>
        <?php include_once '../Compartilhado/Navbar.php'; ?>    

        <div class="mx-auto p-4 formGeral form-medio">
            <form method="POST" action="../../Controllers/UsuarioController.php" class="needs-validation" novalidate onsubmit="return ValidarForm()">
                <input type="hidden" name="metodoUsuario" value="Editar"/>
                <fieldset>
                    <legend class="mb-4">Informações do usuario</legend>
                
                    <input type="hidden" name="id" value="<?php echo $usuarioAlt->getId() ?>"/>

                    <div class="form-group">
                        <label for="senha">Nova Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" maxlength="20" minlength="4"/>
                        <div class="invalid-feedback" id="erroSenha"></div>
                    </div>

                    <div class="form-group">
                        <label for="confirmarSenha">Digite a senha novamente</label>
                        <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" maxlength="20" minlength="4"/>
                        <div class="invalid-feedback" id="erroConfirmarSenha"></div>
                    </div>
                </fieldset>

                <div class="form-row">
                    <div class="form-group mt-4 col-md">
                        <input class="btn btn-primary btn-block btn-lg" type="submit" value="Salvar alterações" />
                    </div>
                    <div class="form-group mt-4 col-md">
                        <button type="button" class="btn btn-primary btn-block btn-lg" onclick="history.go(-1);">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>    

        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?>

        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>   
        <script src="../../JavaScript/Usuario/editarUsuario.js"></script>  
    </body>
</html>