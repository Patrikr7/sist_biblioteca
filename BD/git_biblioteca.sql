-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 21-Jun-2020 às 00:01
-- Versão do servidor: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `git_biblioteca`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_books`
--

CREATE TABLE `tb_books` (
  `book_id` int(11) UNSIGNED NOT NULL,
  `book_img` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_publishing` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_author` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_description` longtext COLLATE utf8_unicode_ci,
  `book_categories` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_amount` int(11) DEFAULT NULL,
  `book_launch` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_date` timestamp NULL DEFAULT NULL,
  `book_read` int(11) DEFAULT NULL,
  `book_status` char(2) COLLATE utf8_unicode_ci DEFAULT '1',
  `book_url` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_books`
--

INSERT INTO `tb_books` (`book_id`, `book_img`, `book_title`, `book_publishing`, `book_author`, `book_description`, `book_categories`, `book_amount`, `book_launch`, `book_date`, `book_read`, `book_status`, `book_url`) VALUES
(2, 'anonymous.jpg', 'Anonymous', 'Editora Abril', 'Anonymous', 'Testando edição do livro com imagem.', '1,2,3', 5, '2005', '2020-03-16 13:18:58', 0, '1', 'anonymous'),
(4, 'seja-foda-.jpg', 'Seja Foda!', 'Editora Abril', 'Desconhecido', 'Descrição do Livro!', '5,6', 10, '2008', '2020-03-16 13:19:12', 1, '1', 'seja-foda-'),
(5, 'the-flash.jpg', 'The Flash', 'Mônaco', 'Barry Allien', 'Descrição do livro!', '1,2,3', 15, '2018', '2020-03-16 18:48:27', 0, '1', 'the-flash'),
(6, 'liga-da-justica.jpg', 'Liga da Justiça', 'DC Comics', 'DC Comics', 'Descrição', '5', 9, '2004', '2020-06-21 02:55:45', 0, '1', 'liga-da-justica'),
(7, 'supergirl.jpg', 'Supergirl', 'Supergirl', 'Supergirl', 'Série de super héroi.', '1,5', 24, '2017', '2020-03-16 14:05:48', 1, '1', 'supergirl');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_book_categories`
--

