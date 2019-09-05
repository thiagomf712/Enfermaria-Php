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

        <title>Estatisticas</title>
    </head>
    <body>       
        <!-- Barra de navegação -->
        <?php require_once '../Compartilhado/Navbar.php'; ?>

        <!-- Area principal -->
        <div id="area-principal" class="container bg-primary">
            <input type="hidden" id="nivelAcessoAtivo" value="<?= $usuario->nivelAcesso ?>">

            <!-- Titulo -->
            <header class="mb-4">
                <h2>Estatistica</h2>
            </header>

            <!-- Formulario de filtro -->
            <form id="filtro" class="mb-5 clearfix">
                <div class="form-row">    

                    <!-- Filtro - Data Inicial -->
                    <div class="form-group col-sm">
                        <label for="inicio">Data Inicial: </label>
                        <input class="form-control" type="date" id="inicio" name="Inicio"/>
                    </div>    

                    <!-- Filtro - Data Final -->
                    <div class="form-group col-sm">
                        <label for="fim">Data Final: </label>
                        <input class="form-control" type="date" id="fim" name="Fim"/>
                    </div> 
                </div>

                <!-- Botões -->
                <div class="float-sm-right">
                    <button class="btn btn-secondary" type="submit">Procurar</button>
                    <button class="btn btn-secondary" type="button" id="remover">Remover Filtro</button>
                </div>
            </form>

            <!-- cartões de quantidades -->
            <div id="cards">
                <div class="row m-0">
                    <!-- Cartão de pacientes -->
                    <div class="col-md mt-2">
                        <div class="card bg-dark">
                            <h4 class="card-header"> Pacientes </h4>

                            <div class="card-body">
                                <h6 class="card-title">Pacientes Atendidos</h6>
                                <p id="numero-pacientes" class="card-text destaque">0</p>
                                <button id="ver-pacientes" type="button" class="btn btn-secondary btn-block btn-sm">Ver lista</button>
                            </div>
                        </div>
                    </div>

                    <!-- Cartão de Sintomas -->
                    <div class="col-md mt-2">
                        <div class="card bg-dark">
                            <h4 class="card-header"> Sintomas </h4>

                            <div class="card-body">
                                <h6 class="card-title">Sintomas Apresentados</h6>
                                <p id="numero-sintomas" class="card-text destaque">0</p>
                                <button id="ver-sintomas" type="button" class="btn btn-secondary btn-block btn-sm">Ver lista</button>
                            </div>
                        </div>
                    </div>

                    <!-- Cartão de atendimentos -->
                    <div class="col-md mt-2">
                        <div class="card bg-dark">
                            <h4 class="card-header"> Atendimentos </h4>

                            <div class="card-body">
                                <h6 class="card-title">Atendimentos Realizados</h6>
                                <p id="numero-atendimento" class="card-text destaque">0</p>
                                <button id="ver-atendimentos" type="button" class="btn btn-secondary btn-block btn-sm">Ver lista</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela -->
            <div id="tabela" class="d-none mt-5">

                <div class="my-2">
                    <span id="quantidade"></span> resultados unicos
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">

                        <!-- Cabeçalho da tabela -->
                        <thead class="thead-light">
                            <tr>
                                <!-- Numeros - Ordena Id -->
                                <th scope="col">#</th>

                                <!-- Ordenar paciente -->
                                <th scope="col">
                                    <span id="coluna-valor"></span> 
                                    <i class="fas fa-sort"></i>
                                    <button id="order-valor" type="submit"></button>
                                </th>

                                <!-- Ordenar Data -->
                                <th scope="col">
                                    <span id="coluna-quantidade">Quantidade</span> 
                                    <i class="fas fa-sort"></i>
                                    <button id="order-quantidade" type="submit" value="ordenado"></button>
                                </th>
                                
                                <th scope="col">Porcentagem</th>
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
        <script src="../../JavaScript/Estatistica/detalhes.js"></script> 
    </body>
</html>


