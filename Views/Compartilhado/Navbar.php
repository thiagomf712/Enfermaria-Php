<?php
require_once(__ROOT__ . '/Models/Enums/NivelAcesso.php');
?>

<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <a class="navbar-brand mb-0 h1" href="../Geral/Home.php">Enfermaria</a>
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarItens" aria-controls="navbarItens" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarItens">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <!--NA = 1 :: Atendimento pessoal-->
                <!--NA >= 2 :: lista com todos os atendimentos-->
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Atendimento</a>
                <div class="dropdown-menu">
                    <?php if ($usuario->getNivelAcesso() == NivelAcesso::Vizualizar) : ?>
                        <a class="dropdown-item navegacao" href="#">Atendimentos</a>                    
                    <?php elseif ($usuario->getNivelAcesso() >= NivelAcesso::Adicionar) : ?>
                        <a class="dropdown-item navegacao" href="#">Lista de atendimentos</a>
                        <a class="dropdown-item navegacao" href="#">Cadastrar novo atendimento</a>                           
                    <?php endif; ?>
                </div>         
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Paciente</a>
                <div class="dropdown-menu">
                    <?php if ($usuario->getNivelAcesso() == NivelAcesso::Vizualizar) : ?>
                        <a class="dropdown-item navegacao" href="#">Informações pessoais</a>                    
                    <?php elseif ($usuario->getNivelAcesso() >= NivelAcesso::Adicionar) : ?>
                        <a class="dropdown-item navegacao" href="../Paciente/Listar.php">Lista de pacientes</a>
                        <a class="dropdown-item navegacao" href="../Paciente/Cadastrar.php">Cadastrar novo paciente</a>                           
                    <?php endif; ?>
                </div>         
            </li>
            <?php if ($usuario->getNivelAcesso() >= NivelAcesso::Editar) : ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Sintoma</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item navegacao" href="../Sintoma/Listar.php">Lista de sitomas</a>
                        <a class="dropdown-item navegacao" href="../Sintoma/Cadastrar.php">Cadastrar novo sintoma</a>
                    </div>         
                </li>
            <?php endif; ?>
            <?php if ($usuario->getNivelAcesso() == NivelAcesso::Master) : ?>    
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Funcionario</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item navegacao" href="../Funcionario/Listar.php">Lista de funcionarios</a>
                        <a class="dropdown-item navegacao" href="../Funcionario/Cadastrar.php">Cadastrar novo funcionario</a>
                    </div>         
                </li>
            <?php endif; ?>
            <?php if ($usuario->getNivelAcesso() >= NivelAcesso::Editar) : ?> 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Usuario</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item navegacao" href="../Usuario/Listar.php">Lista de usuarios</a>
                        <!--<a class="dropdown-item navegacao" href="../Usuario/Cadastrar.php">Cadastrar novo usuario</a>-->
                    </div>         
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link navegacao" href="../Usuario/Login.php">Sair</a>
            </li>
        </ul>
    </div>
</nav>

<?php
if (isset($_SESSION['sucesso'])) {
    if (isset($_SESSION['ordenado'])) {
        unset($_SESSION['ordenado']);
    }

    if (isset($_SESSION['coluna'])) {
        unset($_SESSION['coluna']);
    }

    if (isset($_SESSION['estado'])) {
        unset($_SESSION['estado']);
    }

    if (isset($_SESSION['filtro'])) {
        unset($_SESSION['filtro']);
    }
    
    if (isset($_SESSION['filtroOrdenado'])) {
        unset($_SESSION['filtroOrdenado']);
    }
    
    if (isset($_SESSION['valorFiltrado'])) {
        unset($_SESSION['valorFiltrado']);
    }
}
?>

<script src="../../JavaScript/jquery-3.4.1.js"></script>
<script>
    var links = document.getElementsByClassName('navegacao');

    for (var i = 0; i < links.length; i++) {
        links[i].addEventListener("click", chamarPhp);
    }

    function chamarPhp() {
        $.post('../Compartilhado/phpAuxiliar.php', {function: 'DesabilitarOrdenacao'}, function (response) {
            console.log(response);
        });
    }
</script>