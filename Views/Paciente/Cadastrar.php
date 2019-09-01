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

        <title>Cadastro - paciente</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php require_once '../Compartilhado/Navbar.php'; ?>

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            <div class="col-md-10 offset-md-1">
                <form class="needs-validation" novalidate>          
                    <!-- Informações gerais -->
                    <fieldset>
                        <legend class="mb-4">Informações gerais do paciente</legend>

                        <div class="form-row">
                            
                            <!-- Nome -->
                            <div class="form-group col-md-5 col-lg-6">
                                <label for="nome" >Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome"/>
                            </div>

                            <!-- Ra -->
                            <div class="form-group col-md-3">
                                <label for="ra" >Ra</label>
                                <input type="number" class="form-control" id="ra" name="ra"/>
                            </div>  

                            <!-- Data Nascimento -->
                            <div class="form-group col-md-4 col-lg-3">
                                <label for="dataNascimento" >Data de nascimento</label>
                                <input type="date" class="form-control" id="dataNascimento" name="dataNascimento"/>
                            </div>  
                        </div>

                        <div class="form-row">
                            
                            <!-- Email -->
                            <div class="form-group col-md">
                                <label for="email" >Email</label>
                                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"/>
                                <small id="emailHelp" class="form-text text-muted">Exemplo: exemplo@email.com</small>
                            </div>

                            <!-- Telefone -->
                            <div class="form-group col-md">
                                <label for="telefone" >Telefone</label>
                                <input type="tel" class="form-control" id="telefone" name="telefone" aria-describedby="telefoneHelp"/>
                                <small id="telefoneHelp" class="form-text text-muted">Exemplo: (12) 12345-1234</small>
                            </div>
                        </div>
                    </fieldset>
                    
                    <!-- Ficha Médica -->
                    <fieldset class="mt-4">
                        <legend class="mb-4">Ficha Médica</legend>

                        <!-- plano -->
                        <div class="form-group">
                            <label for="planoSaude" >Plano de saúde</label>
                            <input type="text" class="form-control" id="planoSaude" name="planoSaude" placeholder="Deixa em branco se não possuir"/>
                        </div>

                        <!-- problema -->
                        <div class="form-group">
                            <label for="problemaSaude" >Problemas de saúde</label>
                            <textarea class="form-control" id="problemaSaude" name="problemaSaude" rows="3" placeholder="Deixa em branco se não possuir"></textarea>
                        </div>

                        <!-- medicamento -->
                        <div class="form-group">
                            <label for="medicamento" >Medicamentos de uso continuo</label>
                            <textarea class="form-control" id="medicamento" name="medicamento" rows="3" placeholder="Deixa em branco se não fazer uso"></textarea>
                        </div>

                        <!-- Alergia -->
                        <div class="form-group">
                            <label for="alergia" >Alergias</label>
                            <textarea class="form-control" id="alergia" name="alergia" rows="3" placeholder="Deixa em branco se não possuir"></textarea>
                        </div>

                        <!-- Cirurgia -->
                        <div class="form-group">
                            <label for="cirurgia" >Cirurgias realizadas</label>
                            <textarea class="form-control" id="cirurgia" name="cirurgia" rows="3" placeholder="Deixa em branco se não realizou nenhuma"></textarea>
                        </div>       
                    </fieldset>

                    <!-- Endereço -->
                    <fieldset class="mt-4">
                        <legend class="mb-4">Endereço</legend>

                        <!-- Regime -->
                        <fieldset class="form-group">
                            <div class="form-row">
                                <legend class="col-form-label col-md-2 pt-0">Regime</legend>
                                <div class="col-sm-10">
                                    
                                    <!-- Interno -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="regime" id="interno" value="1" checked>
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
                                <label for="rua" >Rua</label>
                                <input type="text" class="form-control" id="rua" name="rua" value="Estr. Mun. Pastor Walter Boger"/>
                            </div>

                            <!-- Numero -->
                            <div class="form-group col-md-3">
                                <label for="numero" >Numero</label>
                                <input type="number" class="form-control" id="numero" name="numero"/>
                            </div>
                        </div>             

                        <div class="form-row">
                            
                            <!-- Complemento -->
                            <div class="form-group col-md">
                                <label for="complemento" >Complemento</label>
                                <input type="text" class="form-control" id="complemento" name="complemento"/>
                            </div>  

                            <!-- Cep -->
                            <div class="form-group col-md-4">
                                <label for="cep" >CEP</label>
                                <input type="text" class="form-control" id="cep" name="cep" aria-describedby="cepHelp" value="13445-970"/>
                                <small id="cepHelp" class="form-text text-muted">Exemplo: 12345-123</small>
                            </div>  
                        </div>  

                        <div class="form-row">
                            
                            <!-- bairo -->
                            <div class="form-group col-md">
                                <label for="bairro" >Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" value="Lagoa Bonita I"/>
                            </div>

                            <!-- Cidade -->
                            <div class="form-group col-md">
                                <label for="cidade" >Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" value="Engenheiro Coelho"/>
                            </div>

                            <!-- Estado -->
                            <div class="form-group col-md">
                                <label for="estado" >Estado</label>
                                <input type="text" class="form-control" id="estado" name="estado" value="São Paulo"/>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Botões -->
                    <div class="form-row">
                        <div class="form-group mt-4 col-sm">
                            <input class="btn btn-secondary btn-block" type="submit" value="Cadastrar Paciente" />
                        </div>
                        <div class="form-group mt-sm-4 col-sm">
                            <a class="btn btn-secondary btn-block" href="../Geral/Home.php">Cancelar</a>
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
        <script src="../../JavaScript/Paciente/cadastro.js"></script>  
    </body>
</html>