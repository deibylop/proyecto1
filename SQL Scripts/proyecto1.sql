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
    `state` varchar(15) NOT NULL,
    `due_date` datetime NOT NULL,
    `edited` tinyint(1) NOT NULL DEFAULT '0',
    `responsible` varchar(100) NOT NULL,
    `task_type` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT fk_type FOREIGN KEY (task_type) REFERENCES task_type(id)  
  ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;



  INSERT INTO `tasks` (`id`, `title`, `description`, `state`, `due_date`, `edited`, `responsible`, `task_type`) VALUES
  (2, 'Comprar pan', 'Comprar leche en el supermercado', 'por hacer', '2023-10-10 10:00:00', 0, 'Juan Pérez', (select id from task_type where title like 'Compras')),
  (5, 'Llamar al doctor', 'Llamar al doctor para programar una cita', 'por hacer', '2023-10-11 12:00:00', 0, 'María López', (select id from task_type where title like 'Salud'));

  DELIMITER //

  CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_task`(
    IN pid INT
  )
  BEGIN
    DELETE FROM tasks
    WHERE
      id = pid;
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
    IN pid INT,
    IN ptitle VARCHAR(255),
    IN pdescription VARCHAR(255),
    IN pstate VARCHAR(255),
    IN pdue_date DATETIME,
    IN pedited TINYINT(1),
    IN presponsible VARCHAR(255),
    IN ptask_type VARCHAR(255)
  )
  BEGIN
    UPDATE tasks
    SET
      title = ptitle,
      description = pdescription,
      state = pstate,
      due_date = pdue_date,
      edited = pedited,
      responsible = presponsible,
      task_type = ptask_type
    WHERE
      id = pid;
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


  CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_tasksbystate`(
    IN pstate VARCHAR(255)
  )

  BEGIN
    SELECT
      t.id,
      t.title,
      t.description,
      t.state,
      t.due_date,
      t.edited,
      t.responsible,
      tt.id task_type,
      tt.icon,
      tt.title tipo
    FROM tasks t
    LEFT JOIN task_type tt
    on t.task_type = tt.id
    where t.state like pstate;
  END;


  --ALTER TABLE tasks ADD FOREIGN KEY (task_type) REFERENCES task_type(id);

  CREATE TABLE `task_type` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(120) NOT NULL,
    `icon` varchar(50) NOT NULL,
    PRIMARY KEY (`id`) 
  ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

  insert into task_type(title,icon)values('Personal','<i class="bi bi-person-badge-fill"></i>');
  insert into task_type(title,icon)values('Trabajo','<i class="bi bi-briefcase-fill"></i>');
  insert into task_type(title,icon)values('Compras','<i class="bi bi-cart4"></i>');
  insert into task_type(title,icon)values('Salud','<i class="bi bi-clipboard2-pulse"></i>');
  insert into task_type(title,icon)values('Programación','<i class="bi bi-code-slash"></i>');
  insert into task_type(title,icon)values('Educación','<i class="bi bi-book"></i>');
  insert into task_type(title,icon)values('Finanzas','<i class="bi bi-piggy-bank"></i>');

  CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_tasktype`()

  BEGIN
    SELECT
      id,
      title,
      icon
    FROM
      task_type;
  END;


  CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_tasksbyid`(
      IN pid INT
  )
  BEGIN
    SELECT
      t.id,
      t.title,
      t.description,
      t.state,
      t.due_date,
      t.edited,
      t.responsible,
      tt.id task_type,
      tt.icon,
      tt.title tipo
    FROM tasks t
    LEFT JOIN task_type tt
    on t.task_type = tt.id
    where t.id like pid;
  END;
  //

  DROP PROCEDURE IF EXISTS `sp_get_tasksbygroup`;
  CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_tasksbygroup`(
    IN mode  VARCHAR(1),
    IN pgroup VARCHAR(15)
  )
  BEGIN
    IF mode = 'D' THEN
      SELECT
        t.state group_order,
        t.state group_column,
        case when (dense_rank() over (partition by t.state order by t.state,t.due_date,t.id)) = 1 then COUNT(t.state) OVER (PARTITION BY t.state) else 0 end  as group_total,
        t.id,
        t.title,
        t.state,
        t.due_date,
        tt.title tipo
      FROM tasks t
      LEFT JOIN task_type tt
      on t.task_type = tt.id
      where pgroup = 'state'
      union
        SELECT
        tt.title group_order,
        tt.title group_column,
        case when (dense_rank() over (partition by tt.title order by tt.title,t.due_date,t.id)) = 1 then COUNT(tt.title) OVER (PARTITION BY tt.title) else 0 end  as group_total,
        t.id,
        t.title,
        t.state,
        t.due_date,
        tt.title tipo
      FROM tasks t
      INNER JOIN task_type tt
      on t.task_type = tt.id
      where pgroup = 'task_type'
      union
        SELECT
        t.due_date group_order,
        DATE_FORMAT(t.due_date, '%d-%m-%Y') group_column,
        case when (dense_rank() over (partition by t.due_date order by t.due_date,t.id)) = 1 then COUNT(t.due_date) OVER (PARTITION BY t.due_date) else 0 end  as group_total,
        t.id,
        t.title,
        t.state,
        t.due_date,
        tt.title tipo
      FROM tasks t
      LEFT JOIN task_type tt
      on t.task_type = tt.id
      where pgroup = 'due_date_date'
      union
      SELECT
        DATE_ADD(t.due_date, INTERVAL(-WEEKDAY(t.due_date)) DAY)group_order,
        DATE_FORMAT(DATE_ADD(t.due_date, INTERVAL(-WEEKDAY(t.due_date)) DAY), '%d-%m-%Y')  group_column,
        case when (dense_rank() over (partition by DATE_FORMAT(DATE_ADD(t.due_date, INTERVAL(-WEEKDAY(t.due_date)) DAY), '%d-%m-%Y') order by DATE_FORMAT(DATE_ADD(t.due_date, INTERVAL(-WEEKDAY(t.due_date)) DAY), '%d-%m-%Y'),t.due_date,t.id)) = 1 then COUNT(DATE_FORMAT(DATE_ADD(t.due_date, INTERVAL(-WEEKDAY(t.due_date)) DAY), '%d-%m-%Y')) OVER (PARTITION BY DATE_FORMAT(DATE_ADD(t.due_date, INTERVAL(-WEEKDAY(t.due_date)) DAY), '%d-%m-%Y')) else 0 end  as group_total,
        t.id,
        t.title,
        t.state,
        t.due_date,
        tt.title tipo
      FROM tasks t
      LEFT JOIN task_type tt
      on t.task_type = tt.id
      where pgroup = 'due_date_week'
      union
        SELECT
        DATE_FORMAT(t.due_date, '%Y-%m') group_order,
        DATE_FORMAT(t.due_date, '%Y-%m') group_column,
        case when (dense_rank() over (partition by DATE_FORMAT(t.due_date, '%Y-%m')order by DATE_FORMAT(t.due_date, '%Y-%m'),t.due_date,t.id)) = 1 then COUNT(DATE_FORMAT(t.due_date, '%Y-%m')) OVER (PARTITION BY DATE_FORMAT(t.due_date, '%Y-%m')) else 0 end  as group_total,
        t.id,
        t.title,
        t.state,
        t.due_date,
        tt.title tipo
      FROM tasks t
      LEFT JOIN task_type tt
      on t.task_type = tt.id
      where pgroup = 'due_date_month'
      union
        SELECT
        DATE_FORMAT(t.due_date, '%Y') group_order,
        DATE_FORMAT(t.due_date, '%Y') group_column,
        case when (dense_rank() over (partition by DATE_FORMAT(t.due_date, '%Y')order by DATE_FORMAT(t.due_date, '%Y'),t.due_date,t.id)) = 1 then COUNT(DATE_FORMAT(t.due_date, '%Y')) OVER (PARTITION BY DATE_FORMAT(t.due_date, '%Y')) else 0 end  as group_total,
        t.id,
        t.title,
        t.state,
        t.due_date,
        tt.title tipo
      FROM tasks t
      LEFT JOIN task_type tt
      on t.task_type = tt.id
      where pgroup = 'due_date_year';
    elseif mode = 'G' then
      SELECT
        t.state group_column,
        count(*)total
      FROM tasks t
      where pgroup = 'state'
      group by t.state
      union
        SELECT
        tt.title group_column,
        count(*)total
      FROM tasks t
      INNER JOIN task_type tt
      on t.task_type = tt.id
      where pgroup = 'task_type'
      group by tt.title
      union
        SELECT
        DATE_FORMAT(t.due_date, '%d-%m-%Y') group_column,
        count(*)total
      FROM tasks t
      where pgroup = 'due_date_date'
      group by DATE_FORMAT(t.due_date, '%d-%m-%Y')
      union
      SELECT
        DATE_FORMAT(DATE_ADD(t.due_date, INTERVAL(-WEEKDAY(t.due_date)) DAY), '%d-%m-%Y')  group_column,
        count(*)total
      FROM tasks t
      where pgroup = 'due_date_week'
      group by DATE_FORMAT(DATE_ADD(t.due_date, INTERVAL(-WEEKDAY(t.due_date)) DAY), '%d-%m-%Y')
      union
        SELECT
        DATE_FORMAT(t.due_date, '%Y-%m') group_column,
        count(*)total
      FROM tasks t
      where pgroup = 'due_date_month'
      group by DATE_FORMAT(t.due_date, '%Y-%m')
      union
        SELECT
        DATE_FORMAT(t.due_date, '%Y') group_column,
        count(*)total
      FROM tasks t
      where pgroup = 'due_date_year'
      group by DATE_FORMAT(t.due_date, '%Y');
    END IF;
    
  END;
  //