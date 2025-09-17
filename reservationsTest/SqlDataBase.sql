CREATE DATABASE IF NOT EXISTS reservationstest;
USE reservationstest;

CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    reservation_date DATE NOT NULL,
    guests INT NOT NULL
);