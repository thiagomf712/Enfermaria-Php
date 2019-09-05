<?php 
    require_once '../ValidarLogin.php';
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

        <title>Editar - Usuario</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>    

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            
            <input type="hidden" id="nivelAcessoAtivo" value="<?= $usuario->nivelAcesso ?>">
            
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                <form class="needs-validation" novalidate>
                    <!-- Informações do usuario -->
                    <fieldset>
                        <legend class="mb-4">Informações do usuario</legend>

                        <!-- Senha -->
                        <div class="form-group">
                            <label for="senha">Nova Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha"/>
                        </div>

                        <!-- Confirmar Senha -->
                        <div class="form-group">
                            <label for="confirmarSenha">Digite a senha novamente</label>
                            <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha"/>
                        </div>
                    </fieldset>

                    <!-- Botões -->
                    <div class="form-row">
                        <div class="form-group col-sm mt-4">
                            <input class="btn btn-secondary btn-block" type="submit" value="Salvar alterações" />
                        </div>
                        <div class="form-group col-sm mt-sm-4"> 
                            <a href="Listar.php" class="btn btn-secondary btn-block">Cancelar</a>
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
        <script src="../../JavaScript/Usuario/editar.js"></script>  
    </body>
</html>