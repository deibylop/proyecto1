-- -------------------------------------------------------------
-- TablePlus 5.4.2(506)
--
-- https://tableplus.com/
--
-- Database: proyecto1
-- Generation Time: 2023-10-08 00:21:46.6330
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(120) NOT NULL,
  `description` varchar(255) NOT NULL,
  `state` varchar(10) NOT NULL,
  `due_date` datetime NOT NULL,
  `edited` tinyint(1) NOT NULL DEFAULT '0',
  `responsible` varchar(100) NOT NULL,
  `task_type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `tasks` (`id`, `title`, `description`, `state`, `due_date`, `edited`, `responsible`, `task_type`) VALUES
(2, 'Comprar leche', 'Comprar leche en el supermercado', 'por hacer', '2023-10-10 10:00:00', 0, 'Juan Pérez', 'Compras'),
(4, 'Comprar leche', 'Comprar leche en el supermercado', 'por hacer', '2023-10-10 10:00:00', 0, 'Juan Pérez', 'Compras'),
(5, 'Llamar al doctor', 'Llamar al doctor para programar una cita', 'por hacer', '2023-10-11 12:00:00', 0, 'María López', 'Salud');

DELIMITER //

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_task`(
  IN id INT
)
BEGIN
  DELETE FROM tasks
  WHERE
    id = id;
END;
//

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_tasks`()
BEGIN
  SELECT
    id,
    title,
    description,
    state,
    due_date,
    edited,
    responsible,
    task_type
  FROM
    tasks;
END;
//

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_tasks`(
  IN title VARCHAR(255),
  IN description VARCHAR(255),
  IN state VARCHAR(255),
  IN due_date DATETIME,
  IN edited TINYINT(1),
  IN responsible VARCHAR(255),
  IN task_type VARCHAR(255)
)
BEGIN
  INSERT INTO tasks (
    title,
    description,
    state,
    due_date,
    edited,
    responsible,
    task_type
  )
  VALUES (
    title,
    description,
    state,
    due_date,
    edited,
    responsible,
    task_type
  );
END;
//

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_task`(
  IN id INT,
  IN title VARCHAR(255),
  IN description VARCHAR(255),
  IN state VARCHAR(255),
  IN due_date DATETIME,
  IN edited TINYINT(1),
  IN responsible VARCHAR(255),
  IN task_type VARCHAR(255)
)
BEGIN
  UPDATE tasks
  SET
    title = title,
    description = description,
    state = state,
    due_date = due_date,
    edited = edited,
    responsible = responsible,
    task_type = task_type
  WHERE
    id = id;
END;
//

DELIMITER ;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;