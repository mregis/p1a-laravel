-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 10-Abr-2018 às 11:43
-- Versão do servidor: 5.7.20-0ubuntu0.17.10.1
-- PHP Version: 7.1.11-0ubuntu0.17.10.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `massad`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `assistent`
--

DROP TABLE IF EXISTS `assistent`;
CREATE TABLE `assistent` (
  `id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` int(150) NOT NULL,
  `value` float(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE `banks` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `banks`
--

INSERT INTO `banks` (`id`, `name`, `company_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Banco do Brasil', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(2, 'Banco Central do Brasil', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(3, 'Banco da Amazônia', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(4, 'Banco do Nordeste do Brasil', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(5, 'Banco Nacional de Desenvolvimento Econômico e Social', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(6, 'Caixa Econômica Federal', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(7, 'Banco Regional de Desenvolvimento do Extremo Sul', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(8, 'Banco de Desenvolvimento de Minas Gerais', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(9, 'Banco de Brasília', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(10, 'Banco do Estado de Sergipe', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(11, 'Banco do Estado do Espírito Santo', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(12, 'Banco do Estado do Pará', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(13, 'Banco do Estado do Rio Grande do Sul', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(14, 'Banco Alfa', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(15, 'Banco Banif', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(16, 'Banco BBM', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(17, 'Banco BMG', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(18, 'Banco Bonsucesso', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(19, 'Banco BTG Pactual', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(20, 'Banco Cacique', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(21, 'Banco Caixa Geral - Brasil', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(22, 'Banco Citibank', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(23, 'Banco Credibel', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(24, 'Banco Credit Suisse', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(25, 'Banco Daycoval', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(26, 'Banco Fator', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(27, 'Banco Fibra', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(28, 'Banco Gerador', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(29, 'Banco Guanabara', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(30, 'Banco Industrial do Brasil', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(31, 'Banco Industrial e Comercial', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(32, 'Banco Indusval', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(33, 'Banco Intermedium', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(34, 'Banco Itaú BBA', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(35, 'Banco ItaúBank', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(36, 'Banco Itaucred Financiamentos', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(37, 'Banco Mercantil do Brasil', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(38, 'Banco Modal', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(39, 'Banco Morada', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(40, 'Banco Pan', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(41, 'Banco Paulista', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(42, 'Banco Pine', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(43, 'Banco Renner', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(44, 'Banco Ribeirão Preto', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(45, 'Banco Safra', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(46, 'Banco Santander', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(47, 'Banco Sofisa', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(48, 'Banco Topázio', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(49, 'Banco Votorantim', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(50, 'Bradesco', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(51, 'Itaú Unibanco', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(52, 'Banco Original', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(53, 'Banco Neon', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL),
(54, 'Nu Pagamentos S.A', 1, '2018-03-05 21:43:48', '2018-03-05 21:43:48', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `bank_account`
--

DROP TABLE IF EXISTS `bank_account`;
CREATE TABLE `bank_account` (
  `id` int(11) NOT NULL,
  `accredited_network_id` int(10) NOT NULL,
  `code_sisfin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_manager` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `obs` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account` int(11) NOT NULL,
  `account_digit` int(11) NOT NULL,
  `cpf_cnpj` int(11) NOT NULL,
  `holder` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `agencia_id` int(11) DEFAULT NULL,
  `tipo_conta_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `collections`
--

DROP TABLE IF EXISTS `collections`;
CREATE TABLE `collections` (
  `id` int(10) NOT NULL,
  `type` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_id` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `configuracoes_smtp`
--

DROP TABLE IF EXISTS `configuracoes_smtp`;
CREATE TABLE `configuracoes_smtp` (
  `id` int(11) NOT NULL,
  `host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `port` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','pending','deleted') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `neighborhood` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `rg` int(11) NOT NULL,
  `cpf` int(11) NOT NULL,
  `birthday` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(10) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `social_name` int(255) NOT NULL,
  `fantasy_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cnpj` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `state_registration` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `municipal_registration` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `financial_officer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `financial_phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `financial_email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `expert`
--

DROP TABLE IF EXISTS `expert`;
CREATE TABLE `expert` (
  `id` int(10) NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lawyers`
--

DROP TABLE IF EXISTS `lawyers`;
CREATE TABLE `lawyers` (
  `id` int(10) NOT NULL,
  `name` int(255) NOT NULL,
  `phone` int(50) NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `lawyers_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sub_menus`
--

DROP TABLE IF EXISTS `sub_menus`;
CREATE TABLE `sub_menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_order` int(11) NOT NULL,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `status`, `last_login`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Rodrigo Gardin', NULL, 'rodrigo@luby.com.br', '$2y$10$b/h3oEzRJvmFF3E6Y7q1AegIDuc/jzHjQyIPD51rAG24.bftoaoQW', 1, NULL, 'txHO97pAMTlcxjBfbxsl6gyHnRvMAOsTWjlg28YGEVxKwWKFPaeUYB0wxGpq', '2018-03-29 20:30:36', '2018-03-29 20:30:36', NULL),
(2, 'Nikolas Fernander', NULL, 'nikolas@luby.com.br', '$2y$10$9rzL0haEQApFOuyMVLeeMup3i33QG0uTJrI9WDlwfJqW/0Dke2Ef.', 1, NULL, NULL, '2018-03-29 20:30:36', '2018-03-29 20:30:36', NULL),
(3, 'Flávio Apolinário', NULL, 'flavio@luby.com.br', '$2y$10$jfrA1OFYrDbPEfbH9spXVOwN8bWn1u99hKOX.TDrkZg4JaSMUlDta', 1, NULL, 'ELpjNj8MKh6XpoRCqfAIqGDOpAf58DMf54fPvtzXqOH26geibSJffW2rZSZe', '2018-03-29 20:30:36', '2018-03-29 20:30:36', NULL),
(4, 'Jancarlo Romero', NULL, 'jancarlo@luby.com.br', '$2y$10$Hb8quuMGuDDwQYUISzym5uGqyzhjmSJ3xbPeObtfBb74zyl43Ca3S', 1, NULL, NULL, '2018-03-29 20:30:36', '2018-03-29 20:30:36', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banks_company_id_foreign` (`company_id`);

--
-- Indexes for table `configuracoes_smtp`
--
ALTER TABLE `configuracoes_smtp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expert`
--
ALTER TABLE `expert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lawyers`
--
ALTER TABLE `lawyers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `sub_menus`
--
ALTER TABLE `sub_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_menus_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expert`
--
ALTER TABLE `expert`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lawyers`
--
ALTER TABLE `lawyers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_menus`
--
ALTER TABLE `sub_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
