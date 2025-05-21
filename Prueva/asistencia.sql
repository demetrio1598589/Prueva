-- Eliminar la base de datos existente si es necesario
DROP DATABASE IF EXISTS asistencia_db;

CREATE DATABASE asistencia_db;
USE asistencia_db;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    correo VARCHAR(100) UNIQUE,  -- Nuevo campo añadido
    rol ENUM('admin', 'usuario') NOT NULL DEFAULT 'usuario'
);

CREATE TABLE asistencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Insertar usuarios de prueba con contraseñas hasheadas correctamente
INSERT INTO usuarios (nombre, usuario, password, correo, rol) VALUES
('Ana Pérez', 'ana', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ana@example.com', 'usuario'),
('Carlos Gómez', 'carlos', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'carlos@example.com', 'usuario'),
('Lucía Torres', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@example.com', 'admin'),
('Mario Rodríguez', 'mario', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mario@example.com', 'usuario');

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