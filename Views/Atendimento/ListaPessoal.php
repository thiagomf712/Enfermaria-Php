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

if(!isset($_SESSION['usuario'])) {
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
        <title>Lista - Atendimentos</title>
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
                <h2>Lista de Atendimentos</h2>
            </header>

            <form action="../../Controllers/AtendimentoController.php" method="POST">
                <input type="hidden" name="metodoAtendimento" value="Filtrar"/>

                <input type="hidden" name="pacienteId" value="<?php echo $pacienteId; ?>"/>
                
                <div class="form-row">     
                    <div class="form-group col-sm">
                        <label for="funcionario">Funcionario: </label>
                        <input class="form-control" type="text" id="funcionario" name="funcionario"/>
                    </div> 
                    
                    <div class="form-group col-sm">
                        <label for="inicio">Data Inicial: </label>
                        <input class="form-control" type="date" id="inicio" name="inicio"/>
                    </div>    

                    <div class="form-group col-sm">
                        <label for="fim">Data Final: </label>
                        <input class="form-control" type="date" id="fim" name="fim"/>
                    </div> 
                </div>

                <div class="form-group float-right">
                    <button class="btn btn-primary mr-2" type="submit" name="remover">Procurar</button>
                    <button class="btn btn-primary " type="button" name="remover" onclick="location.reload();">Remover Filtro</button>
                </div>
            </form>

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

            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <?php
                        $filtro = (isset($_SESSION['coluna'])) ? $_SESSION['coluna'] : '';
                        $ordem = (isset($_SESSION['estado'])) ? $_SESSION['estado'] : '';
                        ?>
                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltro' : 'Ordenar'; ?>"/>
                                <input type="hidden" name="coluna" value="a.Id"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "a.Id" && $ordem == "DESC") ? 'ASC' : 'DESC' ?>"/>
                                <input type="hidden" name="pacienteId" value="<?php echo $pacienteId; ?>"/>
                                <button type="submit" class="border-0 bg-transparent">#</button>
                            </form>
                        </th>

                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltro' : 'Ordenar'; ?>"/>
                                <input type="hidden" name="coluna" value="a.Data"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "a.Data" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                <input type="hidden" name="pacienteId" value="<?php echo $pacienteId; ?>"/>
                                <button type="submit" class="border-0 bg-transparent">Data</button>
                            </form>
                        </th>

                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltro' : 'Ordenar'; ?>"/>
                                <input type="hidden" name="coluna" value="a.Hora"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "a.Hora" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                <input type="hidden" name="pacienteId" value="<?php echo $pacienteId; ?>"/>
                                <button type="submit" class="border-0 bg-transparent">Hora</button>
                            </form>
                        </th>

                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltro' : 'Ordenar'; ?>"/>
                                <input type="hidden" name="coluna" value="f.Nome"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "f.Nome" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                <input type="hidden" name="pacienteId" value="<?php echo $pacienteId; ?>"/>
                                <button type="submit" class="border-0 bg-transparent">Funcionario</button>
                            </form>
                        </th>

                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = $inicio; $i < $limite; $i++) : ?>
                        <tr class="table-dark">
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo date('d/m/y', strtotime($lista[$i]['Data'])); ?></td>
                            <td><?php echo date('H:i', strtotime($lista[$i]['Hora'])); ?></td>
                            <td><?php echo $lista[$i]['Nome']; ?></td>
                            <td>
                                <a href="Detalhes.php?atendimento=<?php echo $lista[$i][0]; ?>" class="btn btn-primary btn-sm">Detalhes</a>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table> 

            <?php include_once '../Compartilhado/Paginacao.php'; ?>
        </div>  

        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>    
    </body>
</html>



