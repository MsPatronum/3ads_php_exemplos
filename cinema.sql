SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `cinema` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cinema`;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `inserirCliente` (IN `cliente_nome` VARCHAR(255), IN `cliente_cpf` VARCHAR(14), IN `cliente_telefone` VARCHAR(20))  BEGIN
  DECLARE cliente_id INT;
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
    RESIGNAL;
  END;

  START TRANSACTION;

  SELECT id INTO cliente_id FROM clientes WHERE cpf = cliente_cpf;

  IF cliente_id IS NULL THEN
    INSERT INTO clientes (nome, cpf, telefone) VALUES (cliente_nome, cliente_cpf, cliente_telefone);
    COMMIT;
  ELSE
    ROLLBACK;
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cliente já existe na tabela clientes.';
  END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `calcularValorTotalCompra` (`compra_id` INT) RETURNS DECIMAL(8,2) BEGIN
  DECLARE valor_total DECIMAL(8,2);

  SELECT SUM(ingressos.preco * compras_ingressos.qtd_ingresso)
    INTO valor_total
    FROM compras_ingressos
    JOIN ingressos ON compras_ingressos.id_ingresso = ingressos.id
    WHERE compras_ingressos.id_compra = compra_id;

  RETURN valor_total;
END$$

DELIMITER ;

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `clientes` VALUES
(4, 'João Silva', '123.456.789-00', '(11) 9999-8888'),
(5, 'Maria Santos', '987.654.321-00', '(11) 7777-5555'),
(6, 'Pedro Oliveira', '456.789.123-00', '(11) 3333-1111');

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `data_hora` datetime NOT NULL,
  `valor_total` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `compras` VALUES
(13, 4, '2023-05-01 10:00:00', '50.00'),
(14, 5, '2023-05-02 15:30:00', '75.50'),
(15, 6, '2023-05-03 19:45:00', '30.00');

CREATE TABLE `compras_ingressos` (
  `id_compra` int(11) NOT NULL,
  `id_ingresso` int(11) NOT NULL,
  `qtd_ingresso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `compras_ingressos` VALUES
(13, 1, 2),
(13, 2, 3),
(14, 3, 1),
(15, 1, 1),
(15, 3, 2);

CREATE TABLE `filmes` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `duracao` int(11) DEFAULT NULL,
  `classificacao_indicativa` varchar(10) DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `diretor` varchar(50) DEFAULT NULL,
  `sinopse` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `filmes` VALUES
(4, 'Aventura Espacial', 120, 'Livre', 'Aventura', 'John Doe', 'Uma emocionante jornada pelo espaço.'),
(5, 'Drama Urbano', 110, '16+', 'Drama', 'Jane Smith', 'Uma história intensa de amor e desilusão.'),
(6, 'Comédia em Família', 95, 'Livre', 'Comédia', 'Robert Johnson', 'Risadas garantidas para todas as idades.');
CREATE TABLE `filmes_mais_assistidos` (
`titulo` varchar(255)
,`qtd_ingressos_vendidos` bigint(21)
);

CREATE TABLE `ingressos` (
  `id` int(11) NOT NULL,
  `id_sessao` int(11) NOT NULL,
  `preco` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ingressos` VALUES
(1, 7, '20.00'),
(2, 8, '15.50'),
(3, 9, '12.00');

CREATE TABLE `salas` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `capacidade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `salas` VALUES
(4, 1, 100),
(5, 2, 80),
(6, 3, 120);

CREATE TABLE `sessoes` (
  `id` int(11) NOT NULL,
  `id_filme` int(11) NOT NULL,
  `id_sala` int(11) NOT NULL,
  `data_hora` datetime NOT NULL,
  `capacidade_disponivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `sessoes` VALUES
(7, 4, 4, '2023-05-01 14:00:00', 100),
(8, 5, 5, '2023-05-02 18:30:00', 80),
(9, 6, 6, '2023-05-03 20:00:00', 120);
DROP TABLE IF EXISTS `filmes_mais_assistidos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `filmes_mais_assistidos`  AS SELECT `f`.`titulo` AS `titulo`, count(`ci`.`id_ingresso`) AS `qtd_ingressos_vendidos` FROM (((`filmes` `f` join `sessoes` `s` on(`f`.`id` = `s`.`id_filme`)) join `ingressos` `i` on(`s`.`id` = `i`.`id_sessao`)) join `compras_ingressos` `ci` on(`i`.`id` = `ci`.`id_ingresso`)) GROUP BY `f`.`id` ORDER BY count(`ci`.`id_ingresso`) DESC ;


ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

ALTER TABLE `compras_ingressos`
  ADD PRIMARY KEY (`id_compra`,`id_ingresso`),
  ADD KEY `id_ingresso` (`id_ingresso`);

ALTER TABLE `filmes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ingressos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sessao` (`id_sessao`);

ALTER TABLE `salas`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sessoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_filme` (`id_filme`),
  ADD KEY `id_sala` (`id_sala`);


ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `filmes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `ingressos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `salas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `sessoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;


ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);

ALTER TABLE `compras_ingressos`
  ADD CONSTRAINT `compras_ingressos_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id`),
  ADD CONSTRAINT `compras_ingressos_ibfk_2` FOREIGN KEY (`id_ingresso`) REFERENCES `ingressos` (`id`);

ALTER TABLE `ingressos`
  ADD CONSTRAINT `ingressos_ibfk_1` FOREIGN KEY (`id_sessao`) REFERENCES `sessoes` (`id`);

ALTER TABLE `sessoes`
  ADD CONSTRAINT `sessoes_ibfk_1` FOREIGN KEY (`id_filme`) REFERENCES `filmes` (`id`),
  ADD CONSTRAINT `sessoes_ibfk_2` FOREIGN KEY (`id_sala`) REFERENCES `salas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
