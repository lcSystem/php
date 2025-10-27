-- ======================================
-- BASE DE DATOS: DataCience (Sistema de Citas)
-- ======================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS DataCience CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE DataCience;

-- ======================================
-- 1️ TABLA USUARIOS (Clientes, Empleados, Admin)
-- ======================================

CREATE TABLE usuarios (
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  nombre_completo VARCHAR(100) DEFAULT NULL,
  telefono VARCHAR(20) DEFAULT NULL,
  direccion TEXT DEFAULT NULL,
  edad INT(2) DEFAULT NULL,
  sexo ENUM('M','F') DEFAULT NULL,
  avatar VARCHAR(255) DEFAULT NULL,
  rol ENUM('admin','empleado','cliente') DEFAULT 'cliente',
  estado ENUM('activo','inactivo') DEFAULT 'activo',
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY (username),
  UNIQUE KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================
-- 2️ TABLA SERVICIOS
-- ======================================

CREATE TABLE servicios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT,
  duracion_minutos INT DEFAULT 30,
  estado ENUM('activo','inactivo') DEFAULT 'activo',
  precio DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================
-- 3️ TABLA HORARIOS DE EMPLEADOS
-- ======================================

CREATE TABLE horarios_empleado (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empleado_id INT NOT NULL,
  dia_semana ENUM('lunes','martes','miercoles','jueves','viernes','sabado','domingo') NOT NULL,
  hora_inicio TIME NOT NULL,
  hora_fin TIME NOT NULL,
  FOREIGN KEY (empleado_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================
-- 4️ TABLA DÍAS NO LABORALES (Festivos o cierre)
-- ======================================

CREATE TABLE dias_no_laborales (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fecha DATE NOT NULL,
  motivo VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================
-- 5️ TABLA CITAS
-- ======================================

CREATE TABLE citas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente_id INT NOT NULL,                -- Cliente que recibe el servicio
  servicio_id INT NOT NULL,               -- Tipo de servicio
  empleado_id INT DEFAULT NULL,           -- Empleado asignado
  fecha_cita DATE NOT NULL,
  hora_cita TIME NOT NULL,
  duracion_minutos INT DEFAULT 30,        -- Copia del servicio (por si cambia después)
  estado ENUM('pendiente','confirmada','cancelada','completada','no_asistio') DEFAULT 'pendiente',
  comentarios TEXT,
  creada_por INT DEFAULT NULL,            -- Quién registró la cita (cliente o empleado)
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (cliente_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE CASCADE,
  FOREIGN KEY (empleado_id) REFERENCES usuarios(id) ON DELETE SET NULL,
  FOREIGN KEY (creada_por) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
