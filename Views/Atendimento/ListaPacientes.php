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

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Lista - Pacientes</title>
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
                <h2>Lista de Pacientes</h2>
            </header>

            <form action="../../Controllers/AtendimentoController.php" method="POST">
                <input type="hidden" name="metodoAtendimento" value="FiltrarPacientes"/>

                <div class="form-row">
                    <div class="form-group col-sm">
                        <label for="nome">Nome: </label>
                        <input class="form-control" type="text" id="nome" name="nome"/>
                    </div>    

                    <div class="form-group col-sm">
                        <label for="ra">Ra: </label>
                        <input class="form-control" type="number" id="ra" name="ra"/>
                    </div> 

                    <div class="form-group col-sm">
                        <label for="regime">Regime: </label>
                        <select class="form-control" id="regime" name="regime">
                            <option value="<?php echo Regime::Interno; ?>">Interno</option>
                            <option value="<?php echo Regime::Externo; ?>">Externo</option>
                            <option value="0" selected>Sem filtro</option>
                        </select>
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
                                <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltroPaciente' : 'OrdenarPaciente'; ?>"/>
                                <input type="hidden" name="coluna" value="p.Id"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "p.Id" && $ordem == "DESC") ? 'ASC' : 'DESC' ?>"/>
                                <button type="submit" class="border-0 bg-transparent">#</button>
                            </form>
                        </th>

                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltroPaciente' : 'OrdenarPaciente'; ?>"/>
                                <input type="hidden" name="coluna" value="p.Nome"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "p.Nome" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                <button type="submit" class="border-0 bg-transparent">Nome</button>
                            </form>
                        </th>

                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltroPaciente' : 'OrdenarPaciente'; ?>"/>
                                <input type="hidden" name="coluna" value="p.Ra"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "p.Ra" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                <button type="submit" class="border-0 bg-transparent">Ra</button>
                            </form>
                        </th>

                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/AtendimentoController.php">
                                <input type="hidden" name="metodoAtendimento" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltroPaciente' : 'OrdenarPaciente'; ?>"/>
                                <input type="hidden" name="coluna" value="e.Regime"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "e.Regime" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                <button type="submit" class="border-0 bg-transparent">Regime</button>
                            </form>
                        </th>

                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = $inicio; $i < $limite; $i++) : ?>
                        <tr class="table-dark">
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $lista[$i]['Nome']; ?></td>
                            <td><?php echo $lista[$i]['Ra']; ?></td>
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
                            <td>
                                <a href="Cadastrar.php?paciente=<?php echo $lista[$i]['PacienteId']; ?>&nome=<?php echo $lista[$i]['Nome']; ?>&ra=<?php echo $lista[$i]['Ra']; ?>" class="btn btn-primary btn-sm">Adicionar Atendimento</a>  
                                <a href="FichaMedica.php?paciente=<?php echo $lista[$i]['Nome']; ?>&ra=<?php echo $lista[$i]['Ra']; ?>&fichaMedica=<?php echo $lista[$i][1]; ?>" class="btn btn-primary btn-sm">Ficha medica</a>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table> 

            <?php include_once '../Compartilhado/Paginacao.php'; ?>
        </div>  

        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?>

        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>    
    </body>
</html>