CREATE TABLE `tb_book_categories` (
  `cat_id` int(11) UNSIGNED NOT NULL,
  `cat_parent` int(11) UNSIGNED DEFAULT NULL,
  `cat_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cat_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_book_categories`
--

INSERT INTO `tb_book_categories` (`cat_id`, `cat_parent`, `cat_title`, `cat_url`) VALUES
(1, NULL, 'Avó', 'avo'),
(2, 1, 'Pai', 'pai'),
(3, 2, 'Filho', 'filho'),
(4, NULL, 'Avó 2', 'avo-2'),
(5, NULL, 'Avó 3', 'avo-3'),
(6, NULL, 'Primeiro Teste', 'primeiro-teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_book_leased`
--

CREATE TABLE `tb_book_leased` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_client` int(11) UNSIGNED DEFAULT NULL,
  `id_book` int(11) UNSIGNED DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `date_returned` timestamp NULL DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `leased` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_book_leased`
--

INSERT INTO `tb_book_leased` (`id`, `id_client`, `id_book`, `date_start`, `date_end`, `date_returned`, `description`, `leased`) VALUES
(3, 1, 2, '2020-03-12', '2020-03-15', '2020-03-12 19:43:54', 'Teste de Reserva!', '0'),
(6, 6, 2, '2020-03-12', '2020-04-20', '2020-03-12 19:52:07', '', '0'),
(10, 4, 2, '2020-03-13', '2020-04-20', '2020-03-13 14:05:29', '', '0'),
(12, 1, 2, '2020-03-13', '2020-04-20', '2020-03-13 14:10:10', '', '0'),
(22, 6, 2, '2020-03-13', '2020-04-20', '2020-03-13 14:42:13', '', '0'),
(24, 1, 5, '2020-03-16', '2020-03-20', '2020-03-16 13:52:42', '', '0'),
(26, 11, 6, '2020-03-16', '2020-03-18', '2020-03-19 20:39:00', '', '0'),
(27, 4, 7, '2020-03-16', '2020-04-20', NULL, '', '1'),
(28, 7, 4, '2020-03-16', '2020-03-17', '2020-03-19 20:37:51', '', '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_client`
--

CREATE TABLE `tb_client` (
  `clt_id` int(11) UNSIGNED NOT NULL,
  `clt_name` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_img` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_email` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_cpf` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_rg` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_nasc` date DEFAULT NULL,
  `clt_tel_cel` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_cel` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_genero` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addr_zipcode` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addr_street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addr_number` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addr_comp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addr_state` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addr_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addr_district` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addr_country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_pass` varchar(300) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  `clt_cpass` varchar(300) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  `clt_status` int(3) UNSIGNED DEFAULT NULL,
  `clt_obs` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_url` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_cod` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_client`
--

INSERT INTO `tb_client` (`clt_id`, `clt_name`, `clt_img`, `clt_email`, `clt_cpf`, `clt_rg`, `clt_nasc`, `clt_tel_cel`, `clt_cel`, `clt_genero`, `addr_zipcode`, `addr_street`, `addr_number`, `addr_comp`, `addr_state`, `addr_city`, `addr_district`, `addr_country`, `clt_pass`, `clt_cpass`, `clt_status`, `clt_obs`, `clt_url`, `clt_cod`, `clt_date`) VALUES
(1, 'Emerson Patrik Ribeiro', 'emerson-patrik-ribeiro.jpg', 'patrikr11@gmail.com', '56303193374', '159692878', '1989-09-18', '(16) 00000-0000', '(16) 00000-0000', 'M', '13563304', 'Rua Marcus Vinícius de Mello Moraes', '1425', 'Casa', 'SP', 'São Carlos', 'Parque Santa Felícia Jardim', 'Brasil', '$1$l.se.7/d$F2Su8mNPKuSYLTO/KBPeB1\n', '$1$l.se.7/d$F2Su8mNPKuSYLTO/KBPeB1\n', 1, 'Cliente', 'emerson-patrik-ribeiro', '0DWB28QB0TMKP2UFGR50MM45167UIIQJ7YK9O72F0F2', '2017-12-19 02:23:56'),
(4, 'Roberta Souza', 'roberta-souza.jpg', 'robertasouza@gmail.com', '76822106219', '461481333', '1994-05-17', '(16) 00000-0000', '(16) 00000-0000', 'F', '13560648', 'Rua Conde do Pinhal', '1060', 'Casa', 'SP', 'São Carlos', 'Jardim São Carlos', 'Brasil', '$1$l.se.7/d$F2Su8mNPKuSYLTO/KBPeB1\n', '$1$l.se.7/d$F2Su8mNPKuSYLTO/KBPeB1\n', 1, '', 'roberta-souza', 'LV96920T2XRS4MD30Z86V64Z9VD1CW9IA153ZKMJ2X81', '2017-12-19 02:43:26'),
(6, 'Isaac Vinicius', 'isaac-vinicius.jpg', 'isaac@gmail.com', '63748284373', '4614825823', '1989-09-18', '(16) 00000-0000', '(16) 00000-0000', 'M', '13560010', 'Avenida São Carlos', '1010', 'Casa', 'SP', 'São Carlos', 'Centro', 'Brasil', '$1$l.se.7/d$vVvRdpxDVUoe.IpxVt.ai/\n', '$1$l.se.7/d$vVvRdpxDVUoe.IpxVt.ai/\n', 1, 'Cliente', 'isaac-vinicius', 'DLUR1AVRHZPHA9F0WHBFW8VWFOYRUUODSV5E2OYI2', '2018-04-25 03:47:56'),
(7, 'Luis Miguel', 'luis-miguel.jpg', 'luismiguel@gmail.com', '75818326519', '154223652', '1989-09-18', '(16) 00000-0000', '(16) 00000-0000', 'M', '13563330', 'Rua Joaquim', '1425', 'Casa', 'SP', 'São Carlos', 'Parque Santa Felícia Jardim', 'Brasil', '$2y$10$tF47KK3nlDXqpV3pcpqCDev6qIU9VYAo7qqow.U2pVqpLsQulpQdm', '$2y$10$hj3AVpiVTW3D/X4zAF6g4uwdG4LddIzvhzv6pVD7/QZkJdArI3jMm', 1, '', 'luis-miguel', '5SFU97E22FYXQ15QKRFD4RKP2I47GHQJ5KQHQIDZ645T', '2018-08-23 04:09:16'),
(11, 'Testando Cadastro Jr', 'testando-cadastro-jr.jpg', 'teste@teste.com.br', '79261699006', '461481339', '1989-09-18', '123456789', '123456789', 'M', '13563-330', 'Joaquim Augusto', '1060', 'Casa', 'SP', 'São Carlos', 'Santa Felicia', 'Brasil', NULL, NULL, 1, 'Testando cadastro de atualização com foto! Ok.', 'testando-cadastro-jr', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_status`
--

CREATE TABLE `tb_status` (
  `st_id` int(11) UNSIGNED NOT NULL,
  `st_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `st_status` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_status`
--

INSERT INTO `tb_status` (`st_id`, `st_title`, `st_status`) VALUES
(1, 'Ativo', 1),
(2, 'Inativo', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_books`
--
ALTER TABLE `tb_books`
  ADD UNIQUE KEY `book_id` (`book_id`),
  ADD KEY `book_categories` (`book_categories`);

--
-- Indexes for table `tb_book_categories`
--
ALTER TABLE `tb_book_categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `tb_book_leased`
--
ALTER TABLE `tb_book_leased`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_id_clt` (`id_client`),
  ADD KEY `fk_id_book` (`id_book`);

--
-- Indexes for table `tb_client`
--
ALTER TABLE `tb_client`
  ADD PRIMARY KEY (`clt_id`),
  ADD UNIQUE KEY `clt_id` (`clt_id`),
  ADD UNIQUE KEY `clt_email` (`clt_email`),
  ADD UNIQUE KEY `clt_cpf` (`clt_cpf`),
  ADD UNIQUE KEY `clt_rg` (`clt_rg`),
  ADD KEY `clt_status` (`clt_status`) USING BTREE;

--
-- Indexes for table `tb_status`
--
ALTER TABLE `tb_status`
  ADD PRIMARY KEY (`st_id`),
  ADD UNIQUE KEY `st_id` (`st_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_books`
--
ALTER TABLE `tb_books`
  MODIFY `book_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_book_categories`
--
ALTER TABLE `tb_book_categories`
  MODIFY `cat_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_book_leased`
--
ALTER TABLE `tb_book_leased`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tb_client`
--
ALTER TABLE `tb_client`
  MODIFY `clt_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_book_leased`
--
ALTER TABLE `tb_book_leased`
  ADD CONSTRAINT `fk_id_book` FOREIGN KEY (`id_book`) REFERENCES `tb_books` (`book_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_clt` FOREIGN KEY (`id_client`) REFERENCES `tb_client` (`clt_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_client`
--
ALTER TABLE `tb_client`
  ADD CONSTRAINT `fk_clt_status` FOREIGN KEY (`clt_status`) REFERENCES `tb_status` (`st_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
