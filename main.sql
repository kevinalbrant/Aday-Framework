--
-- Create Database cms
--

CREATE DATABASE cms;
USE cms;

--
-- Tablestructure for the table `config`
--

DROP TABLE IF EXISTS `config`;

CREATE TABLE IF NOT EXISTS `config`(
    `config_ID` INT NOT NULL AUTO_INCREMENT,
    `value` VARCHAR(255),
    `description` VARCHAR(255),
    PRIMARY KEY(`config_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablestructure for the table `user`
--

DROP TABLE IF EXISTS `user`;

CREATE TABLE IF NOT EXISTS `user`(
    `user_ID` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45),
    `surname` VARCHAR(45),
    `username` VARCHAR(45),
    `password` VARCHAR(128),
    PRIMARY KEY(`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablestructure for the table `login_cache`
--

DROP TABLE IF EXISTS `login_cache`;

CREATE TABLE IF NOT EXISTS `login_cache`(
    `login_cache_ID` INT NOT NULL AUTO_INCREMENT,
    `hash` VARCHAR(128),
    `date_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `user_ID` INT NOT NULL,
    PRIMARY KEY(`login_cache_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablestructure for the table `password_attempts`
--
DROP TABLE IF EXISTS `password_attempts`;

CREATE TABLE IF NOT EXISTS `password_attempts`(
    `password_attempts_ID` INT NOT NULL AUTO_INCREMENT,
    `ip` VARCHAR(39) ,
    `attempt_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`password_attempts_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablestructure for the table `api_user`
--
DROP TABLE IF EXISTS `api_user`;

CREATE TABLE IF NOT EXISTS `api_user`(
    `api_user_ID` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(45),
    `password` VARCHAR(128),
    PRIMARY KEY(`api_user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablestructure for the table `api_login_cache`
--

DROP TABLE IF EXISTS `api_login_cache`;

CREATE TABLE IF NOT EXISTS `api_login_cache`(
    `api_login_cache_ID` INT NOT NULL AUTO_INCREMENT,
    `hash` VARCHAR(128),
    `date_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `api_user_ID` INT NOT NULL,
    PRIMARY KEY(`api_login_cache_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Add foreign-keys for the table `login_cache`
--

ALTER TABLE `login_cache`
ADD FOREIGN KEY(`user_ID`) REFERENCES `user`(`user_ID`);

--
-- Add foreign-keys for the table `api_login_cache`
--

ALTER TABLE `api_login_cache`
ADD FOREIGN KEY(`api_user_ID`) REFERENCES `api_user`(`api_user_ID`);

--
-- Data for the table `user`
--

INSERT INTO 
    user(`name`, `surname`, `username`, `password`)
VALUES
    ('admin', 'admin', 'admin', '263296fd28537b115cd258eb351717b8a5cca6c505a2222ccd3efd8e52f366a7b1e65d0081b63d732bd97bd343d185ae27b52f69eaf4650e480d252babbe0632');

--
-- Data for the table `api_users`
--
INSERT INTO 
    api_user(`username`, `password`)
VALUES
    ('admin', '263296fd28537b115cd258eb351717b8a5cca6c505a2222ccd3efd8e52f366a7b1e65d0081b63d732bd97bd343d185ae27b52f69eaf4650e480d252babbe0632');