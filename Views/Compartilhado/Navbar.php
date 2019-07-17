<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <a class="navbar-brand mb-0 h1" href="../Geral/Home.php">Enfermaria</a>
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarItens" aria-controls="navbarItens" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbarItens" style="">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <!--NA = 1 :: Atendimento pessoal-->
                <!--NA >= 2 :: lista com todos os atendimentos-->
                <a class="nav-link" href="#">Atendimento</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Paciente</a>
                <div class="dropdown-menu">
                    <?php if ($usuario->getNivelAcesso() == 1) : ?>
                        <a class="dropdown-item" href="#">Informações pessoais</a>                    
                    <?php elseif ($usuario->getNivelAcesso() >= 2) : ?>
                        <a class="dropdown-item" href="#">Lista de pacientes</a>
                        <a class="dropdown-item" href="../Paciente/Cadastrar.php">Cadastrar novo paciente</a>                           
                    <?php endif; ?>
                </div>         
            </li>
            <?php if ($usuario->getNivelAcesso() >= 3) : ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Sintoma</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Lista de sitomas</a>
                        <a class="dropdown-item" href="../Sintoma/Cadastrar.php">Cadastrar novo sintoma</a>
                    </div>         
                </li>
            <?php endif; ?>
            <?php if ($usuario->getNivelAcesso() == 4) : ?>    
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Funcionario</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Lista de funcionarios</a>
                        <a class="dropdown-item" href="../Funcionario/Cadastrar.php">Cadastrar novo funcionario</a>
                    </div>         
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Usuario</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Lista de usuarios</a>
                        <a class="dropdown-item" href="../Usuario/Cadastrar.php">Cadastrar novo usuario</a>
                    </div>         
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="../Usuario/Login.php">Sair</a>
            </li>
        </ul>
    </div>
</nav>
