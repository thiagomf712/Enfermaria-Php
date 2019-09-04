<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Enums/Regime.php');
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

        <title>Lista - Pacientes</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php require_once '../Compartilhado/Navbar.php'; ?>        

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">
            
            <input type="hidden" id="nivelAcessoAtivo" value="<?= $usuario->nivelAcesso ?>">

            <!-- Titulo -->
            <header class="mb-4">
                <h2>Lista de Pacientes</h2>
            </header>

            <!-- Formulario de filtro -->
            <form id="filtro" class="mb-3 clearfix">
                <div class="form-row">

                    <!-- Filtro - Nome -->
                    <div class="form-group col-sm">
                        <label for="nome">Nome: </label>
                        <input class="form-control" type="text" id="nome" name="Nome"/>
                    </div>    

                    <!-- Filtro - Ra -->
                    <div class="form-group col-sm">
                        <label for="ra">Ra: </label>
                        <input class="form-control" type="number" id="ra" name="Ra"/>
                    </div> 

                    <!-- Filtro - Regime -->
                    <div class="form-group col-sm">
                        <label for="regime">Regime: </label>
                        <select class="form-control" id="regime" name="Regime">
                            <option value="<?= Regime::Interno; ?>">Interno</option>
                            <option value="<?= Regime::Externo; ?>">Externo</option>
                            <option value="" selected>Sem filtro</option>
                        </select>
                    </div> 
                </div>

                <div class="form-group float-sm-right">
                    <button class="btn btn-secondary" type="submit">Procurar</button>
                    <button class="btn btn-secondary" type="button" id="remover">Remover Filtro</button>
                </div>
            </form>

            <!-- Quantidade de resultados -->
            <div class="my-2">
                <span id="quantidade"></span> resultados 
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">

                    <!-- Cabeçalho da tabela -->
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

                            <!-- Ordenar Ra -->
                            <th scope="col">
                                <span>Ra</span> 
                                <i class="fas fa-sort"></i>
                                <button id="order-ra" type="submit"></button>
                            </th>

                            <!-- Ordenar Regime -->
                            <th scope="col">
                                <span>Regime</span> 
                                <i class="fas fa-sort"></i>
                                <button id="order-regime" type="submit"></button>
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
        <script src="../../JavaScript/Paciente/listar.js"></script>          
    </body>
</html>
