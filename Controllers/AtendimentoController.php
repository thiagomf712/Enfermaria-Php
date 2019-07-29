<?php

if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(__FILE__, 2));
}

require_once(__ROOT__ . '/Models/Atendimento.php');
require_once(__ROOT__ . '/Models/AtendimentoSintoma.php');

require_once(__ROOT__ . '/Services/AtendimentoService.php');
require_once(__ROOT__ . '/Services/AtendimentoSintomaService.php');
require_once(__ROOT__ . '/Services/PacienteService.php');
require_once(__ROOT__ . '/Services/FichaMedicaService.php');


if (session_id() == '') {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['metodoAtendimento'])) {
    $metodo = $_POST['metodoAtendimento'];

    if (method_exists('AtendimentoController', $metodo)) {
        AtendimentoController::$metodo($_POST);
    } else {
        throw new Exception("Metodo não existe");
    }
}

class AtendimentoController {

    public static function Cadastrar($dados) {
        //Paciente
        $pacienteId = $dados['pacienteId'];

        //Atendimento
        $funcionarioId = $dados['atendente'];
        $hora = $dados['hora'];
        $data = $dados['data'];

        //sintomas
        $numeroSintomas = $dados['numeroSintomas'];

        for ($i = 1; $i <= $numeroSintomas; $i++) {
            $sintomas[] = $dados['sintoma' . $i]; //Armazena o Id do sintoma
            $especificacoes[] = $dados['especificacao' . $i]; //Armazena o texto da especificação
        }

        //procedimento
        $procedimento = $dados['procedimento'];


        $atendimento = new Atendimento(0, $data, $hora, $procedimento, $pacienteId, $funcionarioId);

        for ($i = 1; $i <= $numeroSintomas; $i++) {
            $atendimentoSintoma[] = new AtendimentoSintoma(0, $especificacoes[($i - 1)], $sintomas[($i - 1)]);
        }

        try {
            AtendimentoService::CadastrarAtendimento($atendimento);

            $atendimentodb = AtendimentoService::RetornarAtendimento($atendimento);

            for ($i = 0; $i < count($atendimentoSintoma); $i++) {
                $atendimentoSintoma[$i]->setAtendimento($atendimentodb->getId());

                AtendimentoSintomaService::CadastrarAtendimentoSintoma($atendimentoSintoma[$i]);
            }

            $_SESSION['sucesso'] = "Atendimento cadastrado com sucesso";
            header("Location: ../Views/Atendimento/ListaPacientes.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function Editar($dados) {
        //Atendimento
        $atendimentoId = $dados['atendimentoId'];
        $funcionarioId = $dados['atendente'];
        $hora = $dados['hora'];
        $data = $dados['data'];

        //sintomas
        $numeroSintomas = $dados['numeroSintomas'];
        $numeroSintomasbd = $dados['numeroSintomasbd'];

        for ($i = 1; $i <= $numeroSintomas; $i++) {
            $id[] = isset($dados['idRegistro' . $i]) ? $dados['idRegistro' . $i] : null ; //Armazena o Id do registro
            $sintomas[] = $dados['sintoma' . $i]; //Armazena o Id do sintoma
            $especificacoes[] = $dados['especificacao' . $i]; //Armazena o texto da especificação
        }

        //Procedimento
        $procedimento = $dados['procedimento'];


        $atendimento = new Atendimento($atendimentoId, $data, $hora, $procedimento, null, $funcionarioId);

        for ($i = 1; $i <= $numeroSintomas; $i++) {
            if ($id[($i - 1)] != null) {
                $atendimentoSintomaEditado[] = new AtendimentoSintoma($id[($i - 1)], $especificacoes[($i - 1)], $sintomas[($i - 1)], $atendimentoId);
            } else {
                $atendimentoSintomaNovo[] = new AtendimentoSintoma(0, $especificacoes[($i - 1)], $sintomas[($i - 1)], $atendimentoId);
            }
        }

        try {
            AtendimentoService::EditarAtendimento($atendimento);

            for ($i = 0; $i < count($atendimentoSintomaEditado); $i++) {
                AtendimentoSintomaService::EditarAtendimentoSintoma($atendimentoSintomaEditado[$i]);
            }

            for ($i = 0; $i < count($atendimentoSintomaNovo); $i++) {
                AtendimentoSintomaService::CadastrarAtendimentoSintoma($atendimentoSintomaNovo[$i]);
            }

            if ($numeroSintomas < $numeroSintomasbd) {
                $sintomaDeletado = explode("/", $dados['sintomaDeletado']);
                

                for ($i = 1; $i < count($sintomaDeletado); $i++) {
                    AtendimentoSintomaService::Excluir($sintomaDeletado[$i]);
                }             
            }

            header("Location: ../Views/Atendimento/Listar.php");
            $_SESSION['sucesso'] = "Atendimento editado com sucesso";
            exit();
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function Listar() {
        try {
            $atendimentos = AtendimentoService::ListarAtendimentos();
            return $atendimentos;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function Ordenar($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $atendimento = AtendimentoService::ListarAtendimentosOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['ordenado'] = serialize($atendimento);
        header("Location: ../Views/Atendimento/Listar.php");
        exit();
    }

    public static function Filtrar($dados) {
        $paciente = $dados['paciente'];
        $funcionario = $dados['funcionario'];
        $inicio = $dados['inicio'];
        $fim = $dados['fim'];

        if ($paciente === '' && $funcionario === "" && $inicio == null && $fim == null) {
            header("Location: ../Views/Atendimento/Listar.php");
            exit();
        }

        if ($paciente !== '') {
            $valor[] = array('p.Nome', $paciente);
        }

        if ($funcionario !== '') {
            $valor[] = array('f.Nome', $funcionario);
        }

        if ($inicio != null && $fim != null) {
            $valor[] = array('a.Data', $inicio, $fim, 'ope' => 'entre');
        } else if ($inicio != null) {
            $valor[] = array('a.Data', $inicio, 'ope' => 'maior');
        } else if ($fim != null) {
            $valor[] = array('a.Data', $fim, 'ope' => 'menor');
        }

        $atendimentos = AtendimentoService::Filtrar($valor);

        $_SESSION['filtro'] = serialize($atendimentos);
        header("Location: ../Views/Atendimento/Listar.php");
        exit();
    }

    public static function OrdenarFiltro($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $atendimentos = AtendimentoService::FiltrarOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['filtroOrdenado'] = serialize($atendimentos);
        header("Location: ../Views/Atendimento/Listar.php");
        exit();
    }

    public static function RetornarFichaMedica($id) {
        try {
            $fichaMedica = FichaMedicaService::RetornarFichaMedica($id);

            return $fichaMedica;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function RetornarAtendimento($id) {
        try {
            $atendimento = AtendimentoService::RetornarAtendimentoCompleto($id);

            $paciente = PacienteService::RetornarNomeRa($atendimento->getPaciente());

            $sintomas = AtendimentoSintomaService::RetornarSintomas($id);

            $resultado['atendimento'] = $atendimento;

            $resultado['paciente'] = $paciente;
            $resultado['sintomas'] = $sintomas;

            return $resultado;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function ListarPacientes() {
        try {
            $pacientes = PacienteService::ListarPacientes();
            return $pacientes;
        } catch (Exception $e) {
            $_SESSION['erro'] = $e->getMessage();
            echo "<script language='javascript'>history.go(-1);</script>";
            exit();
        }
    }

    public static function FiltrarPacientes($dados) {
        $nome = $dados['nome'];
        $ra = $dados['ra'];
        $regime = $dados['regime'];

        if ($nome === '' && $regime === "0" && $ra == null) {
            header("Location: ../Views/Atendimento/ListaPacientes.php");
            exit();
        }

        if ($nome !== '') {
            $valor[] = array('p.Nome', $nome);
        }

        if ($regime !== "0") {
            $valor[] = array('e.Regime', $regime);
        }

        if ($ra !== null) {
            $valor[] = array('p.Ra', $ra);
        }

        $pacientes = PacienteService::Filtrar($valor);

        $_SESSION['filtro'] = serialize($pacientes);
        header("Location: ../Views/Atendimento/ListaPacientes.php");
        exit();
    }

    public static function OrdenarPaciente($dados) {
        echo Ola;
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $paciente = PacienteService::ListarPacientesOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['ordenado'] = serialize($paciente);
        header("Location: ../Views/Atendimento/ListaPacientes.php");
        exit();
    }

    public static function OrdenarFiltroPaciente($dados) {
        $coluna = $dados['coluna'];
        $ordem = $dados['ordem'];

        $pacientes = PacienteService::FiltrarOrdenado($coluna, $ordem);

        $_SESSION['coluna'] = $coluna;
        $_SESSION['estado'] = $ordem;

        $_SESSION['filtroOrdenado'] = serialize($pacientes);
        header("Location: ../Views/Atendimento/ListaPacientes.php");
        exit();
    }

}
