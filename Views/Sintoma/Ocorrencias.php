<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');
require_once(__ROOT__ . '/Models/Enums/NivelAcesso.php');
require_once(__ROOT__ . '/Models/Enums/Regime.php');

require_once(__ROOT__ . '/Controllers/SintomaController.php');

if (session_id() == '') {
    session_start();
}


$sintomaId = isset($_GET['sintomaId']) ? $_GET['sintomaId'] : null;
$sintomaNome = isset($_GET['sintomaNome']) ? $_GET['sintomaNome'] : null;
$Datainicio = isset($_GET['inicio']) ? $_GET['inicio'] : null;
$Datafim = isset($_GET['fim']) ? $_GET['fim'] : null;

$lista = SintomaController::ListarOcorrencias($sintomaId, $Datainicio, $Datafim);

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

        <title>Ocorrencias - Sintomas</title>
    </head>
    <body>     
        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>    

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">

            <!-- Titulo -->
            <header class="mb-4">
                <h2>Ocorrencias</h2>
            </header>

            <!-- Formulario de filtro (readonly)-->
            <form class="mb-3 clearfix">
                <fieldset disabled>
                    <div class="form-row">   

                        <!-- Sintoma -->
                        <div class="form-group col-sm">
                            <label for="sintoma">Sintoma: </label>
                            <input class="form-control" type="text" id="sintoma" name="sintoma" value="<?php echo $sintomaNome; ?>"/>
                        </div> 

                        <!-- Data Inicial -->
                        <div class="form-group col-sm">
                            <label for="inicio">Data Inicial: </label>
                            <input class="form-control" type="date" id="inicio" name="inicio" value="<?php echo (isset($_GET['inicio'])) ? $Datainicio : null; ?>"/>
                        </div>    

                        <!-- Data final -->
                        <div class="form-group col-sm">
                            <label for="fim">Data Final: </label>
                            <input class="form-control" type="date" id="fim" name="fim" value="<?php echo (isset($_GET['fim'])) ? $Datafim : null; ?>"/>
                        </div> 
                    </div>
                </fieldset>

                <!-- Botão -->
                <button type="button" class="btn btn-secondary float-sm-right" onclick="history.go(-1);">Voltar para a lista de sintomas</button>
            </form>

            <!-- Tabela -->
            <div class="table-responsive">
                <table class="table table-hover">

                    <!-- Cabeça -->
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>

                            <th scope="col">Paciente</th>

                            <th scope="col">Data</th>

                            <th scope="col">Hora</th>

                            <th scope="col">Funcionario</th>

                            <th scope="col">Ações</th>
                        </tr>
                    </thead>

                    <!-- Corpo -->
                    <tbody>
                        <?php for ($i = $inicio; $i < $limite; $i++) : ?>
                            <tr class="table-light">

                                <!-- Numeração -->
                                <td><?php echo $i + 1; ?></td>

                                <!-- Paciente -->
                                <td><?php echo $lista[$i]['pNome']; ?></td>

                                <!-- Data -->
                                <td><?php echo date('d/m/y', strtotime($lista[$i]['Data'])); ?></td>

                                <!-- Hora -->
                                <td><?php echo date('H:i', strtotime($lista[$i]['Hora'])); ?></td>

                                <!-- Funcionario -->
                                <td><?php echo $lista[$i]['fNome']; ?></td>

                                <!-- Ações -->
                                <td>
                                    <a href="../Atendimento/Detalhes.php?atendimento=<?php echo $lista[$i][0]; ?>" class="btn btn-primary btn-sm">Detalhes</a>
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

        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>     
    </body>
</html>

