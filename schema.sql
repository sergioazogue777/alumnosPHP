CREATE DATABASE IF NOT EXISTS proyecto1eval CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE proyecto1eval;

CREATE TABLE IF NOT EXISTS usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    correo_usuario VARCHAR(255) NOT NULL UNIQUE,
    nombre_usuario VARCHAR(120) NOT NULL,
    contrasenya_usuario VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS alumnos (
    id_alumno INT AUTO_INCREMENT PRIMARY KEY,
    dni_alumno VARCHAR(20) NOT NULL UNIQUE,
    nombre_alumno VARCHAR(150) NOT NULL,
    direccion_alumno VARCHAR(255) NOT NULL DEFAULT '',
    poblacion_alumno VARCHAR(150) NOT NULL DEFAULT '',
    created_by VARCHAR(120) NOT NULL,
    created_date DATE NOT NULL
);
