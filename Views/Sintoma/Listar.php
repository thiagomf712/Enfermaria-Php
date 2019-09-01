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

        <title>Lista - Sintomas</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php require_once '../Compartilhado/Navbar.php'; ?>              

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">

            <!-- Titulo -->
            <header class="mb-4">
                <h2>Lista de sintoma</h2>
            </header>

            <!-- Formulario de filtro -->
            <form id="filtro" class="mb-3 clearfix">
                <!-- Filtro Nome -->
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input class="form-control" type="text" id="nome" name="Nome"/>
                </div>       

                <!-- Botões -->
                <div class="float-sm-right">
                    <button class="btn btn-secondary" type="submit">Procurar</button>
                    <button class="btn btn-secondary" type="button" id="remover">Remover Filtro</button>
                </div>            
            </form>

            <!-- Quantidade de resultados -->
            <div class="my-2">
                <span id="quantidade"></span> resultados 
            </div>

            <!-- Tabela -->
            <div class="table-responsive">
                <table class="table table-hover">

                    <!-- Header da tabela -->
                    <thead class="thead-light">
                        <tr>
                            <!-- Ordenar Id -->
                            <th scope="col">
                                <span>#</span> 
                                <i class="fas fa-sort"></i>
                                <button id="order-id" type="submit" value="ordenado"></button>
                            </th>

                            <!-- Ordenar Nome -->
                            <th scope="col">
                                <span>Nome</span> 
                                <i class="fas fa-sort"></i>
                                <button id="order-nome" type="submit"></button>
                            </th>

                            <!-- Açoes -->
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>

                    <!-- Corpo da tabela -->
                    <tbody>
                        
                    </tbody>
                </table> 
            </div>

            <!-- Paginação -->
            <?php require_once '../Compartilhado/Paginacao.php'; ?>
        </div>  

         <!-- Rodapé -->    
        <?php require_once '../Compartilhado/Footer.php'; ?>

        <!-- Modal de resposta -->
        <?php require_once '../Compartilhado/ModalErro.php'; ?> 
        
        <!-- Modal de alerta -->
        <?php require_once '../Compartilhado/ModalAlerta.php'; ?> 

        <!-- JQuery - popper - Bootstrap-->
        <script src="../../JavaScript/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="../../bootstrap/js/bootstrap.min.js"></script>  

        <!-- Scripts Personalizados -->
        <script src="../../JavaScript/Sintoma/listar.js"></script>       
    </body>
</html>
