CREATE DATABASE database;

USE database;

CREATE TABLE users (
    username VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL
);

INSERT INTO users (username, password) VALUES ('admin-nhom10', 'admin-nhom10');