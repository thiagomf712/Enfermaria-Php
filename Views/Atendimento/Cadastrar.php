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

        <title>Cadastro - Atendimento</title>
    </head>
    <body>

        <!-- Barra de navegação -->
        <?php require_once '../Compartilhado/Navbar.php'; ?>              

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            <div class="col-md-10 offset-md-1">
                <form class="needs-validation" novalidate>
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
                    <fieldset class="mt-4">
                        <legend class="mb-4">Informações do atendimento</legend>

                        <div class="form-row">
                            
                            <!--input para saber qual o id do usuario atual -->
                            <input id="usuarioAtual" type="hidden" value="<?= $usuario->id?>" disabled>
                            
                            <!-- Atendente -->
                            <div class="form-group col-md-5 col-lg-7">
                                <label for="atendente">Atendente</label>
                                <select class="form-control" id="atendente" name="atendente">
                                    
                                </select>
                            </div>

                            <!-- Hora -->
                            <div class="form-group col-md-3 col-lg-2">	
                                <label for="hora">Hora</label>
                                <input type="time" name="hora" id="hora" class="form-control" />
                            </div>

                            <!-- Data -->
                            <div class="form-group col-md-4 col-lg-3">	
                                <label for="data">Data</label>
                                <input class="form-control" type="date" name="data" id="data" />
                            </div>			
                        </div>
                    </fieldset>

                    <!-- Sintomas -->
                    <fieldset>
                        <legend class="mb-4">Sintomas e Sinais</legend>

                        <!-- Lista de sintomas -->
                        <div id="renderSintoma">
                        </div>

                        <!-- Botões sintomas -->
                        <div class="form-group float-sm-right">
                            <button class="btn btn-outline-info mt-2" type="button" id="adicionar">Adicionar</button>
                        </div>
                    </fieldset>

                    <!-- procedimento -->
                    <fieldset>
                        <legend class="mb-4">Procedimento</legend>

                        <!-- Procedimento -->
                        <div class="form-group">
                            <label for="procedimento" >Procedimento realizado</label>
                            <textarea class="form-control" id="procedimento" name="procedimento" rows="3"></textarea>
                        </div>
                    </fieldset>

                    <!-- Botões -->
                    <div class="form-row">
                        <div class="form-group mt-4 col-sm">
                            <input class="btn btn-secondary btn-block" type="submit" value="Cadastrar Atendimento" />
                        </div>
                        <div class="form-group mt-sm-4 col-sm">
                            <a class="btn btn-secondary btn-block" href="ListaPacientes.php">Cancelar</a>
                        </div>
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
        <script src="../../JavaScript/Atendimento/cadastro.js"></script>  
    </body>
</html>
