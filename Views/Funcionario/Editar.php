<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');
require_once(__ROOT__ . '/Models/Enums/NivelAcesso.php');

require_once(__ROOT__ . '/Controllers/FuncionarioController.php');

if (session_id() == '') {
session_start();
}

$id = isset($_GET['funcionario']) ? $_GET['funcionario'] : 0;
$usuarioId = isset($_GET['usuario']) ? $_GET['usuario'] : 0;

$funcionario = FuncionarioController::RetornarFuncionario($id, $usuarioId);

$na = $funcionario->getUsuario()->getNivelAcesso(); 

function DefinirSelected($nivelAcesso, $valorSelecionado) {
    echo ($nivelAcesso == $valorSelecionado) ? 'selected' : '';
}



$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Editar - Funcionario</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../Css/forms.css" /> 
        <link rel="stylesheet" href="../../Css/bootstrap.css" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    

    </head>
    <body>
        <?php include_once '../Compartilhado/Navbar.php'; ?>    

        <div class="mx-auto p-4 formGeral">
            <form method="POST" action="../../Controllers/FuncionarioController.php" class="needs-validation" novalidate onsubmit="return ValidarForm()">
                <input type="hidden" name="metodoFuncionario" value="Editar"/>
                <fieldset>
                    <legend class="mb-4">Informações do funcionario</legend>

                    <input type="hidden" name="funcionarioId" value="<?php echo $funcionario->getId(); ?>"/>
                    
                    <div class="form-group">
                        <label for="nome" >Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required maxlength="50" minlength="3" value="<?php echo $funcionario->getNome(); ?>"/>
                        <div class="invalid-feedback" id="erroNome"></div>
                    </div>
                </fieldset>
                <fieldset class="mt-4">
                    <legend class="mb-4">Informações do usuario</legend>

                    <input type="hidden" name="usuarioId" value="<?php echo $funcionario->getUsuario()->getId(); ?>"/>
                    
                    <div class="form-group">
                        <label for="login" >Usuario</label>
                        <input type="text" class="form-control" id="login" name="login" required maxlength="20" minlength="4" value="<?php echo $funcionario->getUsuario()->getLogin(); ?>"/>
                        <div class="invalid-feedback" id="erroLogin"></div>
                    </div>

                    <div class="form-group">
                        <label for="senha">Nova Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" maxlength="20" minlength="4" placeholder="Deixa em branco caso queira manter a mesma senha"/>
                        <div class="invalid-feedback" id="erroSenha"></div>
                        
                        <input type="hidden" name="senhaAtual" value="<?php echo $funcionario->getUsuario()->getSenha();?>"
                    </div>

                    <div class="form-group">
                        <label for="confirmarSenha">Digite a senha novamente</label>
                        <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" maxlength="20" minlength="4" placeholder="Deixa em branco caso queira manter a mesma senha"/>
                        <div class="invalid-feedback" id="erroConfirmarSenha"></div>
                    </div>

                    <div class="form-group">
                        <label for="nivelAcesso">Nivel de acesso</label>
                        <select class="form-control" id="nivelAcesso" name="nivelAcesso">
                            <option value="1" <?php DefinirSelected($na, NivelAcesso::Vizualizar); ?>>Visualizar</option>
                            <option value="2" <?php DefinirSelected($na, NivelAcesso::Adicionar); ?>>Adicionar</option>
                            <option value="3" <?php DefinirSelected($na, NivelAcesso::Editar); ?>>Editar / Remover</option>
                            <option value="4" <?php DefinirSelected($na, NivelAcesso::Master); ?>>Master</option>
                        </select>
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
        <script src="../../JavaScript/Funcionario/editarFuncionario.js"></script>  
    </body>
</html>