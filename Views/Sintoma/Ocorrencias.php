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

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Ocorrencias - Sintomas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../Css/forms.css" /> 
        <link rel="stylesheet" href="../../Css/bootstrap.css?version=12" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    

    </head>
    <body>     

        <div class="mx-auto p-4 formGeral listas">
            <header class="mb-4">
                <h2>Ocorrencias</h2>
            </header>

            <form>
                <fieldset disabled>
                    <div class="form-row">     
                        <div class="form-group col-sm">
                            <label for="sintoma">Sintoma: </label>
                            <input class="form-control" type="text" id="sintoma" name="sintoma" value="<?php echo $sintomaNome; ?>"/>
                        </div> 

                        <div class="form-group col-sm">
                            <label for="inicio">Data Inicial: </label>
                            <input class="form-control" type="date" id="inicio" name="inicio" value="<?php echo (isset($_GET['inicio'])) ? $Datainicio : null; ?>"/>
                        </div>    

                        <div class="form-group col-sm">
                            <label for="fim">Data Final: </label>
                            <input class="form-control" type="date" id="fim" name="fim" value="<?php echo (isset($_GET['fim'])) ? $Datafim : null; ?>"/>
                        </div> 
                    </div>
                </fieldset>
                
                <button type="button" class="btn btn-primary mb-3 float-right" onclick="history.go(-1);">Voltar para a lista de sintomas</button>
            </form>

            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <?php
                        $filtro = (isset($_SESSION['coluna'])) ? $_SESSION['coluna'] : '';
                        $ordem = (isset($_SESSION['estado'])) ? $_SESSION['estado'] : '';
                        ?>
                        <th scope="col">#</th>

                        <th scope="col">Paciente</th>

                        <th scope="col">Data</th>

                        <th scope="col">Hora</th>

                        <th scope="col">Funcionario</th>

                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = $inicio; $i < $limite; $i++) : ?>
                        <tr class="table-dark">
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $lista[$i]['pNome']; ?></td>
                            <td><?php echo date('d/m/y', strtotime($lista[$i]['Data'])); ?></td>
                            <td><?php echo date('H:i', strtotime($lista[$i]['Hora'])); ?></td>
                            <td><?php echo $lista[$i]['fNome']; ?></td>
                            <td>
                                <a href="../Atendimento/Detalhes.php?atendimento=<?php echo $lista[$i][0]; ?>" class="btn btn-primary btn-sm">Detalhes</a>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table> 

            <?php include_once '../Compartilhado/Paginacao.php'; ?>
        </div>  

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>    
    </body>
</html>

