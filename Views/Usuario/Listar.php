<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Controllers/UsuarioController.php');

if (session_id() == '') {
    session_start();
}

if (isset($_SESSION['filtro'])) {
    $lista = (isset($_SESSION['filtroOrdenado'])) ? unserialize($_SESSION['filtroOrdenado']) : unserialize($_SESSION['filtro']);
} else {
    $lista = (isset($_SESSION['ordenado'])) ? unserialize($_SESSION['ordenado']) : UsuarioController::Listar();
}

$numeroPaginas = ceil(count($lista) / 25);
$paginaAtual = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
$posMax = $paginaAtual * 25;
$inicio = $posMax - 25;
$limite = (count($lista) >= $posMax) ? $posMax : count($lista);

if (!isset($_SESSION['usuario'])) {
    header("Location: ../Usuario/Login.php");
}

$usuario = unserialize($_SESSION['usuario']);
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
        
        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <title>Lista - Usuario</title>       
    </head>
    <body>
        <!-- Barra de navegação -->
        <?php include_once '../Compartilhado/Navbar.php'; ?>              

        <!-- Area da lista -->
        <div id="area-principal" class="container bg-primary">

            <!-- Titulo -->
            <header class="mb-4">
                <h2>Lista de usuarios</h2>
            </header>

            <!-- Formulario de filtro -->
            <form class="mb-3 clearfix" action="../../Controllers/UsuarioController.php" method="POST">
                <input type="hidden" name="metodoUsuario" value="Filtrar"/>

                <div class="form-row">
                    
                    <!-- Filtro - Login -->
                    <div class="form-group col-sm">
                        <label for="login">Login</label>
                        <input class="form-control form-control" type="text" id="login" name="login"/>
                    </div>    

                    <!-- Filtro - Nivel de acesso -->
                    <div class="form-group col-sm">
                        <label for="nome">Nivel Acesso</label>
                        <select class="custom-select custom-select" id="nivelAcesso" name="nivelAcesso">
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
                    <button class="btn btn-secondary" type="button" name="remover" onclick="location.reload();">Remover Filtro</button>
                </div>
            </form>

            <!-- Script para desabilitar filtros -->
            <script src="../../JavaScript/jquery-3.4.1.js"></script>
            <script>
                        var buttons = document.getElementsByName('remover');

                        for (var i = 0; i < buttons.length; i++) {
                            buttons[i].addEventListener("click", chamarPhp);
                        }

                        function chamarPhp() {
                            $.post('../Compartilhado/phpAuxiliar.php', {function: 'DesabilitarFiltro'}, function (response) {
                                console.log(response);
                            });
                        }
            </script>

            <!-- Tabela -->
            <div class="table-responsive">
                <table class="table table-hover">

                    <!-- Cabeçalho da tabela -->
                    <thead class="thead-light">
                        <tr>
                            <?php
                            $filtro = (isset($_SESSION['coluna'])) ? $_SESSION['coluna'] : '';
                            $ordem = (isset($_SESSION['estado'])) ? $_SESSION['estado'] : '';
                            ?>

                            <!-- Numeros - Ordena Id -->
                            <th scope="col">
                                
                                <form class="form-inline" method="POST" action="../../Controllers/UsuarioController.php">
                                    <input type="hidden" name="metodoUsuario" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltro' : 'Ordenar'; ?>"/>
                                    <input type="hidden" name="coluna" value="Id"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "Id" && $ordem == "DESC") ? 'ASC' : 'DESC' ?>"/>
                                    
                                    <span>#</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Ordenar Login -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/UsuarioController.php">
                                    <input type="hidden" name="metodoUsuario" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltro' : 'Ordenar'; ?>"/>
                                    <input type="hidden" name="coluna" value="Login"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "Login" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                    
                                    <span>Login</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Ordenar Nivel de acesso -->
                            <th scope="col">
                                <form class="form-inline" method="POST" action="../../Controllers/UsuarioController.php">
                                    <input type="hidden" name="metodoUsuario" value="<?php echo (isset($_SESSION['filtro'])) ? 'OrdenarFiltro' : 'Ordenar'; ?>"/>
                                    <input type="hidden" name="coluna" value="NivelAcesso"/>
                                    <input type="hidden" name="ordem" value="<?php echo ($filtro == "NivelAcesso" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                    
                                    <span>Nivel de Acesso</span> 
                                    <i class="fas fa-sort"></i>
                                    <button type="submit"></button>
                                </form>
                            </th>

                            <!-- Açoes possiveis -->
                            <th scope="col"><span>Ações</span></th>
                        </tr>
                    </thead>

                    <!-- Corpo da tabela -->
                    <tbody>
                        <?php for ($i = $inicio; $i < $limite; $i++) : ?>
                            <tr class="table-light">

                                <!-- Numeração -->
                                <td><?php echo $i + 1; ?></td>

                                <!-- Login -->
                                <td><?php echo $lista[$i]['Login']; ?></td>

                                <!-- Nivel de acesso -->
                                <td>
                                    <?php
                                    switch ($lista[$i]['NivelAcesso']) {
                                        case NivelAcesso::Vizualizar:
                                            echo 'Visualizar';
                                            break;
                                        case NivelAcesso::Adicionar:
                                            echo 'Adicionar';
                                            break;
                                        case NivelAcesso::Editar:
                                            echo 'Editar / Remover';
                                            break;
                                        case NivelAcesso::Master:
                                            echo 'Master';
                                            break;
                                        default:
                                            echo 'Sem nivel de acesso';
                                            break;
                                    }
                                    ?>
                                </td>

                                <!-- Açoes -->
                                <td>
                                    <a href="Editar.php?usuario=<?php echo $lista[$i]['Id']; ?>" class="btn btn-primary btn-sm">Alterar Senha</a>                     
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table> 
            </div>

            <!-- paginação -->
            <?php include_once '../Compartilhado/Paginacao.php'; ?>
        </div>

        <!-- Rodapé -->
        <?php include_once '../Compartilhado/Footer.php'; ?>

        <!-- Janela que aparece ao acontecer um erro no Backend (Precisa ser inserido depois do Jquery) -->
        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?>
        
        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>          
    </body>
</html>
