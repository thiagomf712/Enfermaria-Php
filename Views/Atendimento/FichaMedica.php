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

        <title>Ficha médica - Paciente</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php require_once '../Compartilhado/Navbar.php'; ?>    

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            
            <input type="hidden" id="nivelAcessoAtivo" value="<?= $usuario->nivelAcesso ?>">
            
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                <form>

                    <!-- Informações Paciente -->
                    <fieldset disabled>
                        <legend class="mb-4">Informações do paciente</legend>

                        <div class="form-row">

                            <!-- Nome -->
                            <div class="form-group col-md">
                                <label for="nome" >Nome</label>
                                <input type="text" class="form-control" id="nome"/>
                            </div>

                            <!-- Ra -->
                            <div class="form-group col-md">
                                <label for="ra" >Ra</label>
                                <input type="number" class="form-control" id="ra"/>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Ficha médica -->
                    <fieldset class="mt-4 mb-4" disabled>
                        <legend class="mb-4">Ficha Médica</legend>

                        <!-- Plano -->
                        <div class="form-group">
                            <label>Plano de saúde</label>
                            <input type="text" class="form-control" id="plano" value=""/>
                        </div>

                        <!-- Problemas -->
                        <div class="form-group">
                            <label>Problemas de saúde</label>
                            <textarea class="form-control" id="problema"></textarea>
                        </div>

                        <!-- Medicamento -->
                        <div class="form-group">
                            <label>Medicamentos de uso continuo</label>
                            <textarea class="form-control" id="medicamento"></textarea>
                        </div>

                        <!-- Alergia -->
                        <div class="form-group">
                            <label>Alergias</label>
                            <textarea class="form-control" id="alergia"></textarea>
                        </div>

                        <!-- Cirurgia -->
                        <div class="form-group">
                            <label>Cirurgias realizadas</label>
                            <textarea class="form-control" id="cirurgia"></textarea>
                        </div> 
                    </fieldset>

                    <!-- Bottão -->
                    <div class="form-group mt-4">
                        <a href="ListaPacientes.php" class="btn btn-secondary btn-block">Voltar</a>
                    </div>
                </form>
            </div>
        </div>       

        <!-- Rodapé -->    
        <?php require_once '../Compartilhado/Footer.php'; ?>

        <!-- Modal de resposta -->
        <?php require_once '../Compartilhado/ModalErro.php'; ?> 

        <!-- JQuery - popper - Bootstrap-->
        <script src="../../JavaScript/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="../../bootstrap/js/bootstrap.min.js"></script>  

        <!-- Scripts Personalizados -->
        <script src="../../JavaScript/Atendimento/fichamedica.js"></script>   
    </body>
</html>