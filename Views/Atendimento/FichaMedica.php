<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');
require_once(__ROOT__ . '/Models/Enums/Regime.php');

require_once(__ROOT__ . '/Controllers/AtendimentoController.php');

if (session_id() == '') {
    session_start();
}

$nome = isset($_GET['paciente']) ? $_GET['paciente'] : '';
$ra = isset($_GET['ra']) ? $_GET['ra'] : 0;
$id = isset($_GET['fichaMedica']) ? $_GET['fichaMedica'] : 0;

$fichaMedica = AtendimentoController::RetornarFichaMedica($id);

if (!isset($_SESSION['usuario'])) {
    header("Location: ../Usuario/Login.php");
}

$usuario = unserialize($_SESSION['usuario']);
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
        <link rel="stylesheet" href="../../Css/estilo.css?version=12">

        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <title>Ficha médica - Paciente</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>    

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                <form>
                    
                    <!-- Informações Paciente -->
                    <fieldset disabled>
                        <legend class="mb-4">Informações do paciente</legend>

                        <div class="form-row">
                            
                            <!-- Nome -->
                            <div class="form-group col-md">
                                <label for="nome" >Nome</label>
                                <input type="text" class="form-control" value="<?php echo $nome; ?>"/>
                            </div>
                          
                            <!-- Ra -->
                            <div class="form-group col-md">
                                <label for="ra" >Ra</label>
                                <input type="number" class="form-control" value="<?php echo $ra; ?>"/>
                            </div>
                        </div>
                    </fieldset>
                    
                    <!-- Ficha médica -->
                    <fieldset class="mt-4 mb-4" disabled>
                        <legend class="mb-4">Ficha Médica</legend>

                        <!-- Plano -->
                        <div class="form-group">
                            <label for="planoSaude" >Plano de saúde</label>s
                            <input type="text" class="form-control" value="<?php echo $fichaMedica->getPlanoSaude(); ?>"/>
                        </div>

                        <!-- problemas -->
                        <div class="form-group">
                            <label for="problemaSaude" >Problemas de saúde</label>
                            <textarea class="form-control" rows="3"><?php echo $fichaMedica->getProblemaSaude(); ?></textarea>
                        </div>

                        <!-- medicamento -->
                        <div class="form-group">
                            <label for="medicamento" >Medicamentos de uso continuo</label>
                            <textarea class="form-control" rows="3"><?php echo $fichaMedica->getMedicamento(); ?></textarea>
                        </div>

                        <!-- Alergia -->
                        <div class="form-group">
                            <label for="alergia" >Alergias</label>
                            <textarea class="form-control" rows="3"><?php echo $fichaMedica->getAlergia(); ?></textarea>
                        </div>

                        <!-- Cirurgia -->
                        <div class="form-group">
                            <label for="cirurgia" >Cirurgias realizadas</label>
                            <textarea class="form-control" rows="3"><?php echo $fichaMedica->getCirurgia(); ?></textarea>
                        </div>       
                    </fieldset>

                    <!-- Bottão -->
                    <div class="form-group mt-4">
                        <button type="button" class="btn btn-secondary btn-block" onclick="history.go(-1);">Voltar</button>
                    </div>
                </form>
            </div>
        </div>       

        <!-- Rodapé -->    
        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script> 
    </body>
</html>