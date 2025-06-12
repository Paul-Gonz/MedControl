-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2025 a las 21:26:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `medcontroldb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `cita_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `doctor_especialista_id` int(11) NOT NULL,
  `consultorio_id` int(11) NOT NULL,
  `expediente_id` int(11) NOT NULL,
  `motivo` text NOT NULL,
  `fecha_hora_inicio` datetime NOT NULL,
  `fecha_hora_fin` datetime NOT NULL,
  `estado_cita` enum('programada','completada','cancelada','aplazada') DEFAULT 'programada',
  `activo_inactivo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultorios`
--

CREATE TABLE `consultorios` (
  `consultorio_id` int(11) NOT NULL,
  `tipo_id` int(11) NOT NULL,
  `nombre_consultorio` varchar(50) NOT NULL,
  `ubicacion` text NOT NULL,
  `estado_consultorio` enum('disponible','en_mantenimiento','no_disponible') DEFAULT 'disponible',
  `activo_inactivo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_bancarias`
--

CREATE TABLE `cuentas_bancarias` (
  `id_cuenta_bancaria` int(11) NOT NULL,
  `nombre_titular` varchar(200) NOT NULL,
  `cedula_titular` varchar(10) NOT NULL,
  `banco` varchar(20) NOT NULL,
  `numero_telefonico` varchar(15) NOT NULL,
  `pago_movil` tinyint(1) NOT NULL,
  `activo_inactivo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diario_detalle`
--

CREATE TABLE `diario_detalle` (
  `detalle_id` int(11) NOT NULL,
  `asiento_id` int(11) DEFAULT NULL,
  `cuenta_id` int(11) DEFAULT NULL,
  `debe` decimal(12,2) DEFAULT 0.00,
  `haber` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctores`
--

CREATE TABLE `doctores` (
  `doctor_id` int(11) NOT NULL,
  `cuenta_id` int(11) NOT NULL,
  `cedula_identidad` varchar(10) NOT NULL,
  `cedula_profesional` varchar(20) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `honorarios` decimal(10,2) DEFAULT NULL,
  `contacto_telefono` varchar(20) NOT NULL,
  `contacto_email` varchar(150) NOT NULL,
  `activo_inactivo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor_por_especialidad`
--

CREATE TABLE `doctor_por_especialidad` (
  `relacion_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `especialidad_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo_inactivo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expedientes_clinicos`
--

CREATE TABLE `expedientes_clinicos` (
  `expediente_id` int(11) NOT NULL,
  `diagnostico` text NOT NULL,
  `tratamiento` text NOT NULL,
  `receta` text NOT NULL,
  `observaciones` text NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime NOT NULL,
  `activo_inactivo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `expedientes_clinicos`
--
DELIMITER $$
CREATE TRIGGER `audit_expedientes` AFTER UPDATE ON `expedientes_clinicos` FOR EACH ROW BEGIN
    INSERT INTO Auditoria (tabla_afectada, accion, usuario, valores_anteriores, nuevos_valores)
    VALUES ('ExpedientesClinicos', 'UPDATE', CURRENT_USER(),
        JSON_OBJECT(
            'diagnostico', OLD.diagnostico,
            'tratamiento', OLD.tratamiento
        ),
        JSON_OBJECT(
            'diagnostico', NEW.diagnostico,
            'tratamiento', NEW.tratamiento
        )
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `factura_id` int(11) NOT NULL,
  `cita_id` int(11) NOT NULL,
  `fecha_emision` datetime DEFAULT current_timestamp(),
  `subtotal` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `total` decimal(10,2) GENERATED ALWAYS AS (`subtotal` + `iva`) STORED,
  `estado_factura` enum('pendiente','pago_parcial','pagada','cancelada') DEFAULT 'pendiente',
  `activo_inactivo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_diario`
--

CREATE TABLE `libro_diario` (
  `asiento_id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `numero_asiento` varchar(20) DEFAULT NULL,
  `concepto` text DEFAULT NULL,
  `estado` enum('borrador','validado','anulado') DEFAULT 'validado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `paciente_id` int(11) NOT NULL,
  `cedula_identidad` varchar(10) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `contacto_telefono` varchar(20) DEFAULT NULL,
  `contacto_email` varchar(150) DEFAULT NULL,
  `datos_relevantes` text DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `activo_inactivo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `pago_id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `metodo_pago` enum('efectivo','tarjeta','transferencia','cheque','otro') NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha_pago` datetime DEFAULT current_timestamp(),
  `numero_referencia` text NOT NULL,
  `activo_inactivo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_cuentas`
--

CREATE TABLE `plan_cuentas` (
  `cuenta_id` int(11) NOT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `tipo` enum('activo','pasivo','capital','ingreso','egreso','gasto') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_consultorio`
--

CREATE TABLE `tipo_consultorio` (
  `tipo_consultorio_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `equipamiento` text NOT NULL,
  `activo_inactivo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `usuario` varchar(16) NOT NULL,
  `clave` varchar(16) NOT NULL,
  `nombre_asignado` varchar(100) NOT NULL,
  `cedula_asignado` varchar(10) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `activo_inactivo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`cita_id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `consultorio_id` (`consultorio_id`),
  ADD KEY `expediente_id` (`expediente_id`),
  ADD KEY `doctor_especialista_id` (`doctor_especialista_id`);

--
-- Indices de la tabla `consultorios`
--
ALTER TABLE `consultorios`
  ADD PRIMARY KEY (`consultorio_id`),
  ADD KEY `tipo_id` (`tipo_id`);

--
-- Indices de la tabla `cuentas_bancarias`
--
ALTER TABLE `cuentas_bancarias`
  ADD PRIMARY KEY (`id_cuenta_bancaria`);

--
-- Indices de la tabla `diario_detalle`
--
ALTER TABLE `diario_detalle`
  ADD PRIMARY KEY (`detalle_id`),
  ADD KEY `asiento_id` (`asiento_id`),
  ADD KEY `cuenta_id` (`cuenta_id`);

--
-- Indices de la tabla `doctores`
--
ALTER TABLE `doctores`
  ADD PRIMARY KEY (`doctor_id`),
  ADD KEY `cuenta_id` (`cuenta_id`);

--
-- Indices de la tabla `doctor_por_especialidad`
--
ALTER TABLE `doctor_por_especialidad`
  ADD PRIMARY KEY (`relacion_id`),
  ADD KEY `especialidad_id` (`especialidad_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`especialidad_id`);

--
-- Indices de la tabla `expedientes_clinicos`
--
ALTER TABLE `expedientes_clinicos`
  ADD PRIMARY KEY (`expediente_id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`factura_id`),
  ADD KEY `cita_id` (`cita_id`);

--
-- Indices de la tabla `libro_diario`
--
ALTER TABLE `libro_diario`
  ADD PRIMARY KEY (`asiento_id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`paciente_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`pago_id`),
  ADD KEY `factura_id` (`factura_id`);

--
-- Indices de la tabla `plan_cuentas`
--
ALTER TABLE `plan_cuentas`
  ADD PRIMARY KEY (`cuenta_id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `tipo_consultorio`
--
ALTER TABLE `tipo_consultorio`
  ADD PRIMARY KEY (`tipo_consultorio_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `cita_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consultorios`
--
ALTER TABLE `consultorios`
  MODIFY `consultorio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cuentas_bancarias`
--
ALTER TABLE `cuentas_bancarias`
  MODIFY `id_cuenta_bancaria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `diario_detalle`
--
ALTER TABLE `diario_detalle`
  MODIFY `detalle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doctores`
--
ALTER TABLE `doctores`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doctor_por_especialidad`
--
ALTER TABLE `doctor_por_especialidad`
  MODIFY `relacion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `especialidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `expedientes_clinicos`
--
ALTER TABLE `expedientes_clinicos`
  MODIFY `expediente_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `factura_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libro_diario`
--
ALTER TABLE `libro_diario`
  MODIFY `asiento_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `paciente_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `pago_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plan_cuentas`
--
ALTER TABLE `plan_cuentas`
  MODIFY `cuenta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_consultorio`
--
ALTER TABLE `tipo_consultorio`
  MODIFY `tipo_consultorio_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `consultprio_id` FOREIGN KEY (`consultorio_id`) REFERENCES `consultorios` (`consultorio_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `doctor_especialista_id` FOREIGN KEY (`doctor_especialista_id`) REFERENCES `doctor_por_especialidad` (`relacion_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `expediente_id` FOREIGN KEY (`expediente_id`) REFERENCES `expedientes_clinicos` (`expediente_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `paciente_id` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`paciente_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `consultorios`
--
ALTER TABLE `consultorios`
  ADD CONSTRAINT `tipo_id` FOREIGN KEY (`tipo_id`) REFERENCES `tipo_consultorio` (`tipo_consultorio_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `diario_detalle`
--
ALTER TABLE `diario_detalle`
  ADD CONSTRAINT `diario_detalle_ibfk_1` FOREIGN KEY (`asiento_id`) REFERENCES `libro_diario` (`asiento_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diario_detalle_ibfk_2` FOREIGN KEY (`cuenta_id`) REFERENCES `plan_cuentas` (`cuenta_id`);

--
-- Filtros para la tabla `doctores`
--
ALTER TABLE `doctores`
  ADD CONSTRAINT `cuenta_id` FOREIGN KEY (`cuenta_id`) REFERENCES `cuentas_bancarias` (`id_cuenta_bancaria`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `doctor_por_especialidad`
--
ALTER TABLE `doctor_por_especialidad`
  ADD CONSTRAINT `doctor_id` FOREIGN KEY (`doctor_id`) REFERENCES `doctores` (`doctor_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `especialidades_id` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidades` (`especialidad_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `cita_id` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`cita_id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`factura_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
