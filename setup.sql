CREATE DATABASE IF NOT EXISTS car_workshop;
USE car_workshop;

CREATE TABLE users(
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100), email VARCHAR(100) UNIQUE,
 password VARCHAR(255)
);

CREATE TABLE mechanics(
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100)
);

CREATE TABLE appointments(
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT, date DATE, mechanic_id INT,
 FOREIGN KEY (user_id) REFERENCES users(id),
 FOREIGN KEY (mechanic_id) REFERENCES mechanics(id)
);

CREATE TABLE admins(
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(100), password VARCHAR(255)
);

INSERT INTO mechanics(name) VALUES ('M1'),('M2'),('M3');
INSERT INTO admins(username,password) VALUES ('admin','admin123');

