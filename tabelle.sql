create database if not exist lavoro;
CREATE TABLE email_queue (
       id INT AUTO_INCREMENT PRIMARY KEY,
       to_address VARCHAR(255) NOT NULL,
       subject VARCHAR(255) NOT NULL,
       message TEXT NOT NULL,
       date_added DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
     );