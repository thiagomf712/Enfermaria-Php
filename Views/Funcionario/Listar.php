<?php
/*
  define('__ROOT__', dirname(__FILE__, 3));

  require_once(__ROOT__ . '/Controllers/FuncionarioController.php');

  if (session_id() == '') {
  session_start();
  }

  if (isset($_SESSION['filtro'])) {
  $lista = (isset($_SESSION['filtroOrdenado'])) ? unserialize($_SESSION['filtroOrdenado']) : unserialize($_SESSION['filtro']);
  } else {
  $lista = (isset($_SESSION['ordenado'])) ? unserialize($_SESSION['ordenado']) : FuncionarioController::Listar();
  }

  $numeroPaginas = ceil(count($lista) / 25);
  $paginaAtual = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
  $posMax = $paginaAtual * 25;
  $inicio = $posMax - 25;
  $limite = (count($lista) >= $posMax) ? $posMax : count($lista); */
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

        <title>Lista - Funcionarios</title>
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>              

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">

            <!-- Titulo -->
            <header class="mb-4">
                <h2>Lista de funcionarios</h2>
            </header>

            <!-- Formulario Filtro -->
            <form class="mb-3 clearfix" action="../../Controllers/FuncionarioController.php" method="POST">
                <input type="hidden" name="metodoFuncionario" value="Filtrar"/>

                <div class="row">
                    <!-- Nome -->
                    <div class="form-group col-sm">
                        <label for="nome">Nome: </label>
                        <input class="form-control" type="text" id="nome" name="nome"/>
                    </div>  

                    <!-- Nivel de Acesso -->
                    <div class="form-group col-sm">
                        <label for="nome">Nivel Acesso: </label>
                        <select class="custom-select" id="nivelAcesso" name="nivelAcesso">
                            <option value="<?php echo NivelAcesso::Vizualizar; ?>">Visualizar</option>
                            <option value="<?php echo NivelAcesso::Adicionar; ?>">Adicionar</option>
                            <option value="<?php echo NivelAcesso::Editar; ?>">Editar / Remover</option>
                            <option value="<?php echo NivelAcesso::Master; ?>">Master</option>
                            <option value="0" selected>Sem filtro</option>
                        </select>
                    </div> 
                </div>

                <!-- Botões -->
                <div class="float-sm-right">
                    <button class="btn btn-secondary" type="submit" name="remover">Procurar</button>
                    <button class="btn btn-secondary" type="button" name="remover" onclick="location.reload();" id="remover">Remover Filtro</button>
                </div> 
            </form>

            <!-- Tabela -->
            <div class="table-responsive">
                <table class="table table-hover">

                    <!-- Header Tabela -->
                    <thead class="thead-light">
                        <tr>
                            <!-- Ordenar Id -->
                            <th scope="col">
                                <span>#</span> 
                                <i class="fas fa-sort"></i>
                                <button type="button"></button>
                            </th>

                            <!-- Ordenar Nome -->
                            <th scope="col">
                                <span>Nome</span> 
                                <i class="fas fa-sort"></i>
                                <button type="button"></button>
                            </th>

                            <!-- Ordenar Nivel de acesso -->
                            <th scope="col">
                                <span>Nivel de Acesso</span> 
                                <i class="fas fa-sort"></i>
                                <button type="button"></button>
                            </th>

                            <!-- Açoes -->
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>

                    <!-- Corpo tabela -->
                    <tbody>                
                        <!-- Preechido dinamicamente pelo javacript -->
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <?php require_once '../Compartilhado/Paginacao.php';?>
        </div>  

        <?php if (isset($_GET['i']) && !(isset($_SESSION['erro']))) { ?>
            <script>
                $(document).ready(function () {
                    $("#modalAlerta").modal();
                });
            </script>  
            <?php
            $index = $_GET['i'];
        }
        ?>

        <!-- Modal Alerta -->
        <div class="modal fade" id="modalAlerta">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning p-2">
                        <h5 class="modal-title">Atenção</h5>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que quer deletar o funcionario <strong><?php echo $lista[$index]['Nome']; ?> </strong></p>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="submit" class="btn btn-primary" form="Deletar">Deletar</button>

                        <form method="POST" id="Deletar" action="../../Controllers/FuncionarioController.php">
                            <input type="hidden" name="metodoFuncionario" value="Deletar"/>
                            <input type="hidden" name="funcionarioId" value="<?php echo $lista[$index]['Id']; ?>" />   
                            <input type="hidden" name="usuarioId" value="<?php echo $lista[$index]['UsuarioId']; ?>" />
                        </form>

                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="history.go(-1);">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rodapé -->    
        <?php include_once '../Compartilhado/Footer.php'; ?>

        <!-- Modal de resposta -->
        <?php include_once '../Compartilhado/ModalErro.php'; ?> 

        <!-- JQuery - popper - Bootstrap-->
        <script src="../../JavaScript/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="../../bootstrap/js/bootstrap.min.js"></script>  

        <!-- Scripts Personalizados -->
        <script src="../../JavaScript/Funcionario/listarFuncionario.js"></script>  
    </body>
</html>
