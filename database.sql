CREATE DATABASE IF NOT EXISTS itq_enlaces CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE itq_enlaces;

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE enlaces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    url VARCHAR(500) NOT NULL,
    categoria_id INT NOT NULL,
    destacado TINYINT(1) DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO categorias (nombre, descripcion) VALUES
('Servicio Social', 'Convocatorias, formatos, requisitos y fechas importantes.'),
('Residencias Profesionales', 'Convocatorias, formatos, lineamientos y empresas.'),
('Prácticas Profesionales', 'Información y enlaces de contacto.'),
('Avisos y Comunicados', 'Anuncios generales de la coordinación.'),
('Recursos Académicos', 'Moodle, SII, correo institucional, etc.');

INSERT INTO enlaces (titulo, descripcion, url, categoria_id, destacado) VALUES
('Convocatoria Servicio Social 2026', 'Consulta la convocatoria vigente.', 'https://www.queretaro.tecnm.mx/', 1, 1),
('Formatos de Servicio Social', 'Descarga los formatos oficiales.', 'https://www.queretaro.tecnm.mx/', 1, 0),
('Convocatoria Residencias 2026', 'Revisa los lineamientos y fechas.', 'https://www.queretaro.tecnm.mx/', 2, 1),
('Moodle ITQ', 'Plataforma de cursos en línea.', 'https://moodle.queretaro.tecnm.mx/', 5, 0),
('SII', 'Sistema Integral de Información.', 'https://sii.queretaro.tecnm.mx/', 5, 0);

-- Tabla de usuarios administradores
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    rol VARCHAR(20) DEFAULT 'admin',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Usuario admin por defecto (contraseña: admin123)
-- IMPORTANTE: Si el hash no funciona en otra computadora, genera uno nuevo con generar_hash.php
INSERT INTO usuarios (usuario, password_hash, nombre, rol) VALUES
('admin', '$2y$10$mEeZRbQ.AmeC2VVVwLSwY.TmmoKLR2ayCNc12pRF2CoT3uhBLVxUy', 'Administrador ITQ', 'admin');