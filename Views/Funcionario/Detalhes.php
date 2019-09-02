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
        
        <title>Detalhes - Funcionario</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php require_once '../Compartilhado/Navbar.php'; ?>    

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                <form>       
                    <!-- Informações do funcionario -->
                    <fieldset disabled>
                        <legend class="mb-4">Informações do funcionario</legend>

                        <!-- nome -->
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" class="form-control" id="nome" value=""/>
                        </div>
                    </fieldset>
                    
                    <!-- Informações do usuario -->
                    <fieldset class="mt-4" disabled>
                        <legend class="mb-4">Informações do usuario</legend>

                        <!-- Usuario -->
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" class="form-control" id="login" value=""/>
                        </div>

                        <!-- Nivel Acesso -->
                        <div class="form-group">
                            <label>Nivel de acesso</label>
                            <select class="form-control" id="nivelAcesso">
                                <option value="<?= NivelAcesso::Vizualizar ?>">Visualizar</option>
                                <option value="<?= NivelAcesso::Adicionar ?>">Adicionar</option>
                                <option value="<?= NivelAcesso::Editar ?>">Editar / Remover</option>
                                <option value="<?= NivelAcesso::Master ?>">Master</option>
                            </select>
                        </div>
                    </fieldset>

                    <!-- Botões -->
                    <div class="form-group mt-4">
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
        <script src="../../JavaScript/Funcionario/detalhes.js"></script>  
    </body>
</html>