<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');
require_once(__ROOT__ . '/Models/Enums/NivelAcesso.php');
require_once(__ROOT__ . '/Models/Enums/Regime.php');

require_once(__ROOT__ . '/Controllers/PacienteController.php');

if (session_id() == '') {
    session_start();
}

$lista = (isset($_SESSION['ordenado'])) ? unserialize($_SESSION['ordenado']) : PacienteController::Listar();
//O Id da ficha medica ficou na posição 1 do vetor

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

            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <?php
                        $filtro = (isset($_SESSION['coluna'])) ? $_SESSION['coluna'] : '';
                        $ordem = (isset($_SESSION['estado'])) ? $_SESSION['estado'] : '';
                        ?>
                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/PacienteController.php">
                                <input type="hidden" name="metodoPaciente" value="Ordenar"/>
                                <input type="hidden" name="coluna" value="p.Id"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "p.Id" && $ordem == "DESC") ? 'ASC' : 'DESC' ?>"/>
                                <button type="submit" class="border-0 bg-transparent">#</button>
                            </form>
                        </th>

                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/PacienteController.php">
                                <input type="hidden" name="metodoPaciente" value="Ordenar"/>
                                <input type="hidden" name="coluna" value="p.Nome"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "p.Nome" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                <button type="submit" class="border-0 bg-transparent">Nome</button>
                            </form>
                        </th>

                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/PacienteController.php">
                                <input type="hidden" name="metodoPaciente" value="Ordenar"/>
                                <input type="hidden" name="coluna" value="p.Ra"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "p.Ra" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                <button type="submit" class="border-0 bg-transparent">Ra</button>
                            </form>
                        </th>

                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/PacienteController.php">
                                <input type="hidden" name="metodoPaciente" value="Ordenar"/>
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
                                <a href="Detalhes.php?paciente=<?php echo $lista[$i]['PacienteId']; ?>&endereco=<?php echo $lista[$i]['Id']; ?>&fichaMedica=<?php echo $lista[$i][1]; ?>" class="btn btn-primary btn-sm">Detalhes</a>
                                <?php if ($usuario->getNivelAcesso() >= NivelAcesso::Editar) : ?>
                                    <a href="Editar.php?paciente=<?php echo $lista[$i]['PacienteId']; ?>&endereco=<?php echo $lista[$i]['Id']; ?>&fichaMedica=<?php echo $lista[$i][1]; ?>" class="btn btn-primary btn-sm">Editar</a>                     
                                    <button type="submit" class="btn btn-primary btn-sm" form="<?php echo 'index' . $i; ?>">Excluir</button> 
                                    <form method="GET" id="<?php echo 'index' . $i; ?>">
                                        <input type="hidden" name="i" value="<?php echo $i; ?>" />                                   
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table> 

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

        <div class="modal fade" id="modalAlerta">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning p-2">
                        <h5 class="modal-title">Atenção</h5>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que quer deletar o paciente <strong><?php echo $lista[$index]['Nome']; ?> </strong></p>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="submit" class="btn btn-primary" form="Deletar">Deletar</button>

                        <form method="POST" id="Deletar" action="../../Controllers/PacienteController.php">
                            <input type="hidden" name="metodoPaciente" value="Deletar"/>
                            <input type="hidden" name="pacienteId" value="<?php echo $lista[$index]['PacienteId']; ?>" />   
                            <input type="hidden" name="usuarioId" value="<?php echo $lista[$index]['UsuarioId']; ?>" />
                            <input type="hidden" name="enderecoId" value="<?php echo $lista[$index]['Id']; ?>" />
                            <input type="hidden" name="fichaMedicaId" value="<?php echo $lista[$index][1]; ?>" />
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
