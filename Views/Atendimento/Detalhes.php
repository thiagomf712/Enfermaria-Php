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

        <title>Detalhes - Atendimento</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php require_once '../Compartilhado/Navbar.php'; ?>    

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            <div class="col-md-10 offset-md-1">
                <form>

                    <!-- Informações do paciente -->
                    <fieldset disabled>
                        <legend class="mb-4">Informações do paciente</legend>

                        <div class="form-row">

                            <!-- Nome -->
                            <div class="form-group col-md">
                                <label>Nome</label>
                                <input type="text" class="form-control" id="nome"/>
                            </div>

                            <!-- Ra -->
                            <div class="form-group col-md">
                                <label>Ra</label>
                                <input type="number" class="form-control" id="ra"/>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Informações Atendimento -->
                    <fieldset class="mt-4" disabled>
                        <legend class="mb-4">Informações do atendimento</legend>

                        <div class="form-row">

                            <!-- Atendente -->
                            <div class="form-group col-md-5 col-lg-7">
                                <label>Atendente</label>
                                <select class="form-control" id="atendente">
                                </select>
                            </div>

                            <!-- Hora -->
                            <div class="form-group col-md-3 col-lg-2">	
                                <label>Hora</label>
                                <input class="form-control" type="time" id="hora"/>
                            </div>

                            <!-- Data -->
                            <div class="form-group col-md-4 col-lg-3">	
                                <label>Data</label>
                                <input class="form-control" type="date" id="data"/>
                            </div>			
                        </div>
                    </fieldset>

                    <!-- Sintomas -->
                    <fieldset disabled>
                        <legend class="mb-4">Sintomas e Sinais</legend>

                        <!-- Lista de sintomas -->
                        <div id="renderSintoma">

                        </div>
                    </fieldset>

                    <!-- procedimento -->
                    <fieldset disabled>
                        <legend class="mb-4">Procedimento</legend>

                        <!-- Procedimento -->
                        <div class="form-group">
                            <label>Procedimento realizado</label>
                            <textarea class="form-control" id="procedimento"></textarea>
                        </div>

                    </fieldset>

                    <!-- Botões -->
                    <div class="form- mt-4">
                        <button type="button" class="btn btn-secondary btn-block" onclick="history.back()">Voltar</button>
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
        <script src="../../JavaScript/Atendimento/detalhes.js"></script>   
    </body>
</html>



