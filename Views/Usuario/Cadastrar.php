<?php
require_once '../../Models/Usuario.php';

session_start();

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Cadastro - Usuarios</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../Css/forms.css" /> 
        <link rel="stylesheet" href="../../Css/bootstrap.css" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    

    </head>
    <body>
        <?php include_once '../Compartilhado/Navbar.php'; ?> 
        
        <div class="mx-auto p-4 formGeral" id="usuarioCadastro">
            <form method="POST" action="../../Controllers/UsuarioController.php" class="needs-validation" novalidate onsubmit="return ValidarForm()">
                <input type="hidden" name="metodoUsuario" value="Cadastrar"/>
                <fieldset>
                    <legend class="mb-4">Informações do usuario</legend>

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

                    <div class="form-group">
                        <label for="confirmarSenha">Digite a senha novamente</label>
                        <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" required maxlength="20" minlength="4"/>
                        <div class="invalid-feedback" id="erroConfirmarSenha"></div>
                    </div>

                    <div class="form-group">
                        <label for="nivelAcesso">Nivel de acesso</label>
                        <select class="form-control" id="nivelAcesso" name="nivelAcesso">
                            <option value="1">Visualizar</option>
                            <option value="2">Adicionar</option>
                            <option value="3">Editar / Remover</option>
                            <option value="4">Master</option>
                        </select>
                    </div>
                </fieldset>

                <div class="form-row">
                    <div class="form-group mt-4 col-md">
                        <input class="btn btn-primary btn-block btn-lg" type="submit" value="Cadastrar Usuario" />
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
        <script src="../../JavaScript/Usuario/cadastroUsuario.js?version=13"></script> 
    </body>
</html>
