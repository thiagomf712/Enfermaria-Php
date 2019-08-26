<?php
define('__ROOT__', dirname(__FILE__, 3));

require_once(__ROOT__ . '/Models/Enums/NivelAcesso.php');
?>

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

        <title>Cadastrar - Funcionario</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php require_once '../Compartilhado/Navbar.php'; ?>              

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                <form method="POST" action="" class="needs-validation" novalidate>
                    <!-- Informações do funcionario -->
                    <fieldset>
                        <legend class="mb-4">Informações do funcionario</legend>

                        <!-- nome -->
                        <div class="form-group">
                            <label for="nome" >Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required maxlength="50" minlength="3"/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </fieldset>

                    <!-- Informações do usuario -->
                    <fieldset class="mt-4">
                        <legend class="mb-4">Informações do usuario</legend>

                        <!-- Usuario -->
                        <div class="form-group">
                            <label for="login" >Usuario</label>
                            <input type="text" class="form-control" id="login" name="login" required maxlength="20" minlength="4"/>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Senha -->
                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required maxlength="20" minlength="4"/>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Confirmar Senha -->
                        <div class="form-group">
                            <label for="confirmarSenha">Digite a senha novamente</label>
                            <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" required maxlength="20" minlength="4"/>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Nivel Acesso -->
                        <div class="form-group">
                            <label for="nivelAcesso">Nivel de acesso</label>
                            <select class="form-control" id="nivelAcesso" name="nivelAcesso">
                                <option value="<?php echo NivelAcesso::Vizualizar; ?>">Visualizar</option>
                                <option value="<?php echo NivelAcesso::Adicionar; ?>">Adicionar</option>
                                <option value="<?php echo NivelAcesso::Editar; ?>">Editar / Remover</option>
                                <option value="<?php echo NivelAcesso::Master; ?>">Master</option>
                            </select>
                        </div>
                    </fieldset>

                    <!-- Botões -->
                    <div class="form-row">
                        <div class="form-group mt-4 col-sm">
                            <input class="btn btn-secondary btn-block" type="submit" value="Cadastrar Funcionario" />
                        </div>
                        <div class="form-group mt-sm-4 col-sm">
                            <a class="btn btn-secondary btn-block" href="../Geral/Home.php">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>  

        <!-- Rodapé -->    
        <?php include_once '../Compartilhado/Footer.php'; ?>
        
        
        <?php include_once '../Compartilhado/ModalErro.php'; ?> 
        
        <!-- JQuery - popper - Bootstrap-->
        <script src="../../JavaScript/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="../../bootstrap/js/bootstrap.min.js"></script> 

        <!-- Scripts Personalizados (formularios deve vir primeiro para a validação do form) -->
        <script src="../../JavaScript/Geral/formularios.js"></script>
        <script src="../../JavaScript/Funcionario/cadastroFuncionario.js"></script>  
    </body>
</html>
