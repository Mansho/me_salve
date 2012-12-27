-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1:3306

-- Tempo de Geração: 
-- Versão do Servidor: 5.5.25a
-- Versão do PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `me_salve`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `salve_cidades`
--

CREATE TABLE `salve_cidades` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CIDADE` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `salve_cidades`
--

INSERT INTO `salve_cidades` (`ID`, `CIDADE`) VALUES
(1, 'São Paulo'),
(2, 'Rio de Janeiro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `salve_empresas`
--

CREATE TABLE `salve_empresas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_EMPRESA` varchar(50) NOT NULL,
  `CNPJ` varchar(50) NOT NULL,
  `NOME_CONTATO` varchar(50) NOT NULL,
  `ENDERECO` varchar(100) NOT NULL,
  `TELEFONE` varchar(50) NOT NULL,
  `CIDADE` int(11) NOT NULL,
  `ESTADO` int(11) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `SENHA` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `salve_ofertas`
--

CREATE TABLE `salve_ofertas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CONTA_EMPRESA` int(11) NOT NULL,
  `STATUS` int(11) NOT NULL,
  `DATA_CRIACAO` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DATA_ATIVACAO` datetime DEFAULT NULL,
  `DATA_ENCERRAMENTO` datetime NOT NULL,
  `VALOR_REAL` decimal(10,2) NOT NULL,
  `VALOR_DESCONTO` decimal(10,2) NOT NULL,
  `MINIMO_CUPONS` int(11) NOT NULL,
  `MAXIMO_CUPONS` int(11) DEFAULT NULL,
  `CUPONS_COMPRADOS` int(11) DEFAULT NULL,
  `REGIAO` int(11) NOT NULL,
  `TITULO_OFERTA` varchar(100) NOT NULL,
  `FOTO1` varchar(50) NOT NULL,
  `FOTO2` varchar(50) DEFAULT NULL,
  `FOTO3` varchar(50) DEFAULT NULL,
  `REGULAMENTO` text NOT NULL,
  `DESTAQUES` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `salve_ofertas`
--

INSERT INTO `salve_ofertas` (`ID`, `CONTA_EMPRESA`, `STATUS`, `DATA_CRIACAO`, `DATA_ATIVACAO`, `DATA_ENCERRAMENTO`, `VALOR_REAL`, `VALOR_DESCONTO`, `MINIMO_CUPONS`, `MAXIMO_CUPONS`, `CUPONS_COMPRADOS`, `REGIAO`, `TITULO_OFERTA`, `FOTO1`, `FOTO2`, `FOTO3`, `REGULAMENTO`, `DESTAQUES`) VALUES
(1, 1, 2, '2012-12-10 23:03:11', '2012-12-10 00:00:00', '2012-12-19 00:00:00', '500.00', '250.00', 10, 20, NULL, 1, 'SABONETES EM DESCONTO', 'anjos.jpg', NULL, NULL, 'teste reg1', 'teste dest1'),
(12, 1, 2, '2020-12-12 20:23:40', '2012-12-21 19:06:22', '2020-12-12 22:21:35', '200.00', '40.00', 12, 31, 0, 1, 'teste datas', '00b821dada271ba72ea7fbab7aa9c30d.gif', '', '', 'teste', 'teste2'),
(11, 1, 1, '2020-12-12 20:23:34', '2020-12-12 20:21:30', '2020-12-12 21:21:30', '210.00', '20.00', 21, 322, 0, 1, 'teste 2', '284fb597204b342711b7136ea37542ad.jpg', 'Array', 'Array', 'teste', 'teste2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `salve_status_ofertas`
--

CREATE TABLE `salve_status_ofertas` (
  `ID` int(3) NOT NULL,
  `DESCRICAO` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `salve_status_ofertas`
--

INSERT INTO `salve_status_ofertas` (`ID`, `DESCRICAO`) VALUES
(1, 'Aguardando'),
(2, 'Ativo'),
(3, 'Encerrado'),
(4, 'Concluído');

-- --------------------------------------------------------

--
-- Estrutura da tabela `salve_usuarios`
--

CREATE TABLE `salve_usuarios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOME` varchar(50) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `DATA_NASCIMENTO` date NOT NULL,
  `SEXO` char(1) NOT NULL,
  `REGIÃO` int(11) NOT NULL,
  `SENHA` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
