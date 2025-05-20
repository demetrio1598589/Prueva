CREATE DATABASE asistencia_db;

USE asistencia_db;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario') NOT NULL DEFAULT 'usuario'
);

CREATE TABLE asistencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Insertar usuarios de prueba (contraseñas son "password123" hasheadas)
INSERT INTO usuarios (nombre, usuario, password, rol) VALUES
('Ana Pérez', 'ana', '123', 'usuario'),
('Carlos Gómez', 'carlos', '123', 'usuario'),
('Lucía Torres', 'admin', '123', 'admin'),
('Mario Rodríguez', 'mario', '123', 'usuario');

-- Insertar asistencias de prueba
INSERT INTO asistencias (usuario_id, fecha, hora) VALUES
(1, CURDATE(), '08:01:23'),
(2, CURDATE(), '08:05:45'),
(3, CURDATE(), '08:00:10'),
(4, CURDATE(), '08:10:00'),
(1, CURDATE() - INTERVAL 1 DAY, '08:03:12'),
(2, CURDATE() - INTERVAL 1 DAY, '08:04:00'),
(3, CURDATE() - INTERVAL 2 DAY, '08:00:45'),
(4, CURDATE() - INTERVAL 2 DAY, '08:07:30');