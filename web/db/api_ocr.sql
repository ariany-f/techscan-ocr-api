-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/02/2024 às 19:01
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `api_ocr`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `apis_users_status`
--

CREATE TABLE `apis_users_status` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tabela truncada antes do insert `apis_users_status`
--

TRUNCATE TABLE `apis_users_status`;
--
-- Despejando dados para a tabela `apis_users_status`
--

INSERT INTO `apis_users_status` (`id`, `descricao`) VALUES
(1, 'Ativo'),
(2, 'Desativado');
-- --------------------------------------------------------

--
-- Estrutura para tabela `api_users`
--

CREATE TABLE `api_users` (
  `id` int(11) NOT NULL,
  `token` varchar(45) DEFAULT NULL,
  `expire` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tabela truncada antes do insert `api_users`
--

TRUNCATE TABLE `api_users`;
--
-- Despejando dados para a tabela `api_users`
--

INSERT INTO `api_users` (`id`, `token`, `expire`, `status`) VALUES
(1, '123', '2024-01-31 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cameras`
--

CREATE TABLE `cameras` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `direction` int(11) DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  `representative_img_id` int(11) DEFAULT NULL,
  `gate_id` int(11) DEFAULT NULL,
  `api_origin` int(11) DEFAULT NULL,
  `external_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `directions`
--

CREATE TABLE `directions` (
  `id` int(11) NOT NULL,
  `description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tabela truncada antes do insert `directions`
--

TRUNCATE TABLE `directions`;
--
-- Despejando dados para a tabela `directions`
--

INSERT INTO `directions` (`id`, `description`) VALUES
(1, 'Entrada'),
(2, 'Saída'),
(3, 'failed to determine direction');

-- --------------------------------------------------------

--
-- Estrutura para tabela `external_apis`
--

CREATE TABLE `external_apis` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `url` varchar(45) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tabela truncada antes do insert `external_apis`
--

TRUNCATE TABLE `external_apis`;
--
-- Despejando dados para a tabela `external_apis`
--

INSERT INTO `external_apis` (`id`, `name`, `url`, `login`, `password`) VALUES
(1, 'securos', '127.0.0.1:8890', 'admin', 'securos'),
(2, 'securos', '127.0.0.1:8899', 'admin', 'securos');

-- --------------------------------------------------------

--
-- Estrutura para tabela `gates`
--

CREATE TABLE `gates` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `api_origin` int(11) DEFAULT NULL,
  `external_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `requested_at` datetime DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `passages`
--

CREATE TABLE `passages` (
  `id` int(11) NOT NULL,
  `plate` varchar(45) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `container` varchar(45) DEFAULT NULL,
  `id_gate` varchar(45) DEFAULT NULL,
  `direction` int(11) DEFAULT NULL,
  `external_id` varchar(45) DEFAULT NULL,
  `api_origin` int(11) DEFAULT NULL,
  `camera` int(11) DEFAULT NULL,
  `is_ok` tinyint(1) NOT NULL DEFAULT 0,
  `preset_reason` int(11) DEFAULT NULL,
  `description_reason` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `passage_images`
--

CREATE TABLE `passage_images` (
  `id` int(11) NOT NULL,
  `url` varchar(1255) DEFAULT NULL,
  `passage_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tabela truncada antes do insert `permissions`
--

TRUNCATE TABLE `permissions`;
--
-- Despejando dados para a tabela `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'Administrador'),
(2, 'Operador');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reasons`
--

CREATE TABLE `reasons` (
  `id` int(11) NOT NULL,
  `description` longtext DEFAULT NULL,
  `is_ocr_error` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tabela truncada antes do insert `reasons`
--

TRUNCATE TABLE `reasons`;
--
-- Despejando dados para a tabela `reasons`
--

INSERT INTO `reasons` (`id`, `description`, `is_ocr_error`) VALUES
(1, 'Placa Ilegível', 0),
(2, 'Sem Placa', 0),
(3, 'Placa danificada', 0),
(4, 'Placa Coberta', 0),
(6, 'Câmera suja', 1),
(7, 'Erro de OCR', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `representative_img`
--

CREATE TABLE `representative_img` (
  `id` int(11) NOT NULL,
  `url` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tabela truncada antes do insert `representative_img`
--

TRUNCATE TABLE `representative_img`;
--
-- Despejando dados para a tabela `representative_img`
--

INSERT INTO `representative_img` (`id`, `url`) VALUES
(1, 'frente'),
(2, 'traseira'),
(3, 'placa'),
(4, 'lateral direita'),
(5, 'lateral esquerda'),
(6, 'superior');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tabela truncada antes do insert `users`
--

TRUNCATE TABLE `users`;
--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `permission_id`, `created_at`, `status`, `password`) VALUES
(1, 'admin@admin.com.br', 'Admin', 1, '2024-01-23 16:53:07', 1, '1e2f992ecec3a6020f05a16aecb098c408dbf953');

-- --------------------------------------------------------


CREATE TABLE `securos_websocket` (
  `id` int(11) NOT NULL,
  `request_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`request_json`)),
  `action` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `camera` int(11) NOT NULL,
  `recognizer` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `time_enter` varchar(255) NOT NULL,
  `time_leave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


TRUNCATE TABLE `securos_websocket`;

--
-- Estrutura para tabela `users_status`
--

CREATE TABLE `users_status` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `api_ocr`.`passage_bind` (
  `id` INT NOT NULL AUTO_INCREMENT,
  'description' varchar(255) NULL,
  PRIMARY KEY (`id`));



--
-- Tabela truncada antes do insert `users_status`
--

TRUNCATE TABLE `users_status`;
--
-- Despejando dados para a tabela `users_status`
--

INSERT INTO `users_status` (`id`, `descricao`) VALUES
(1, 'Ativo'),
(2, 'Desativado');


--
-- Estrutura para tabela `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `options`
--

INSERT INTO `options` (`id`, `description`, `value`) VALUES
(1, 'register_collapse_seconds', '30');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--


--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `apis_users_status`
--
ALTER TABLE `apis_users_status`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `api_users`
--
ALTER TABLE `api_users`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cameras`
--
ALTER TABLE `cameras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `external_id_external_api_reference` (`api_origin`,`external_id`),
  ADD KEY `direction_id_cameras` (`direction`),
  ADD KEY `representative_img_id` (`representative_img_id`);

--
-- Índices de tabela `directions`
--
ALTER TABLE `directions`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `external_apis`
--
ALTER TABLE `external_apis`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `gates`
--
ALTER TABLE `gates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `external_id_external_api` (`api_origin`,`external_id`);

--
-- Índices de tabela `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `passages`
--
ALTER TABLE `passages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plate_datetime` (`plate`,`datetime`,`id_gate`) USING BTREE,
  ADD KEY `external_api_id` (`api_origin`),
  ADD KEY `camera_id` (`camera`);

--
-- Índices de tabela `passage_images`
--
ALTER TABLE `passage_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passage_id_fk` (`passage_id`);

--
-- Índices de tabela `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `reasons`
--
ALTER TABLE `reasons`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `representative_img`
--
ALTER TABLE `representative_img`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users_status`
--
ALTER TABLE `users_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- Índices de tabela `securos_websocket`
--
ALTER TABLE `securos_websocket`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabela `securos_websocket`
--
ALTER TABLE `securos_websocket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;
COMMIT;

--
-- AUTO_INCREMENT de tabela `apis_users_status`
--
ALTER TABLE `apis_users_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `api_users`
--
ALTER TABLE `api_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `cameras`
--
ALTER TABLE `cameras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `directions`
--
ALTER TABLE `directions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `external_apis`
--
ALTER TABLE `external_apis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `gates`
--
ALTER TABLE `gates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `passages`
--
ALTER TABLE `passages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `passage_images`
--
ALTER TABLE `passage_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `reasons`
--
ALTER TABLE `reasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `representative_img`
--
ALTER TABLE `representative_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `users_status`
--
ALTER TABLE `users_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;



--
-- AUTO_INCREMENT de tabela `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cameras`
--
ALTER TABLE `cameras`
  ADD CONSTRAINT `direction_id_cameras` FOREIGN KEY (`direction`) REFERENCES `directions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `external_api_id_cameras` FOREIGN KEY (`api_origin`) REFERENCES `external_apis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `representative_img_id` FOREIGN KEY (`representative_img_id`) REFERENCES `representative_img` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Restrições para tabelas `passages`
--
ALTER TABLE `passages`
  ADD CONSTRAINT `camera_id` FOREIGN KEY (`camera`) REFERENCES `cameras` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `external_api_id` FOREIGN KEY (`api_origin`) REFERENCES `external_apis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `passage_images`
--
ALTER TABLE `passage_images`
  ADD CONSTRAINT `passage_id_fk` FOREIGN KEY (`passage_id`) REFERENCES `passages` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

ALTER TABLE `passages` ADD `bind_id` INT NOT NULL AFTER `updated_by`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
