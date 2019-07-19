<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');
require_once(__ROOT__ . '/Models/Enums/NivelAcesso.php');

require_once(__ROOT__ . '/Controllers/FuncionarioController.php');

if (session_id() == '') {
    session_start();
}

$lista = FuncionarioController::Listar();

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Lista - Funcionarios</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../Css/forms.css" /> 
        <link rel="stylesheet" href="../../Css/bootstrap.css" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    

    </head>
    <body>
        <?php include_once '../Compartilhado/Navbar.php'; ?>              

        <div class="mx-auto p-4 formGeral" id="funcionarioLista">
            <header class="mb-4">
                <h2>Lista de funcionarios</h2>
            </header>

            <table class="table table-hover table-striped">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Nivel de acesso</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($lista); $i++) { ?>
                        <tr class = "<?php echo ($i % 2 == 0) ? 'table-default' : 'table-default'; ?>">
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $lista[$i]['Nome']; ?></td>
                            <td>
                                <?php
                                switch ($lista[$i]['NivelAcesso']) {
                                    case NivelAcesso::Vizualizar:
                                        echo 'Visualizar';
                                        break;
                                    case NivelAcesso::Adicionar:
                                        echo 'Adicionar';
                                        break;
                                    case NivelAcesso::Editar:
                                        echo 'Editar / Remover';
                                        break;
                                    case NivelAcesso::Master:
                                        echo 'Master';
                                        break;
                                    default:
                                        echo 'Sem nivel de acesso';
                                        break;
                                }
                                ?>
                            </td>
                            <td>
                                <a href="Detalhes.php?funcionario=<?php echo $lista[$i]['Id']; ?>&usuario=<?php echo $lista[$i]['UsuarioId']; ?>"class="btn btn-primary btn-sm">Detalhes</a>
                                <a href="Editar.php?funcionario=<?php echo $lista[$i]['Id']; ?>&usuario=<?php echo $lista[$i]['UsuarioId']; ?>"class="btn btn-primary btn-sm">Editar</a>
                                <button class="btn btn-primary btn-sm">Excluir</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table> 
        </div>  

        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?>

        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>   
        <script src="../../JavaScript/Funcionario/listaFuncionario.js"></script>  
    </body>
</html>
