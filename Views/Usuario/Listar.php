<?php
define('__ROOT__', dirname(__FILE__, 3));
require_once(__ROOT__ . '/Models/Usuario.php');

require_once(__ROOT__ . '/Controllers/UsuarioController.php');

if (session_id() == '') {
    session_start();
}

$lista = (isset($_SESSION['ordenado'])) ? unserialize($_SESSION['ordenado']) : UsuarioController::Listar();

$numeroPaginas = ceil(count($lista) / 25);
$paginaAtual = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
$posMax = $paginaAtual * 25;
$inicio = $posMax - 25;
$limite = (count($lista) >= $posMax) ? $posMax : count($lista);

$usuario = unserialize($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html>
    <head lang="pt-br">
        <title>Lista - Usuario</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="UTF-8">

        <link rel="stylesheet" href="../../Css/forms.css?version=20" /> 
        <link rel="stylesheet" href="../../Css/bootstrap.css" />   

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>          
    </head>
    <body>
        <?php include_once '../Compartilhado/Navbar.php'; ?>              

        <div class="mx-auto p-4 formGeral listas">
            <header class="mb-4">
                <h2>Lista de usuarios</h2>
            </header>

            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <?php
                        $filtro = (isset($_SESSION['coluna'])) ? $_SESSION['coluna'] : '';
                        $ordem = (isset($_SESSION['estado'])) ? $_SESSION['estado'] : '';
                        ?>

                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/UsuarioController.php">
                                <input type="hidden" name="metodoUsuario" value="Ordenar"/>
                                <input type="hidden" name="coluna" value="Id"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "Id" && $ordem == "DESC") ? 'ASC' : 'DESC' ?>"/>
                                <button type="submit" class="border-0 bg-transparent">#</button>
                            </form>
                        </th>

                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/UsuarioController.php">
                                <input type="hidden" name="metodoUsuario" value="Ordenar"/>
                                <input type="hidden" name="coluna" value="Login"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "Login" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                <button type="submit" class="border-0 bg-transparent">Login</button>
                            </form>
                        </th>

                        <th scope="col">
                            <form class="form-inline" method="POST" action="../../Controllers/UsuarioController.php">
                                <input type="hidden" name="metodoUsuario" value="Ordenar"/>
                                <input type="hidden" name="coluna" value="NivelAcesso"/>
                                <input type="hidden" name="ordem" value="<?php echo ($filtro == "NivelAcesso" && $ordem == "ASC") ? 'DESC' : 'ASC' ?>"/>
                                <button type="submit" class="border-0 bg-transparent">Nivel de Acesso</button>
                            </form>
                        </th>
                        
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = $inicio; $i < $limite; $i++) : ?>
                        <tr class="table-dark">
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $lista[$i]['Login']; ?></td>
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
                            <td>
                                <a href="Editar.php?usuario=<?php echo $lista[$i]['Id']; ?>" class="btn btn-primary btn-sm">Alterar Senha</a>                     
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table> 

            <?php include_once '../Compartilhado/Paginacao.php'; ?>
        </div>  

        <?php include_once '../Compartilhado/ModalErroSucesso.php'; ?>

        <?php include_once '../Compartilhado/Footer.php'; ?>

        <script src="../../JavaScript/Geral/bootstrap.js"></script>
        <script src="../../JavaScript/Geral/bootstrapValidation.js"></script>    
    </body>
</html>