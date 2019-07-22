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
        <link rel="stylesheet" href="../../Css/bootstrap.css?version=12" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    

    </head>
    <body>
        <?php include_once '../Compartilhado/Navbar.php'; ?>              

        <div class="mx-auto p-4 formGeral listas">
            <header class="mb-4">
                <h2>Lista de funcionarios</h2>
            </header>

            <table class="table table-hover">
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
                        <tr class = "<?php echo ($i % 2 == 0) ? 'table-dark' : 'table-dark '; ?>">
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
                                <button type="submit" class="btn btn-primary btn-sm" form="<?php echo 'index' . $i; ?>">Excluir</button> 
                                <form method="GET" id="<?php echo 'index' . $i; ?>">
                                    <input type="hidden" name="i" value="<?php echo $i; ?>" />                                   
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table> 
        </div>  

        <?php if (isset($_GET['i'])) { ?>
            <script>
                $(document).ready(function () {
                    $("#modalAlerta").modal();
                });
            </script>  
            <?php
            $index = $_GET['i'];
        }
        ?>

        <div class="modal fade" id="modalAlerta">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning p-2">
                        <h5 class="modal-title">Atenção</h5>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que quer deletar o funcionario <strong><?php echo $lista[$index]['Nome']; ?> </strong></p>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="submit" class="btn btn-primary" form="Deletar">Deletar</button>

                        <form method="POST" id="Deletar" action="../../Controllers/FuncionarioController.php">
                            <input type="hidden" name="metodoFuncionario" value="Deletar"/>
                            <input type="hidden" name="funcionarioId" value="<?php echo $lista[$index]['Id']; ?>" />   
                            <input type="hidden" name="usuarioId" value="<?php echo $lista[$index]['UsuarioId']; ?>" />
                        </form>

                        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
            
        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?>

        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>    
    </body>
</html>
