-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Mar-2022 às 23:13
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ponto`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `escalas`
--

CREATE TABLE `escalas` (
  `id` int(11) NOT NULL,
  `nome` varchar(15) NOT NULL,
  `domingo` int(11) NOT NULL DEFAULT 0,
  `segunda` int(11) NOT NULL DEFAULT 0,
  `terca` int(11) NOT NULL DEFAULT 0,
  `quarta` int(11) NOT NULL DEFAULT 0,
  `quinta` int(11) NOT NULL DEFAULT 0,
  `sexta` int(11) NOT NULL DEFAULT 0,
  `sabado` int(11) NOT NULL DEFAULT 0,
  `jornada` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `escalas`
--

INSERT INTO `escalas` (`id`, `nome`, `domingo`, `segunda`, `terca`, `quarta`, `quinta`, `sexta`, `sabado`, `jornada`) VALUES
(4, 'Seg a Sexta', 0, 9, 9, 9, 9, 8, 0, '8 ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `folha`
--

CREATE TABLE `folha` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data` date NOT NULL,
  `entrada1` datetime NOT NULL,
  `saida1` datetime NOT NULL,
  `entrada2` datetime NOT NULL,
  `saida2` datetime NOT NULL,
  `tempo_trabalhado` varchar(15) NOT NULL,
  `saldo` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `folha`
--

INSERT INTO `folha` (`id`, `id_usuario`, `data`, `entrada1`, `saida1`, `entrada2`, `saida2`, `tempo_trabalhado`, `saldo`) VALUES
(1, 2, '2022-03-28', '2022-03-28 23:46:58', '2022-03-28 23:52:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', ''),
(3, 2, '2022-03-29', '2022-03-29 00:06:23', '2022-03-29 00:06:39', '2022-03-29 01:05:26', '2022-03-29 01:07:37', '00:02:27', '-08:57:33');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `senha` varchar(15) NOT NULL,
  `email` varchar(54) NOT NULL,
  `escala` varchar(15) NOT NULL,
  `tipo` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `senha`, `email`, `escala`, `tipo`) VALUES
(1, 'Raynder Cardoso', 'raynder', '123', 'raynder.carvalho@lobeconsultoria.com.br', '', '2'),
(2, 'Seg a Sexta', 'Kauanny', '321', 'kauanny.moraes@lobeconsultoria.com.br', '4', '1');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `escalas`
--
ALTER TABLE `escalas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `folha`
--
ALTER TABLE `folha`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `escalas`
--
ALTER TABLE `escalas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `folha`
--
ALTER TABLE `folha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
