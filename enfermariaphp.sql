-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05-Set-2019 às 13:59
-- Versão do servidor: 10.1.40-MariaDB
-- versão do PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `enfermariaphp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendimento`
--

CREATE TABLE `atendimento` (
  `Id` int(11) NOT NULL,
  `Data` date NOT NULL,
  `Hora` time NOT NULL,
  `Procedimento` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PacienteId` int(11) NOT NULL,
  `FuncionarioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `atendimento`
--

INSERT INTO `atendimento` (`Id`, `Data`, `Hora`, `Procedimento`, `PacienteId`, `FuncionarioId`) VALUES
(7, '2019-07-25', '12:24:00', 'ope ope no mi', 5, 8),
(8, '2019-07-10', '09:59:00', '123', 12, 4),
(9, '2019-07-12', '16:12:00', '321', 11, 9),
(10, '2019-07-15', '10:00:00', 'chá sei lá do que', 4, 4),
(13, '2019-07-29', '12:12:00', '21', 4, 11),
(14, '2019-06-30', '15:43:00', '31', 4, 11),
(15, '2019-07-08', '21:22:00', '123', 4, 11),
(16, '2019-07-10', '05:23:00', '43321', 4, 11),
(17, '2019-07-25', '12:12:00', '132', 6, 10),
(18, '2019-07-30', '11:01:00', '123', 6, 10),
(19, '2019-07-14', '12:12:00', '123', 11, 10),
(20, '2019-07-02', '14:02:00', '213', 12, 10),
(21, '2019-06-30', '11:03:00', 'Tratamento', 4, 10),
(28, '2019-09-03', '13:00:00', 'Encaminhado ao hospital de Engenheiro Coelho', 16, 9),
(36, '2019-09-02', '13:22:00', 'Chá', 15, 10),
(37, '2019-09-02', '22:07:00', 'Tratamento miraculoso', 15, 40),
(38, '2019-09-02', '13:48:00', 'Tratamento', 12, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendimentosintoma`
--

CREATE TABLE `atendimentosintoma` (
  `Id` int(11) NOT NULL,
  `AtendimentoId` int(11) NOT NULL,
  `SintomaId` int(11) NOT NULL,
  `Especificacao` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `atendimentosintoma`
--

INSERT INTO `atendimentosintoma` (`Id`, `AtendimentoId`, `SintomaId`, `Especificacao`) VALUES
(5, 7, 32, 'pessoas'),
(6, 7, 21, 'frequentes'),
(7, 8, 5, ''),
(8, 9, 8, ''),
(9, 10, 51, ''),
(21, 13, 65, 'Forte'),
(22, 14, 25, '2'),
(23, 15, 63, '32'),
(24, 16, 66, '\''),
(25, 16, 30, '21'),
(26, 16, 42, '321'),
(27, 17, 30, '321'),
(28, 17, 51, '13'),
(29, 18, 5, '123'),
(30, 18, 43, '321'),
(31, 18, 67, '321'),
(32, 18, 73, '123'),
(33, 19, 5, '321'),
(34, 19, 21, '123'),
(35, 19, 73, '21'),
(36, 20, 5, '321'),
(37, 20, 64, '123'),
(38, 20, 54, '123'),
(39, 21, 5, 'Afta'),
(42, 21, 21, 'Desmaios'),
(46, 28, 18, ''),
(47, 28, 42, 'Forte'),
(48, 28, 52, 'Forte'),
(57, 36, 43, 'Calaféia'),
(59, 37, 15, 'Dor de garganta'),
(60, 37, 10, '39º'),
(61, 38, 67, 'Dengue'),
(62, 38, 66, 'Diarreia'),
(63, 38, 46, 'Resfriado'),
(64, 38, 5, 'Afta');

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE `endereco` (
  `Id` int(11) NOT NULL,
  `Regime` tinyint(3) UNSIGNED NOT NULL,
  `Logradouro` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Numero` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Complemento` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Bairro` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Cidade` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Estado` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Cep` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PacienteId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`Id`, `Regime`, `Logradouro`, `Numero`, `Complemento`, `Bairro`, `Cidade`, `Estado`, `Cep`, `PacienteId`) VALUES
(2, 2, 'Rua Rosana E. Vargas', '155', 'Apartamento 8', 'Cidade Universitaria', 'Engenheiro Coelho', 'São paulo', '13449-899', 4),
(3, 1, 'Estr. Mun. Pastor Walter Boger', '', '', 'Lagoa Bonita I', 'Engenheiro Coelho', 'São Paulo', '13445-970', 5),
(4, 1, 'Estr. Mun. Pastor Walter Boger', '', '', 'Lagoa Bonita I', 'Engenheiro Coelho', 'São Paulo', '13445-970', 6),
(9, 2, 'Rua Rosana E. Vargas', '160', 'Apartamento 1', 'Cidade Universitaria', 'Engenheiro Coelho', 'São paulo', '13449-899', 11),
(10, 2, 'Rua Rosana E. Vargas', '155', 'Apartamento 4', 'Cidade Universitaria', 'Engenheiro Coelho', 'São paulo', '13449-899', 12),
(11, 2, 'Rua Rosana E. Vargas', '200', '', 'Cidade Universitaria', 'Engenheiro Coelho', 'São paulo', '13449-899', 15),
(12, 2, 'Rua Rosana E. Vargas', '250', 'Casa 2', 'Cidade Universitaria', 'Engenheiro Coelho', 'São paulo', '13449-899', 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fichamedica`
--

CREATE TABLE `fichamedica` (
  `Id` int(11) NOT NULL,
  `PlanoSaude` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProblemasSaude` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Medicamentos` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Alergias` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Cirurgias` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PacienteId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `fichamedica`
--

INSERT INTO `fichamedica` (`Id`, `PlanoSaude`, `ProblemasSaude`, `Medicamentos`, `Alergias`, `Cirurgias`, `PacienteId`) VALUES
(2, '', 'Colesterol alto', 'Carbamazepina', 'Benzetacil', 'Remoção das amígdalas  ', 4),
(3, 'Qualicorp', 'Diabete e rinite', '', 'pasta de amendoim', 'transplante do rim', 5),
(4, '', '', '', '', '', 6),
(9, '', '', '', '', '', 11),
(10, 'Qualicorp', 'Pressão Alta', '', '', '', 12),
(11, 'SaudePlus', '', '', 'alergia a frutos do mar', '', 15),
(12, 'Qualicorp', 'Diabetes', '', '', '', 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `UsuarioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`Id`, `Nome`, `UsuarioId`) VALUES
(1, 'Thiago Mendes Ferreira', 4),
(4, 'Márcia Cristina Shafer dos Santos', 7),
(8, 'Luan Cordeiro Dandas', 18),
(9, 'Antonio Carlos Filho', 19),
(10, 'Administrador', 1),
(11, 'Adicionar Somente', 26),
(12, 'igor ferreira', 27),
(13, 'teste 1', 28),
(14, 'teste 2', 29),
(15, 'teste 3', 30),
(16, 'teste3', 31),
(17, 'test4', 32),
(18, 'test5', 33),
(19, 'test6', 34),
(20, 'mateus santos', 35),
(21, 'test7', 36),
(22, 'Test10', 37),
(23, 'Test11', 38),
(24, 'Test12', 39),
(25, 'Test13', 40),
(26, 'Test14', 41),
(27, 'Test15', 42),
(28, 'Test16', 43),
(38, 'teste 40', 53),
(39, 'Teste 50', 54),
(40, 'Mateus Perez', 65),
(41, 'editar', 66);

-- --------------------------------------------------------

--
-- Estrutura da tabela `paciente`
--

CREATE TABLE `paciente` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Ra` int(11) NOT NULL,
  `DataNascimento` date NOT NULL,
  `Email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Telefone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UsuarioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `paciente`
--

INSERT INTO `paciente` (`Id`, `Nome`, `Ra`, `DataNascimento`, `Email`, `Telefone`, `UsuarioId`) VALUES
(4, 'Thiago Mendes Ferreira ', 94961, '1998-12-05', 'thiagomf712@gmail.com', '19 98287-9491', 13),
(5, 'Marcos Gustavo Santos', 106783, '1989-08-12', 'marquinhos@gmail.com', '19 99672-8767', 14),
(6, 'Lucas Shibuya', 62712, '1990-02-28', 'lucasShibuya@gmail.com', '19 98365-9232', 16),
(11, 'Marcia Cristina Shafer dos Santos', 65132, '1999-08-09', '', '', 24),
(12, 'João Mendes Ferreira', 1234, '1948-02-19', 'gogomendes@gmail.com', '19 95436-1932', 25),
(15, 'Mateus Santos', 74585, '1998-12-10', 'mateusSantos@gmail.com', '19982879491', 62),
(16, 'Wallace', 45758, '1990-05-25', 'wallacejunior@gmail.com', '', 63);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sintoma`
--

CREATE TABLE `sintoma` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sintoma`
--

INSERT INTO `sintoma` (`Id`, `Nome`) VALUES
(1, 'Intoxicação'),
(2, 'Infecção urinária'),
(3, 'Inalação com receita'),
(4, 'Inalação sem receita'),
(5, 'Afta'),
(6, 'Herpes'),
(7, 'Falta de ar'),
(8, 'Gripe'),
(9, 'Furúnculo'),
(10, 'Febre'),
(11, 'Torcicolo'),
(12, 'Dor no corpo'),
(13, 'Dor muscular'),
(14, 'Dor de ouvido'),
(15, 'Dor de garganta'),
(16, 'Outro'),
(17, 'Insônia'),
(18, 'Ansiedade'),
(19, 'Estresse'),
(20, 'Irritação ocular'),
(21, 'Desmaios'),
(22, 'Retirada de pontos'),
(23, 'Queimadura'),
(24, 'Asma'),
(25, 'Dispinéia'),
(26, 'Bronquite'),
(27, 'Sinusite'),
(28, 'Enjôo'),
(29, 'Rinite'),
(30, 'Dermatities'),
(31, 'Micose'),
(32, 'Alergia'),
(33, 'Picada de inseto'),
(34, 'Terçol'),
(35, 'Conjutivite'),
(36, 'Inchaço ocular'),
(37, 'Pós-Operatório'),
(38, 'Vômito'),
(39, 'Azia'),
(40, 'Gastrite'),
(41, 'Congestão nasal'),
(42, 'Cólica'),
(43, 'Cafaléia'),
(44, 'Hematomas'),
(45, 'Ferida labial'),
(46, 'Resfriado'),
(47, 'Gases'),
(48, 'Coriza'),
(49, 'Febrícula'),
(50, 'Infecção renal'),
(51, 'Tontura'),
(52, 'Enxaqueca'),
(53, 'Roquidão'),
(54, 'Verificação de PA'),
(55, 'Marcação de consulta'),
(56, 'Encaminhamento ao hospital'),
(57, 'Injeção com receita'),
(58, 'Mal-estar'),
(59, 'Contusão'),
(60, 'Pancada'),
(61, 'Dor no figado'),
(62, 'Dor de estomago'),
(63, 'Dor de dente'),
(64, 'Dor abdominal'),
(65, 'Costipação'),
(66, 'Diarréia'),
(67, 'Dengue'),
(68, 'Torção'),
(69, 'Unha incravada'),
(70, 'Inflamações'),
(71, 'Escoriações'),
(72, 'Calos'),
(73, 'Corte'),
(74, 'Estiramento'),
(75, 'Tendinite'),
(76, 'Fratura'),
(77, 'Unha inflamada'),
(78, 'Tosse');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `Id` int(11) NOT NULL,
  `Login` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Senha` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `NivelAcesso` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`Id`, `Login`, `Senha`, `NivelAcesso`) VALUES
(1, 'admin', 'admin', 4),
(4, 'thiagomf712', 'j454647m', 4),
(7, 'Cristina.Shafer', '1234', 3),
(13, 'ec.94961', 'ec.94961', 1),
(14, 'ec.106783', 'ec.106783', 1),
(16, 'ec.62712', 'ec.62712', 1),
(18, 'Luan.dantas', 'unasp2019', 4),
(19, 'antonio.carlos', '1234', 2),
(24, 'ec.65132', 'ec.65132', 1),
(25, 'ec.1234', 'ec.1234', 1),
(26, 'adicionar', '1234', 2),
(27, 'igor.ferreira', 'j454647m', 2),
(28, 'teste1', 'j454647m', 2),
(29, 'teste2', 'j454647m', 2),
(30, 'test2', '1234', 2),
(31, 'teste3', 'superteste3', 2),
(32, 'test4', 'test4', 2),
(33, 'test5', 'test4', 2),
(34, 'test6', 'test6', 2),
(35, 'mateus.santos', 'k7k8k9', 3),
(36, 'test7', 'test7', 2),
(37, 'test10', 'test10', 2),
(38, 'test11', 'test10', 2),
(39, 'test12', 'test10', 2),
(40, 'test13', 'test10', 2),
(41, 'test14', 'test10', 2),
(42, 'test15', 'test10', 2),
(43, 'test16', 'test10', 2),
(53, 'test 40', '1234', 3),
(54, 'teste50', '1234', 2),
(62, 'ec.74585', 'ec.74585', 1),
(63, 'ec.45758', 'ec.45758', 1),
(65, 'mateus.perez', 'mateus', 2),
(66, 'editar', '1234', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atendimento`
--
ALTER TABLE `atendimento`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Atendimento Unico` (`Data`,`Hora`,`PacienteId`,`FuncionarioId`),
  ADD KEY `FK_Atendimento_Funcionario` (`FuncionarioId`),
  ADD KEY `FK_Atendimento_Paciente` (`PacienteId`);

--
-- Indexes for table `atendimentosintoma`
--
ALTER TABLE `atendimentosintoma`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `AS unico` (`AtendimentoId`,`SintomaId`),
  ADD KEY `FK_Sintomas` (`SintomaId`);

--
-- Indexes for table `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_Endereco_Paciente` (`PacienteId`);

--
-- Indexes for table `fichamedica`
--
ALTER TABLE `fichamedica`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_FichaMedica_Paciente` (`PacienteId`);

--
-- Indexes for table `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_Funcionario_Usuario` (`UsuarioId`);

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Ra` (`Ra`),
  ADD KEY `FK_Usuario` (`UsuarioId`);

--
-- Indexes for table `sintoma`
--
ALTER TABLE `sintoma`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Login` (`Login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atendimento`
--
ALTER TABLE `atendimento`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `atendimentosintoma`
--
ALTER TABLE `atendimentosintoma`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `endereco`
--
ALTER TABLE `endereco`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fichamedica`
--
ALTER TABLE `fichamedica`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `paciente`
--
ALTER TABLE `paciente`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sintoma`
--
ALTER TABLE `sintoma`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `atendimento`
--
ALTER TABLE `atendimento`
  ADD CONSTRAINT `FK_Atendimento_Funcionario` FOREIGN KEY (`FuncionarioId`) REFERENCES `funcionario` (`Id`),
  ADD CONSTRAINT `FK_Atendimento_Paciente` FOREIGN KEY (`PacienteId`) REFERENCES `paciente` (`Id`);

--
-- Limitadores para a tabela `atendimentosintoma`
--
ALTER TABLE `atendimentosintoma`
  ADD CONSTRAINT `FK_Atendimento` FOREIGN KEY (`AtendimentoId`) REFERENCES `atendimento` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Sintomas` FOREIGN KEY (`SintomaId`) REFERENCES `sintoma` (`Id`);

--
-- Limitadores para a tabela `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `FK_Endereco_Paciente` FOREIGN KEY (`PacienteId`) REFERENCES `paciente` (`Id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `fichamedica`
--
ALTER TABLE `fichamedica`
  ADD CONSTRAINT `FK_FichaMedica_Paciente` FOREIGN KEY (`PacienteId`) REFERENCES `paciente` (`Id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `FK_Funcionario_Usuario` FOREIGN KEY (`UsuarioId`) REFERENCES `usuario` (`Id`);

--
-- Limitadores para a tabela `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `FK_Usuario` FOREIGN KEY (`UsuarioId`) REFERENCES `usuario` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
