<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');
require_once(__ROOT__ . '/Models/Enums/NivelAcesso.php');
require_once(__ROOT__ . '/Models/Enums/Regime.php');

require_once(__ROOT__ . '/Controllers/AtendimentoController.php');

if (session_id() == '') {
    session_start();
}

if (isset($_SESSION['filtro'])) {
    $lista = (isset($_SESSION['filtroOrdenado'])) ? unserialize($_SESSION['filtroOrdenado']) : unserialize($_SESSION['filtro']);
} else {
    $lista = (isset($_SESSION['ordenado'])) ? unserialize($_SESSION['ordenado']) : AtendimentoController::ListarPacientes();
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
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="../../fontawesome/css/all.min.css">

        <!-- Estilo persinalizado -->
        <link rel="stylesheet" href="../../Css/estilo.css">

        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <title>Lista - Pacientes</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>              

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">

            <!-- Titulo -->
            <header class="mb-4">
                <h2>Lista de Pacientes</h2>
            </header>

            <!-- Formulario de filtro -->
            <form action="../../Controllers/AtendimentoController.php" method="POST">
                <input type="hidden" name="metodoAtendimento" value="FiltrarPacientes"/>

                <div class="form-row">

                    <!-- Nome -->
                    <div class="form-group col-sm">
                        <label for="nome">Nome: </label>
                        <input class="form-control" type="text" id="nome" name="nome"/>
                    </div>    

                    <!-- Ra -->
                    <div class="form-group col-sm">
                        <label for="ra">Ra: </label>
                        <input class="form-control" type="number" id="ra" name="ra"/>
                    </div> 

                    <!-- Regime -->
                    <div class="form-group col-sm">
                        <label for="regime">Regime: </label>
                        <select class="form-control" id="regime" name="regime">
                            <option value="<?php echo Regime::Interno; ?>">Interno</option>
                            <option value="<?php echo Regime::Externo; ?>">Externo</option>
                            <option value="0" selected>Sem filtro</option>
                        </select>
                    </div> 
                </div>

                <div class="form-group float-sm-right">
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

                    <!-- Header -->
                    <thead class="thead-light">
                        <tr>
                            <?php
                            $filtro = (isset($_SESSION['coluna'])) ? $_SESSION['coluna'] : '';
                            $ordem = (isset($_SESSION['estado'])) ? $_SESSION['estado'] : '';
                            ?>

                            <!-- Ordenar Id -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                    <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltroPaciente' : 'OrdenarPaciente'; ?>"/>
                                    <input type="hidden" name="coluna" value="p.Id"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "p.Id" && $ordem == "DESC") ? 'ASC' : 'DESC' ?>"/>

                                    <span>#</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Ordenar Nome -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                    <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltroPaciente' : 'OrdenarPaciente'; ?>"/>
                                    <input type="hidden" name="coluna" value="p.Nome"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "p.Nome" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>

                                    <span>Nome</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Ordenar Ra -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                    <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltroPaciente' : 'OrdenarPaciente'; ?>"/>
                                    <input type="hidden" name="coluna" value="p.Ra"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "p.Ra" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>

                                    <span>Ra</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Ordenar Regime -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                    <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltroPaciente' : 'OrdenarPaciente'; ?>"/>
                                    <input type="hidden" name="coluna" value="e.Regime"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "e.Regime" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>

                                    <span>Regime</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Açoes -->
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

                                <!-- Ra -->
                                <td><?php echo $lista[$i]['Ra']; ?></td>

                                <!-- Regime -->
                                <td>
                                    <?php
                                    switch ($lista[$i]['Regime']) {
                                        case Regime::Interno:
                                            echo 'Interno';
                                            break;
                                        case Regime::Externo:
                                            echo 'Externo';
                                            break;
                                        default:
                                            echo 'Não definido';
                                            break;
                                    }
                                    ?>
                                </td>
                                
                                <!-- Açoes -->
                                <td>
                                    <!-- Cadastrar atendimento -->
                                    <a href="Cadastrar.php?paciente=<?php echo $lista[$i]['PacienteId']; ?>&nome=<?php echo $lista[$i]['Nome']; ?>&ra=<?php echo $lista[$i]['Ra']; ?>" class="btn btn-primary btn-sm mb-1">Adicionar Atendimento</a>  
                                   
                                    <!-- Ficha medica -->
                                    <a href="FichaMedica.php?paciente=<?php echo $lista[$i]['Nome']; ?>&ra=<?php echo $lista[$i]['Ra']; ?>&fichaMedica=<?php echo $lista[$i][1]; ?>" class="btn btn-primary btn-sm mb-1">Ficha medica</a>
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
