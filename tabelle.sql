create database if not exists lavoro;

create table if not exists subscribers(
id INT AUTO_INCREMENT PRIMARY KEY,
email varchar(255) NOT NULL
) engine innodb;

create table if not exists email_queue (
       id INT AUTO_INCREMENT PRIMARY KEY,
       subject VARCHAR(255) NOT NULL,
       message TEXT NOT NULL,
       date_added DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
     ) engine innodb;