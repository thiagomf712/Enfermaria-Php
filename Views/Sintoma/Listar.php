<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Controllers/SintomaController.php');

if (session_id() == '') {
    session_start();
}

$lista = (isset($_SESSION['ordenado'])) ? unserialize($_SESSION['ordenado']) : SintomaController::Listar();
unset($_SESSION['ordenado']);

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Lista - Sintomas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../Css/forms.css?version=20" /> 
        <link rel="stylesheet" href="../../Css/bootstrap.css" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>          
    </head>
    <body>
        <?php include_once '../Compartilhado/Navbar.php'; ?>              

        <div class="mx-auto p-4 formGeral listas">
            <header class="mb-4">
                <h2>Lista de sintoma</h2>
            </header>

            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <?php
                        $filtro = (isset($_SESSION['coluna'])) ? $_SESSION['coluna'] : '';
                        $ordem = (isset($_SESSION['estado'])) ? $_SESSION['estado'] : '';
                        
                        unset($_SESSION['coluna']);
                        unset($_SESSION['estado']);
                        ?>

                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/SintomaController.php">
                                <input type="hidden" name="metodoSintoma" value="Filtrar"/>
                                <input type="hidden" name="coluna" value="Id"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "Id" && $ordem == "DESC") ? 'ASC' : 'DESC' ?>"/>
                                <button type="submit" class="border-0 bg-transparent">#</button>
                            </form>
                        </th>
                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/SintomaController.php">
                                <input type="hidden" name="metodoSintoma" value="Filtrar"/>
                                <input type="hidden" name="coluna" value="Nome"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "Nome" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                <button type="submit" class="border-0 bg-transparent">Nome</button>
                            </form>
                        </th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $numeroPaginas = ceil(count($lista) / 25);
                    $paginaAtual = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
                    $posMax = $paginaAtual * 25;
                    $inicio = $posMax - 25;
                    $limite = (count($lista) >= $posMax) ? $posMax : count($lista);
                    ?>
                    <?php for ($i = $inicio; $i < $limite; $i++) { ?>
                        <tr class = "table-dark">
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $lista[$i]['Nome']; ?></td>
                            <td>
                                <a href="Editar.php?sintoma=<?php echo $lista[$i]['Id']; ?>" class="btn btn-primary btn-sm">Editar</a>                     
                                <button type="submit" class="btn btn-primary btn-sm" form="<?php echo 'index' . $i; ?>">Excluir</button> 
                                <form method="GET" id="<?php echo 'index' . $i; ?>">
                                    <input type="hidden" name="i" value="<?php echo $i; ?>" />                                   
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table> 

            <form method="GET" class="form-inline">                
                <select class="custom-select my-1 mr-2" name="pagina">
                    <?php for ($i = 1; $i <= $numeroPaginas; $i++) { ?>
                        <option value="<?php echo $i; ?>" <?php echo ($i == $paginaAtual) ? 'selected' : ''; ?>><?php echo 'Pagina ' . $i; ?></option>
                    <?php } ?>
                </select>

                <input class="btn btn-primary" type="submit" value="Ir" />              
            </form>
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
                        <p>Tem certeza que quer deletar o sintoma <strong><?php echo $lista[$index]['Nome']; ?> </strong></p>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="submit" class="btn btn-primary" form="Deletar">Deletar</button>

                        <form method="POST" id="Deletar" action="../../Controllers/SintomaController.php">
                            <input type="hidden" name="metodoSintoma" value="Deletar"/>
                            <input type="hidden" name="Id" value="<?php echo $lista[$index]['Id']; ?>" />
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