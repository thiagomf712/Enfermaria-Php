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

        <title>Detalhes - paciente</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php require_once '../Compartilhado/Navbar.php'; ?>    

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            
            <input type="hidden" id="nivelAcessoAtivo" value="<?= $usuario->nivelAcesso ?>">
            
            <div class="col-md-10 offset-md-1">
                <form>

                    <!-- Informações gerais -->
                    <fieldset disabled>
                        <legend class="mb-4">Informações gerais do paciente</legend>

                        <div class="form-row">

                            <!-- Nome -->
                            <div class="form-group col-md-5 col-lg-6">
                                <label>Nome</label>
                                <input type="text" class="form-control" id="nome" value=""/>
                            </div>

                            <!-- Ra -->
                            <div class="form-group col-md-3">
                                <label>Ra</label>
                                <input type="number" class="form-control" id="ra" value=""/>
                            </div>

                            <!-- Data Nascimento -->
                            <div class="form-group col-md-4 col-lg-3">
                                <label >Data de nascimento</label>
                                <input type="date" class="form-control" id="dataNascimento" value=""/>
                            </div>  
                        </div>

                        <div class="form-row">

                            <!-- Email -->
                            <div class="form-group col-md">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email" value=""/>
                            </div>

                            <!-- Telefone -->
                            <div class="form-group col-md">
                                <label>Telefone</label>
                                <input type="tel" class="form-control" id="telefone" value=""/>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Ficha Média -->
                    <fieldset class="mt-4" disabled>
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

                    <!-- Endereço -->
                    <fieldset class="mt-4" disabled>
                        <legend class="mb-4">Endereço</legend>

                        <!-- Regime -->
                        <fieldset class="form-group">
                            <div class="form-row">
                                <legend class="col-form-label col-md-2 pt-0">Regime</legend>
                                <div class="col-sm-10">
                                    
                                    <!-- Interno -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="regime" id="interno" value="1">
                                        <label class="form-check-label" for="interno">Interno</label>
                                    </div>
                                    
                                    <!-- Externo -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="regime" id="externo" value="2">
                                        <label class="form-check-label" for="externo">Externo</label>
                                    </div>   
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-row">
                            
                            <!-- Rua -->
                            <div class="form-group col-md">
                                <label>Rua</label>
                                <input type="text" class="form-control" id="rua" value=""/>
                            </div>

                            <!-- Numero -->
                            <div class="form-group col-md-3">
                                <label>Numero</label>
                                <input type="number" class="form-control" id="numero" value=""/>
                            </div>
                        </div>             

                        <div class="form-row">
                            
                            <!-- Complemento -->
                            <div class="form-group col-md">
                                <label>Complemento</label>
                                <input type="text" class="form-control" id="complemento" value=""/>
                            </div>  

                            <!-- Cep -->
                            <div class="form-group col-md-4">
                                <label>CEP</label>
                                <input type="text" class="form-control" id="cep" value=""/>
                            </div>  
                        </div>  

                        <div class="form-row">
                            
                            <!-- bairo -->
                            <div class="form-group col-md">
                                <label>Bairro</label>
                                <input type="text" class="form-control" id="bairro" value=""/>
                            </div>

                            <!-- Cidade -->
                            <div class="form-group col-md">
                                <label>Cidade</label>
                                <input type="text" class="form-control" id="cidade" value=""/>
                            </div>

                            <!-- Estado -->
                            <div class="form-group col-md">
                                <label>Estado</label>
                                <input type="text" class="form-control" id="estado" value=""/>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Botões -->
                    <div class="form-group">
                        <a href="Listar.php" class="btn btn-secondary btn-block">Voltar</a>
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
        <script src="../../JavaScript/Paciente/detalhes.js"></script>   
    </body>
</html>

