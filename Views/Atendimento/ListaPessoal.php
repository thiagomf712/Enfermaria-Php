<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');
require_once(__ROOT__ . '/Models/Enums/NivelAcesso.php');
require_once(__ROOT__ . '/Models/Enums/Regime.php');

require_once(__ROOT__ . '/Controllers/AtendimentoController.php');
require_once(__ROOT__ . '/Controllers/PacienteController.php');

if (session_id() == '') {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../Usuario/Login.php");
}

$usuario = unserialize($_SESSION['usuario']);

$pacienteId = PacienteController::RetornarIdPaciente($usuario->getId());

if (isset($_SESSION['filtro'])) {
    $lista = (isset($_SESSION['filtroOrdenado'])) ? unserialize($_SESSION['filtroOrdenado']) : unserialize($_SESSION['filtro']);
} else {
    $lista = (isset($_SESSION['ordenado'])) ? unserialize($_SESSION['ordenado']) : AtendimentoController::Listar($pacienteId);
}

//O Id do atendimento está na pocição 0 do vetor
//O nome do paciente está na posição 3 do vetor
//o Id do paciente está na pocição 4 do vetor
//O id do funcionario está na posição 6 do vetor


$numeroPaginas = ceil(count($lista) / 25);
$paginaAtual = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
$posMax = $paginaAtual * 25;
$inicio = $posMax - 25;
$limite = (count($lista) >= $posMax) ? $posMax : count($lista);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
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

        <title>Lista - Atendimentos</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>              

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">

            <!-- Titulo -->
            <header class="mb-4">
                <h2>Lista de Atendimentos</h2>
            </header>

            <!-- Formulario de filtro -->
            <form action="../../Controllers/AtendimentoController.php" method="POST">
                <input type="hidden" name="metodoAtendimento" value="Filtrar"/>

                <input type="hidden" name="pacienteId" value="<?php echo $pacienteId; ?>"/>

                <div class="form-row">     

                    <!-- Funcionario -->
                    <div class="form-group col-sm">
                        <label for="funcionario">Funcionario: </label>
                        <input class="form-control" type="text" id="funcionario" name="funcionario"/>
                    </div> 

                    <!-- Data Inicial -->
                    <div class="form-group col-sm">
                        <label for="inicio">Data Inicial: </label>
                        <input class="form-control" type="date" id="inicio" name="inicio"/>
                    </div>    

                    <!-- Data final -->
                    <div class="form-group col-sm">
                        <label for="fim">Data Final: </label>
                        <input class="form-control" type="date" id="fim" name="fim"/>
                    </div> 
                </div>

                <!-- Botões -->
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
                    
                    <!-- Cabeça -->
                    <thead class="thead-light">
                        <tr>
                            <?php
                            $filtro = (isset($_SESSION['coluna'])) ? $_SESSION['coluna'] : '';
                            $ordem = (isset($_SESSION['estado'])) ? $_SESSION['estado'] : '';
                            ?>
                            
                            <!-- Id -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                    <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltro' : 'Ordenar'; ?>"/>
                                    <input type="hidden" name="coluna" value="a.Id"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "a.Id" && $ordem == "DESC") ? 'ASC' : 'DESC' ?>"/>
                                    <input type="hidden" name="pacienteId" value="<?php echo $pacienteId; ?>"/>
                                    
                                    <span>#</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Data -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                    <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltro' : 'Ordenar'; ?>"/>
                                    <input type="hidden" name="coluna" value="a.Data"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "a.Data" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                    <input type="hidden" name="pacienteId" value="<?php echo $pacienteId; ?>"/>
                                                                        
                                    <span>Data</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- hora -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                    <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltro' : 'Ordenar'; ?>"/>
                                    <input type="hidden" name="coluna" value="a.Hora"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "a.Hora" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                    <input type="hidden" name="pacienteId" value="<?php echo $pacienteId; ?>"/>
                                    
                                    <span>Hora</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Funcionario -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                    <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltro' : 'Ordenar'; ?>"/>
                                    <input type="hidden" name="coluna" value="f.Nome"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "f.Nome" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                    <input type="hidden" name="pacienteId" value="<?php echo $pacienteId; ?>"/>
                                    
                                    <span>Funcionario</span> 
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
                                
                                <!-- Data -->
                                <td><?php echo date('d/m/y', strtotime($lista[$i]['Data'])); ?></td>
                                
                                <!-- Hora -->
                                <td><?php echo date('H:i', strtotime($lista[$i]['Hora'])); ?></td>
                                
                                <!-- Funcionario -->
                                <td><?php echo $lista[$i]['Nome']; ?></td>
                                
                                <!-- Ações -->
                                <td>
                                    <a href="Detalhes.php?atendimento=<?php echo $lista[$i][0]; ?>" class="btn btn-primary btn-sm">Detalhes</a>
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



