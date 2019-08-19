<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Controllers/SintomaController.php');

if (session_id() == '') {
    session_start();
}

$filtrado = false;

if (isset($_SESSION['filtro'])) {
    $lista = (isset($_SESSION['filtroOrdenado'])) ? unserialize($_SESSION['filtroOrdenado']) : unserialize($_SESSION['filtro']);

    if (!isset($_SESSION['filtroOrdenado'])) {
        $_SESSION['filtroAtivo'] = $lista['Filtro'];
    }

    $Nomesintoma = $_SESSION['filtroAtivo']['sintoma'];
    $Datainicio = $_SESSION['filtroAtivo']['inicio'];
    $Datafim = $_SESSION['filtroAtivo']['fim'];

    $filtrado = true;
} else {
    $lista = (isset($_SESSION['ordenado'])) ? unserialize($_SESSION['ordenado']) : SintomaController::ListarEst();

    unset($_SESSION['filtroAtivo']);
}

$numeroPaginas = ceil(count($lista) / 25);
$paginaAtual = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
$posMax = $paginaAtual * 25;
$inicio = $posMax - 25;
$limite = (count($lista) >= $posMax) ? $posMax : count($lista);

if ($filtrado && !isset($_SESSION['filtroOrdenado'])) {
    $limite = (count($lista) >= $posMax) ? $posMax : (count($lista) - 1);
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

        <title>Estatística - Sintomas</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>              

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">

            <!-- Titulo -->
            <header class="mb-4">
                <h2>Lista estatística de sintomas</h2>
            </header>

            <!-- Formulario de filtro -->
            <form action="../../Controllers/SintomaController.php" method="POST">
                <input type="hidden" name="metodoSintoma" value="FiltrarEst"/>

                <div class="form-row">     

                    <!-- Sintoma -->
                    <div class="form-group col-md">
                        <label for="sintoma">Sintoma: </label>
                        <input class="form-control" type="text" id="sintoma" name="sintoma" value="<?php echo ($filtrado) ? $Nomesintoma : null; ?>"/>
                    </div> 

                    <!-- Data inicial -->
                    <div class="form-group col-md">
                        <label for="inicio">Data Inicial: </label>
                        <input class="form-control" type="date" id="inicio" name="inicio" value="<?php echo ($filtrado) ? $Datainicio : null; ?>"/>
                    </div>    

                    <!-- Data final -->
                    <div class="form-group col-md">
                        <label for="fim">Data Final: </label>
                        <input class="form-control" type="date" id="fim" name="fim" value="<?php echo ($filtrado) ? $Datafim : null; ?>"/>
                    </div> 
                </div>

                <!-- Botões --> 
                <div class="form-group float-md-right">
                    <button class="btn btn-secondary" type="submit" name="remover">Procurar</button>
                    <button class="btn btn-secondary" type="button" name="remover" onclick="location.reload();">Remover Filtro</button>
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
                    
                    <!-- Cabeça -->
                    <thead class="thead-light">
                        <tr>
                            <?php
                            $filtro = (isset($_SESSION['coluna'])) ? $_SESSION['coluna'] : '';
                            $ordem = (isset($_SESSION['estado'])) ? $_SESSION['estado'] : '';
                            ?>

                            <!-- Id -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/SintomaController.php">
                                    <input type="hidden" name="metodoSintoma" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltroEst' : 'OrdenarEst'; ?>"/>
                                    <input type="hidden" name="coluna" value="s.Id"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "s.Id" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                    
                                    <span>#</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Nome -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/SintomaController.php">
                                    <input type="hidden" name="metodoSintoma" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltroEst' : 'OrdenarEst'; ?>"/>
                                    <input type="hidden" name="coluna" value="s.Nome"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "s.Nome" && $ordem == "DESC") ? 'ASC' : 'DESC' ?>"/>
                                    
                                    <span>Nome</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Ocorrencias -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/SintomaController.php">
                                    <input type="hidden" name="metodoSintoma" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltroEst' : 'OrdenarEst'; ?>"/>
                                    <input type="hidden" name="coluna" value="Total"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "Total" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                   
                                    <span>Ocorrencias</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Ações -->
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    
                    <!-- Corpo -->
                    <tbody>
                        <?php for ($i = $inicio; $i < $limite; $i++) : ?>
                            <tr class="table-light">
                                
                                <!-- Numeração -->
                                <td><?php echo $i + 1; ?></td>
                                
                                <!-- Nome -->
                                <td><?php echo $lista[$i]['Nome']; ?></td>
                                
                                <!-- Ocorrencias -->
                                <td><?php echo $lista[$i]['Total']; ?></td>
                                
                                <!-- Ações -->
                                <td>
                                    <a href="Ocorrencias.php?sintomaNome=<?php echo $lista[$i]['Nome']; ?>&sintomaId=<?php echo $lista[$i]['Id']; ?><?php echo ($filtrado) ? "&inicio=" . $Datainicio . "&fim=" . $Datafim : ''; ?>" class="btn btn-primary btn-sm">Ver Ocorrencias</a>                     
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table> 
            </div>

            <!-- Paginação -->
            <?php include_once '../Compartilhado/Paginacao.php'; ?>
        </div>  

        <!-- Rodapé -->    
        <?php include_once '../Compartilhado/Footer.php'; ?>
        
        <!-- Janela que aparece ao acontecer um erro no Backend (Precisa ser inserido depois do Jquery) -->
        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?> 

        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>  
    </body>
</html>
