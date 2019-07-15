<?php
require_once '../../Models/Usuario.php';

session_start();

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro - Funcionarios</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../Css/forms.css?version=12" /> 
        <link rel="stylesheet" href="../../Css/bootstrap.css" />   
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    

    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary">
            <a class="navbar-brand mb-0 h1" href="../Menu.php">Enfermaria</a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarItens" aria-controls="navbarItens" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarItens" style="">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <!--NA = 1 :: Atendimento pessoal-->
                        <!--NA >= 2 :: lista com todos os atendimentos-->
                        <a class="nav-link" href="#">Atendimento</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Paciente</a>
                        <div class="dropdown-menu">
                            <?php if ($usuario->getNivelAcesso() == 1) : ?>
                                <a class="dropdown-item" href="#">Informações pessoais</a>                    
                            <?php elseif ($usuario->getNivelAcesso() >= 2) : ?>
                                <a class="dropdown-item" href="#">Lista de pacientes</a>
                                <a class="dropdown-item" href="#">Cadastrar novo paciente</a>                           
                            <?php endif; ?>
                        </div>         
                    </li>
                    <?php if ($usuario->getNivelAcesso() >= 3) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Sintoma</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Lista de sitomas</a>
                                <a class="dropdown-item" href="#">Cadastrar novo sintoma</a>
                            </div>         
                        </li>
                    <?php endif; ?>
                    <?php if ($usuario->getNivelAcesso() == 4) : ?>    
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Funcionario</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Lista de funcionarios</a>
                                <a class="dropdown-item" href="#">Cadastrar novo funcionario</a>
                            </div>         
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Usuario</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Lista de usuarios</a>
                                <a class="dropdown-item" href="#">Cadastrar novo usuario</a>
                            </div>         
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../Usuario/Login.php">Sair</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="mx-auto p-4 formGeral" id="funcionarioCadastro">
            <form method="POST" action="../../Controllers/FuncionarioController.php" class="needs-validation" novalidate onsubmit="return ValidarForm('nome', 'login', 'senha', 'confirmarSenha')">
                <input type="hidden" name="metodo2" value="Cadastrar"/>
                <fieldset>
                    <div class="form-group">
                        <legend class="mb-4">Informações do funcionario</legend>
                        <label for="nome" >Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required maxlength="50" minlength="3"/>
                        <div class="invalid-feedback" id="erroNome"></div>
                    </div>
                </fieldset>
                <fieldset class="mt-4">
                    <legend class="mb-4">Informações do usuario</legend>

                    <div class="form-group">
                        <label for="login" >Usuario</label>
                        <input type="text" class="form-control" id="login" name="login" required maxlength="20" minlength="4"/>
                        <div class="invalid-feedback" id="erroLogin"></div>
                    </div>

                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required maxlength="20" minlength="4"/>
                        <div class="invalid-feedback" id="erroSenha"></div>
                    </div>

                    <div class="form-group">
                        <label for="confirmarSenha">Digite a senha novamente</label>
                        <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" required maxlength="20" minlength="4"/>
                        <div class="invalid-feedback" id="erroConfirmarSenha"></div>
                    </div>

                    <div class="form-group">
                        <label for="nivelAcesso">Nivel de acesso</label>
                        <select class="form-control" id="nivelAcesso" name="nivelAcesso">
                            <option value="1">Visualizar</option>
                            <option value="2">Adicionar</option>
                            <option value="3">Editar / Remover</option>
                            <option value="4">Master</option>
                        </select>
                    </div>
                </fieldset>

                <div class="form-row">
                    <div class="form-group mt-4 col-md">
                        <input class="btn btn-primary btn-block btn-lg" type="submit" value="Cadastrar Funcionario" />
                    </div>
                    <div class="form-group mt-4 col-md">
                        <a class="btn btn-primary btn-block btn-lg" href="../Menu.php">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>  

        <?php include_once '../Compartilhado/Footer.php'; ?>

        <?php if (isset($_SESSION['erro'])) : ?>
            <script>
                $(document).ready(function () {
                    $("#modal").modal();
                });
            </script>
        <?php endif; ?>

        <div class="modal fade" id="modal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger p-2">
                        <h5 class="modal-title">Erro</h5>
                    </div>
                    <div class="modal-body">
                        <p>
                            <?php
                            echo $_SESSION['erro'];
                            unset($_SESSION['erro']);
                            ?>
                        </p>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="../../JavaScript/bootstrap.js"></script>
        <script src="../../JavaScript/bootstrapValidation.js"></script>   
        <script src="../../JavaScript/cadastroFuncionario.js?version=12"></script>  
    </body>
</html>
