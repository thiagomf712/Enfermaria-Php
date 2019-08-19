<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Controllers/SintomaController.php');

if (session_id() == '') {
    session_start();
}

if (isset($_SESSION['filtro'])) {
    $lista = (isset($_SESSION['filtroOrdenado'])) ? unserialize($_SESSION['filtroOrdenado']) : unserialize($_SESSION['filtro']);
} else {
    $lista = (isset($_SESSION['ordenado'])) ? unserialize($_SESSION['ordenado']) : SintomaController::Listar();
}

$numeroPaginas = ceil(count($lista) / 25);
$paginaAtual = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
$posMax = $paginaAtual * 25;
$inicio = $posMax - 25;
$limite = (count($lista) >= $posMax) ? $posMax : count($lista);

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
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css?version=2">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="../../fontawesome/css/all.min.css">

        <!-- Estilo persinalizado -->
        <link rel="stylesheet" href="../../Css/estilo.css?version=11">

        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <title>Lista - Sintomas</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>              

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">

            <!-- Titulo -->
            <header class="mb-4">
                <h2>Lista de sintoma</h2>
            </header>

            <!-- Formulario de filtro -->
            <form class="mb-3 clearfix" action="../../Controllers/SintomaController.php" method="POST">
                <input type="hidden" name="metodoSintoma" value="Filtrar"/>

                <!-- Filtro Nome -->
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input class="form-control" type="text" id="nome" name="nome"/>
                </div>       

                <!-- Botões -->
                <div class="float-sm-right">
                    <button class="btn btn-secondary" type="submit" name="remover">Procurar</button>
                    <button class="btn btn-secondary" type="button" name="remover" onclick="location.reload();" id="remover">Remover Filtro</button>
                </div>            
            </form>

            <!-- Script para desabilitar filtros -->
            <script src="../../JavaScript/jquery-3.4.1.js"></script>
            <script>
                        var buttons = document.getElementsByName('remover');

                        for (var i = 0; i < buttons.length; i++) {
                            buttons[i].addEventListener("click", chamarPhp);
                        }

                        function chamarPhp() {
                            $.post('../Compartilhado/phpAuxiliar.php', {function: 'DesabilitarFiltro'}, function (response) {
                                console.log(response);
                            });
                        }
            </script>

            <!-- Tabela -->
            <div class="table-responsive">
                <table class="table table-hover">

                    <!-- Header da tabela -->
                    <thead class="thead-light">
                        <tr>
                            <?php
                            $filtro = (isset($_SESSION['coluna'])) ? $_SESSION['coluna'] : '';
                            $ordem = (isset($_SESSION['estado'])) ? $_SESSION['estado'] : '';
                            ?>

                            <!-- Ordenar Id -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/SintomaController.php">
                                    <input type="hidden" name="metodoSintoma" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltro' : 'Ordenar'; ?>"/>
                                    <input type="hidden" name="coluna" value="Id"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "Id" && $ordem == "DESC") ? 'ASC' : 'DESC' ?>"/>

                                    <span>#</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Ordenar Nome -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/SintomaController.php">
                                    <input type="hidden" name="metodoSintoma" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltro' : 'Ordenar'; ?>"/>
                                    <input type="hidden" name="coluna" value="Nome"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "Nome" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>

                                    <span>Nome</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Açoes -->
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>

                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php for ($i = $inicio; $i < $limite; $i++) : ?>
                            <tr class="table-light">

                                <!-- Numeração -->
                                <td><?php echo $i + 1; ?></td>

                                <!-- Nome -->
                                <td><?php echo $lista[$i]['Nome']; ?></td>

                                <!-- Açoes -->
                                <td>
                                    <!-- Editar -->
                                    <a href="Editar.php?sintoma=<?php echo $lista[$i]['Id']; ?>" class="btn btn-primary btn-sm mb-1">Editar</a>  

                                    <!-- Deletar -->
                                    <button type="submit" class="btn btn-primary btn-sm mb-1" form="<?php echo 'index' . $i; ?>">Excluir</button> 
                                    <form method="GET" id="<?php echo 'index' . $i; ?>">
                                        <input type="hidden" name="i" value="<?php echo $i; ?>" />                                   
                                    </form>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table> 
            </div>

            <!-- Paginação -->
            <?php include_once '../Compartilhado/Paginacao.php'; ?>
        </div>  

        <?php if (isset($_GET['i']) && !(isset($_SESSION['erro']))) { ?>
            <script>
                $(document).ready(function () {
                    $("#modalAlerta").modal();
                });
            </script>  
            <?php
            $index = $_GET['i'];
        }
        ?>

        <!-- Modal - Deletar -->
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
                            <input type="hidden" name="id" value="<?php echo $lista[$index]['Id']; ?>" />
                        </form>

                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="history.go(-1);">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rodapé -->    
        <?php include_once '../Compartilhado/Footer.php'; ?>
        
        <!-- Janela que aparece ao acontecer um erro no Backend (Precisa ser inserido depois do Jquery) -->
        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?> 

        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>          
    </body>
</html>
