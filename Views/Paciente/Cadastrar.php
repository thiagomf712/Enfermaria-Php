<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');

session_start();

if(!isset($_SESSION['usuario'])) {
    header("Location: ../Usuario/Login.php");
}

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Cadastro - Paciente</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../Css/forms.css?version=14" /> 
        <link rel="stylesheet" href="../../Css/bootstrap.css" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    

    </head>
    <body>
        <?php include_once '../Compartilhado/Navbar.php'; ?>

        <div class="mx-auto p-4 formGeral form-grande">
            <form method="POST" action="../../Controllers/PacienteController.php" class="needs-validation" novalidate onsubmit="return ValidarForm()">
                <input type="hidden" name="metodoPaciente" value="Cadastrar"/>
                <fieldset>
                    <legend class="mb-4">Informações gerais do paciente</legend>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nome" >Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required maxlength="50" minlength="3"/>
                            <div class="invalid-feedback" id="erroNome"></div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="ra" >Ra</label>
                            <input type="number" class="form-control" id="ra" name="ra" required min="1"/>
                            <div class="invalid-feedback" id="erroRa"></div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="dataNascimento" >Data de nascimento</label>
                            <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" required/>
                            <div class="invalid-feedback" id="erroDataNascimento"></div>
                        </div>  
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="email" >Email</label>
                            <input type="email" class="form-control" id="email" name="email" maxlength="50"/>
                            <div class="invalid-feedback" id="erroEmail"></div>
                        </div>

                        <div class="form-group col-md">
                            <label for="telefone" >Telefone</label>
                            <input type="tel" class="form-control" id="telefone" name="telefone" pattern="[0-9]{2} [0-9]{5}-[0-9]{4}" aria-describedby="telefoneHelp"/>
                            <small id="telefoneHelp" class="form-text text-muted">Exemplo: 12 12345-1234</small>
                            <div class="invalid-feedback" id="erroTelefone"></div> 
                        </div>
                    </div>
                </fieldset>
                <fieldset class="mt-4">
                    <legend class="mb-4">Ficha Médica</legend>

                    <div class="form-group">
                        <label for="planoSaude" >Plano de saúde</label>
                        <input type="text" class="form-control" id="planoSaude" name="planoSaude" maxlength="100" placeholder="Deixa em branco se não possuir"/>
                    </div>

                    <div class="form-group">
                        <label for="problemaSaude" >Problemas de saúde</label>
                        <textarea class="form-control" id="problemaSaude" name="problemaSaude" rows="3" maxlength="100" placeholder="Deixa em branco se não possuir"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="medicamento" >Medicamentos de uso continuo</label>
                        <textarea class="form-control" id="medicamento" name="medicamento" rows="3" maxlength="100" placeholder="Deixa em branco se não fazer uso"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="alergia" >Alergias</label>
                        <textarea class="form-control" id="alergia" name="alergia" rows="3" maxlength="100" placeholder="Deixa em branco se não possuir"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="cirurgia" >Cirurgias realizadas</label>
                        <textarea class="form-control" id="cirurgia" name="cirurgia" rows="3" maxlength="100" placeholder="Deixa em branco se não realizou nenhuma"></textarea>
                    </div>       
                </fieldset>

                <fieldset class="mt-4">
                    <legend class="mb-4">Endereço</legend>

                    <fieldset class="form-group">
                        <div class="form-row">
                            <legend class="col-form-label col-md-2 pt-0">Regime</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="regime" id="interno" value="1" onchange="altEndereco(this)" checked>
                                    <label class="form-check-label" for="interno">Interno</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="regime" id="externo" value="2" onchange="altEndereco(this)" >
                                    <label class="form-check-label" for="externo">Externo</label>
                                </div>   
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="rua" >Rua</label>
                            <input type="text" class="form-control" id="rua" name="rua" maxlength="50" value="Estr. Mun. Pastor Walter Boger"/>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="numero" >Numero</label>
                            <input type="number" class="form-control" id="numero" name="numero" min="1" max="9999"/>
                            <div class="invalid-feedback" id="erroNumero"></div>
                        </div>
                    </div>             

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="complemento" >Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" maxlength="20"/>
                        </div>  
                        
                        <div class="form-group col-md-4">
                            <label for="cep" >CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" maxlength="9" pattern="[0-9]{5}-[0-9]{3}" aria-describedby="cepHelp" value="13445-970"/>
                            <small id="cepHelp" class="form-text text-muted">Exemplo: 12345-123</small>
                            <div class="invalid-feedback" id="erroCep"></div>
                        </div>  
                    </div>  
                    
                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="bairro" >Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" maxlength="50" value="Lagoa Bonita I"/>
                        </div>
                        
                        <div class="form-group col-md">
                            <label for="cidade" >Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" maxlength="50" value="Engenheiro Coelho"/>
                        </div>
                        
                        <div class="form-group col-md">
                            <label for="estado" >Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" maxlength="50" value="São Paulo"/>
                        </div>
                    </div>
                </fieldset>
                
                <div class="form-row">
                    <div class="form-group mt-4 col-md">
                        <input class="btn btn-primary btn-block btn-lg" type="submit" value="Cadastrar Paciente" />
                    </div>
                    <div class="form-group mt-4 col-md">
                        <a class="btn btn-primary btn-block btn-lg" href="../Geral/Home.php">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>  
      
        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?>
        
        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>   
        <script src="../../JavaScript/Paciente/cadastroPaciente.js?version=13"></script>  
    </body>
</html>