-- ################################################################
CREATE DATABASE 'mispruebas';


-- ################################################################
-- #Creación del usuario pruebas
-- ################################
CREATE USER 'pruebas'@'localhost' IDENTIFIED BY '***';

GRANT SELECT ON * . *
TO 'pruebas'@'localhost'
IDENTIFIED BY 'probando'
WITH MAX_QUERIES_PER_HOUR 0
MAX_CONNECTIONS_PER_HOUR 0
MAX_UPDATES_PER_HOUR 0
MAX_USER_CONNECTIONS 0 ;

GRANT ALL PRIVILEGES ON `mispruebas` . * TO 'pruebas'@'localhost';

-- ################################################################
-- Creación de la tabla pizzas


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pizzas`
--

CREATE TABLE IF NOT EXISTS `pizzas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pizzeria` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `x` double NOT NULL,
  `y` double NOT NULL,
  `ciudad` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `provincia` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `precio` double NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `piña` int(11) NOT NULL,
  `atun` int(11) NOT NULL,
  `pepperoni` int(11) NOT NULL,
  `aceitunas` int(11) NOT NULL,
  `cebolla` int(11) NOT NULL,
  `champiñones` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `pizzas`
--

INSERT INTO `pizzas` (`id`, `pizzeria`, `x`, `y`, `ciudad`, `provincia`, `precio`, `fecha`, `hora`, `piña`, `atun`, `pepperoni`, `aceitunas`, `cebolla`, `champiñones`) VALUES
(3, 'Telepizza Chana', 37.193177, -3.623125, 'Granada', 'Granada', 15.95, '2014-08-13', '21:00:00', 3, 5, 4, 0, 1, 3),
(2, 'Telepizza Chana', 37.193177, -3.623125, 'Granada', 'Granada', 12.95, '2014-08-06', '20:00:00', 0, 5, 4, 8, 1, 3),
(4, 'Telepizza Chana', 37.193177, -3.623125, 'Granada', 'Granada', 10, '2014-07-13', '21:00:00', 3, 5, 1, 1, 1, 3),
(5, 'Telepizza Chana', 37.193177, -3.623125, 'Granada', 'Granada', 10, '2013-12-01', '14:00:00', 2, 5, 7, 1, 9, 0),
(6, 'Voy Volando Maracena', 37.208261, -3.631877, 'Maracena', 'Granada', 9, '2014-02-01', '20:00:00', 2, 5, 7, 1, 9, 0),
(7, 'Voy Volando Maracena', 37.208261, -3.631877, 'Maracena', 'Granada', 19, '2014-02-11', '20:00:00', 6, 5, 7, 6, 9, 1),
(8, 'Voy Volando Maracena', 37.208261, -3.631877, 'Maracena', 'Granada', 9, '2014-03-11', '20:30:00', 1, 5, 7, 0, 0, 1),
(1, 'Voy Volando Maracena', 37.208261, -3.631877, 'Maracena', 'Granada', 9, '2014-04-21', '21:30:00', 4, 2, 6, 1, 1, 1),
(9, 'Voy Volando Maracena', 37.208261, -3.631877, 'Maracena', 'Granada', 12, '2014-05-21', '21:00:00', 1, 2, 8, 1, 10, 1),
(10, 'Restaurante 7 Pecados', 37.189742, -3.610324, 'Granada', 'Granada', 22, '2014-05-11', '22:00:00', 10, 2, 8, 1, 10, 0),
(11, 'Restaurante 7 Pecados', 37.189742, -3.610324, 'Granada', 'Granada', 25, '2014-06-10', '22:00:00', 5, 2, 8, 5, 5, 0),
(12, 'Nonsolopasta', 37.189808, -3.6075, 'Granada', 'Granada', 15, '2014-07-10', '21:00:00', 5, 2, 0, 5, 5, 0),
(13, 'Vittoria', 36.762895, -2.107608, 'San José', 'Almería', 25, '2014-08-01', '20:00:00', 5, 2, 4, 5, 5, 3),
(14, 'Vittoria', 36.762895, -2.107608, 'San José', 'Almería', 15, '2014-08-01', '22:00:00', 5, 1, 4, 0, 5, 3),
(15, 'Danis pizza', 38.014162, -3.374103, 'Úbeda', 'Jaén', 15, '2014-08-22', '21:00:00', 5, 1, 4, 2, 5, 3);


