<?php
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 3));
}

require_once(__ROOT__ . '/Models/Usuario.php');
require_once(__ROOT__ . '/Models/Enums/NivelAcesso.php');

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../Usuario/Login.php");
}

$usuario = unserialize($_SESSION['usuario']);
?>


<header class="bg-primary">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-xl navbar-dark">

            <!-- Principal -->
            <a class="navbar-brand mb-0 h1" href="../Geral/Home.php">UnaspMed</a>

            <!-- Botão que aparece em telas pequenas -->
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarItens" aria-controls="navbarItens" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Resto do menu -->
            <div class="navbar-collapse collapse" id="navbarItens">
                <ul class="navbar-nav ml-auto">

                    <!-- atendimentos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Atendimento</a>
                        <div class="dropdown-menu">
                            <?php if ($usuario->nivelAcesso == NivelAcesso::Vizualizar) : ?>
                                <a class="dropdown-item navegacao" href="../Atendimento/ListaPessoal.php">Atendimentos</a>                    
                            <?php elseif ($usuario->nivelAcesso >= NivelAcesso::Adicionar) : ?>
                                <a class="dropdown-item navegacao" href="../Atendimento/Listar.php">Lista de atendimentos</a>
                                <a class="dropdown-item navegacao" href="../Atendimento/ListaPacientes.php">Cadastrar novo atendimento</a>                           
                            <?php endif; ?>
                        </div>         
                    </li>

                    <!-- Pacientes -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Paciente</a>
                        <div class="dropdown-menu">
                            <?php if ($usuario->nivelAcesso == NivelAcesso::Vizualizar) : ?>
                                <a class="dropdown-item navegacao" href="../Paciente/Pesoal.php">Informações pessoais</a>                    
                            <?php elseif ($usuario->nivelAcesso >= NivelAcesso::Adicionar) : ?>
                                <a class="dropdown-item navegacao" href="../Paciente/Listar.php">Lista de pacientes</a>
                                <a class="dropdown-item navegacao" href="../Paciente/Cadastrar.php">Cadastrar novo paciente</a>                           
                            <?php endif; ?>
                        </div>         
                    </li>

                    <!-- Sintomas -->
                    <?php if ($usuario->nivelAcesso >= NivelAcesso::Editar) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Sintoma</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item navegacao" href="../Sintoma/Listar.php">Lista de sitomas</a>
                                <a class="dropdown-item navegacao" href="../Sintoma/Cadastrar.php">Cadastrar novo sintoma</a>
                            </div>         
                        </li>
                    <?php endif; ?>

                    <!-- Funcionarios -->
                    <?php if ($usuario->nivelAcesso == NivelAcesso::Master) : ?>    
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Funcionario</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item navegacao" href="../Funcionario/Listar.php">Lista de funcionarios</a>
                                <a class="dropdown-item navegacao" href="../Funcionario/Cadastrar.php">Cadastrar novo funcionario</a>
                            </div>         
                        </li>
                    <?php endif; ?>

                    <!-- Usuarios -->
                    <?php if ($usuario->nivelAcesso >= NivelAcesso::Editar) : ?> 
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Usuario</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item navegacao" href="../Usuario/Listar.php">Lista de usuarios</a>
                            </div>         
                        </li>
                    <?php endif; ?>

                    <!-- Estatistica -->
                    <?php if ($usuario->nivelAcesso >= NivelAcesso::Adicionar) : ?> 
                        <li class="nav-item">
                            <a class="nav-link navegacao" href="../Estatistica/">Estatistica</a>      
                        </li>
                    <?php endif; ?>

                    <!-- Link para sair -->
                    <li class="nav-item">
                        <a class="nav-link navegacao" href="../Usuario/Deslogar.php">Sair</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>