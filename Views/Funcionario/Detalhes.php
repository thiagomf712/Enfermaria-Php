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

        <title>Detalhes - Funcionario</title>
    </head>
    <body>

        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>    

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                <form>
                    
                    <!-- Informações do funcionario -->
                    <fieldset>
                        <legend class="mb-4">Informações do funcionario</legend>

                        <input type="hidden" name="funcionarioId" value="<?php echo $funcionario->getId(); ?>"/>

                        <!-- nome -->
                        <div class="form-group">
                            <label for="nome" >Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $funcionario->getNome(); ?>" readonly/>
                        </div>
                    </fieldset>
                    
                    <!-- Informações do usuario -->
                    <fieldset class="mt-4">
                        <legend class="mb-4">Informações do usuario</legend>

                        <!-- Usuario -->
                        <div class="form-group">
                            <label for="login" >Usuario</label>
                            <input type="text" class="form-control" id="login" name="login" readonly value="<?php echo $funcionario->getUsuario()->getLogin(); ?>"/>
                        </div>

                        <!-- Nivel Acesso -->
                        <div class="form-group">
                            <label for="nivelAcesso">Nivel de acesso</label>
                            <select class="form-control" id="nivelAcesso" name="nivelAcesso" disabled>
                                <option value="1" <?php DefinirSelected($na, NivelAcesso::Vizualizar); ?>>Visualizar</option>
                                <option value="2" <?php DefinirSelected($na, NivelAcesso::Adicionar); ?>>Adicionar</option>
                                <option value="3" <?php DefinirSelected($na, NivelAcesso::Editar); ?>>Editar / Remover</option>
                                <option value="4" <?php DefinirSelected($na, NivelAcesso::Master); ?>>Master</option>
                            </select>
                        </div>
                    </fieldset>

                    <!-- Botões -->
                    <div class="form-group mt-4">
                        <button type="button" class="btn btn-secondary btn-block" onclick="history.go(-1);">Voltar</button>
                    </div>
                </form>
            </div>
        </div>       

        <!-- Rodapé -->    
        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>    
    </body>
</html>