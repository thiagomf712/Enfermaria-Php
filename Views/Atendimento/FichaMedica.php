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

if(!isset($_SESSION['usuario'])) {
    header("Location: ../Usuario/Login.php");
}

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Ficha médica - Paciente</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../Css/forms.css" /> 
        <link rel="stylesheet" href="../../Css/bootstrap.css" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    

    </head>
    <body>
        <?php include_once '../Compartilhado/Navbar.php'; ?>    

        <div class="mx-auto p-4 formGeral form-grande">
            <form>
                <fieldset disabled>
                    <legend class="mb-4">Informações do paciente</legend>
                    
                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="nome" >Nome</label>
                            <input type="text" class="form-control" value="<?php echo $nome; ?>"/>
                        </div>

                        <div class="form-group col-md">
                            <label for="ra" >Ra</label>
                            <input type="number" class="form-control" value="<?php echo $ra; ?>"/>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mt-4 mb-4" disabled>
                    <legend class="mb-4">Ficha Médica</legend>
                    
                    <div class="form-group">
                        <label for="planoSaude" >Plano de saúde</label>s
                        <input type="text" class="form-control" value="<?php echo $fichaMedica->getPlanoSaude(); ?>"/>
                    </div>

                    <div class="form-group">
                        <label for="problemaSaude" >Problemas de saúde</label>
                        <textarea class="form-control" rows="3"><?php echo $fichaMedica->getProblemaSaude(); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="medicamento" >Medicamentos de uso continuo</label>
                        <textarea class="form-control" rows="3"><?php echo $fichaMedica->getMedicamento(); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="alergia" >Alergias</label>
                        <textarea class="form-control" rows="3"><?php echo $fichaMedica->getAlergia(); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="cirurgia" >Cirurgias realizadas</label>
                        <textarea class="form-control" rows="3"><?php echo $fichaMedica->getCirurgia(); ?></textarea>
                    </div>       
                </fieldset>

                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-block btn-lg" onclick="history.go(-1);">Voltar</button>
                </div>
            </form>
        </div>       

        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>  
    </body>
</html>