-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2024 a las 15:16:39
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_historia_clinica_v1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas_medicas`
--

CREATE TABLE `consultas_medicas` (
  `ID_Consulta` int(11) NOT NULL,
  `ID_Paciente` int(11) DEFAULT NULL,
  `ID_Profesional` int(11) DEFAULT NULL,
  `Motivo` text NOT NULL,
  `Tratamiento` text DEFAULT NULL,
  `Diagnostico` text DEFAULT NULL,
  `Comentarios` text DEFAULT NULL,
  `Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `ID_Cuenta` int(11) NOT NULL,
  `ID_Paciente` int(11) DEFAULT NULL,
  `ID_Profesional` int(11) DEFAULT NULL,
  `ID_Tipo` int(11) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `Imagen` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctores`
--

CREATE TABLE `doctores` (
  `ID_Profesional` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `DNI` varchar(20) NOT NULL,
  `Matricula` varchar(50) NOT NULL,
  `ID_Especialidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `ID_Especialidad` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudios_medicos`
--

CREATE TABLE `estudios_medicos` (
  `ID_Estudio` int(11) NOT NULL,
  `ID_Consulta` int(11) DEFAULT NULL,
  `ID_Especialidad` int(11) DEFAULT NULL,
  `Informe` text DEFAULT NULL,
  `Imagenes` blob DEFAULT NULL,
  `Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obras_sociales`
--

CREATE TABLE `obras_sociales` (
  `ID_OS` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `ID_Paciente` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `DNI` varchar(20) NOT NULL,
  `Mail` varchar(100) NOT NULL,
  `ID_OS` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_cuentas`
--

CREATE TABLE `tipos_cuentas` (
  `ID_Tipo` int(11) NOT NULL,
  `Descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consultas_medicas`
--
ALTER TABLE `consultas_medicas`
  ADD PRIMARY KEY (`ID_Consulta`),
  ADD KEY `ID_Paciente` (`ID_Paciente`),
  ADD KEY `ID_Profesional` (`ID_Profesional`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`ID_Cuenta`),
  ADD KEY `ID_Paciente` (`ID_Paciente`),
  ADD KEY `ID_Profesional` (`ID_Profesional`),
  ADD KEY `ID_Tipo` (`ID_Tipo`);

--
-- Indices de la tabla `doctores`
--
ALTER TABLE `doctores`
  ADD PRIMARY KEY (`ID_Profesional`),
  ADD UNIQUE KEY `DNI` (`DNI`),
  ADD KEY `FK_Doctores_Especialidades` (`ID_Especialidad`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`ID_Especialidad`);

--
-- Indices de la tabla `estudios_medicos`
--
ALTER TABLE `estudios_medicos`
  ADD PRIMARY KEY (`ID_Estudio`),
  ADD KEY `ID_Consulta` (`ID_Consulta`),
  ADD KEY `ID_Especialidad` (`ID_Especialidad`);

--
-- Indices de la tabla `obras_sociales`
--
ALTER TABLE `obras_sociales`
  ADD PRIMARY KEY (`ID_OS`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`ID_Paciente`),
  ADD UNIQUE KEY `DNI` (`DNI`),
  ADD KEY `FK_Pacientes_ObrasSociales` (`ID_OS`);

--
-- Indices de la tabla `tipos_cuentas`
--
ALTER TABLE `tipos_cuentas`
  ADD PRIMARY KEY (`ID_Tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `consultas_medicas`
--
ALTER TABLE `consultas_medicas`
  MODIFY `ID_Consulta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `ID_Cuenta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doctores`
--
ALTER TABLE `doctores`
  MODIFY `ID_Profesional` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `ID_Especialidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estudios_medicos`
--
ALTER TABLE `estudios_medicos`
  MODIFY `ID_Estudio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `obras_sociales`
--
ALTER TABLE `obras_sociales`
  MODIFY `ID_OS` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `ID_Paciente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_cuentas`
--
ALTER TABLE `tipos_cuentas`
  MODIFY `ID_Tipo` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consultas_medicas`
--
ALTER TABLE `consultas_medicas`
  ADD CONSTRAINT `consultas_medicas_ibfk_1` FOREIGN KEY (`ID_Paciente`) REFERENCES `pacientes` (`ID_Paciente`),
  ADD CONSTRAINT `consultas_medicas_ibfk_2` FOREIGN KEY (`ID_Profesional`) REFERENCES `doctores` (`ID_Profesional`);

--
-- Filtros para la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD CONSTRAINT `cuentas_ibfk_1` FOREIGN KEY (`ID_Paciente`) REFERENCES `pacientes` (`ID_Paciente`),
  ADD CONSTRAINT `cuentas_ibfk_2` FOREIGN KEY (`ID_Profesional`) REFERENCES `doctores` (`ID_Profesional`),
  ADD CONSTRAINT `cuentas_ibfk_3` FOREIGN KEY (`ID_Tipo`) REFERENCES `tipos_cuentas` (`ID_Tipo`);

--
-- Filtros para la tabla `doctores`
--
ALTER TABLE `doctores`
  ADD CONSTRAINT `FK_Doctores_Especialidades` FOREIGN KEY (`ID_Especialidad`) REFERENCES `especialidades` (`ID_Especialidad`);

--
-- Filtros para la tabla `estudios_medicos`
--
ALTER TABLE `estudios_medicos`
  ADD CONSTRAINT `estudios_medicos_ibfk_1` FOREIGN KEY (`ID_Consulta`) REFERENCES `consultas_medicas` (`ID_Consulta`),
  ADD CONSTRAINT `estudios_medicos_ibfk_2` FOREIGN KEY (`ID_Especialidad`) REFERENCES `especialidades` (`ID_Especialidad`);

--
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `FK_Pacientes_ObrasSociales` FOREIGN KEY (`ID_OS`) REFERENCES `obras_sociales` (`ID_OS`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
