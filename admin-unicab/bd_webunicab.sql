-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2019 a las 18:31:05
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_webunicab`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `IdAdministrador` int(11) NOT NULL,
  `Nombre` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `Apellido` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `Email` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `Password` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`IdAdministrador`, `Nombre`, `Apellido`, `Email`, `Password`) VALUES
(1, 'fredy', 'ramirez', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog`
--

CREATE TABLE `blog` (
  `IdBlog` int(11) NOT NULL,
  `TituloB` varchar(400) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `DescripcionB` varchar(10000) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ImagenB` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `FechaPublicacionB` date DEFAULT NULL,
  `CategoriaB` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `IdAdministrador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `blog`
--

INSERT INTO `blog` (`IdBlog`, `TituloB`, `DescripcionB`, `ImagenB`, `FechaPublicacionB`, `CategoriaB`, `IdAdministrador`) VALUES
(3, 'Ocho claves de la educación suiza', 'República federada compuesta por un total de 26 estados, o cantones, Suiza es el cuarto país más rico del mundo y también uno de los más desarrollados, además de sede de la Cruz Roja y la Organización Mundial del Comercio, una de las dos oficinas de la ONU en Europa y, también, sede del COI, la FIFA y la UEFA. Popular por su chocolate, navajas y relojes, Suiza está históricamente definida por la neutralidad de sus políticas exteriores desde 1815, y se ha erigido en consecuencia en uno de los lugares culturalmente más diversos del globo, hogar de inmigrantes y refugiados venidos de los cinco continentes. Una realidad social compleja en su variedad, pero muy bien gestionada por un sistema educativo del que, a continuación, os resumimos sus ocho puntos clave:\r\n\r\nOcho claves de la educación en Suiza\r\n\r\nDebido a su carácter confederal, existen un total de 26 sistemas educativos independientes en todo el país: uno por cada cantón. A pesar de ello existe un pacto para ejercer su función de forma más o menos unitaria en todo el territorio, por lo que podemos hablar de Suiza como un país con una única estructura educativa, común a prácticamente todos sus cantones. Igualmente, no existe un Ministerio Federal de Educación, quedando esta competencia en manos de los cantones, que se coordinan a través de la Conferencia Suiza de Ministerios cantonales de Educación.\r\nDando respuesta a la mentada diversidad cultural que acoge Suiza, su sistema educativo tiene como idiomas oficiales el alemán, el francés, el italiano y el romanche. No en vano son también las lenguas oficiales del país.\r\nLa edad mínima de escolarización obligatoria es de 6 años, a excepción del cantón de Obwalden, que es de 5. Desde ese momento, los estudiantes cursan 9 años de Educación primaria y secundaria inferior para, a los 15 años de edad, acceder a la Educación Secundaria. Este tramo formativo se encuentra subdivido entre el Gymnasium, la Secundaria especializada, la Formación Profesional (FP) y la Secundaria Superior. Posteriormente, el alumnado puede acceder a su Educación Terciaria, formada a su vez por estudios universitarios, Colegios pedagógicos o FP Superior. En el caso de haber optado por la primera de estas tres opciones los estudiantes pueden optar por cursar estudios universitarios superiores.\r\nLa constitución suiza establece la gratuidad de la escolarización de los niños y niñas durante nueve años. Igualmente, la correlación entre centros educativos públicos y privados es del 90% para los primeros y el 10% restante para los segundos.\r\nLos salarios del profesorado suizo se cuentan entre los más altos del mundo, siendo de alrededor de 45.000 euros anuales en educación básica, 50.000 en la primaria, 57.000 en la secundaria inferior y 63.000 en la superior, en el año 2018.\r\nCorroborando lo que se desprende del punto anterior, la educación en Suiza está considerada como un asunto público de gran importancia. En este mismo sentido, la confederación suiza invirtió un 5,1% del PIB en Educación en el ejercicio de 2018.\r\nTodos estos esfuerzos parecen haber dado sus frutos al contemplar los resultados de Suiza en los Informes PISA, donde según datos del pasado año ocupó el puesto 18 en lo concerniente a Ciencias, el 28 en Comprensión lectora y, atención, el 8 en Estudios matemáticos.\r\nComo ya os informamos en este mismo blog hace unos años, la educación musical en Suiza está garantizada por la Constitución, después de que una iniciativa popular incorporase esta nueva normativa en el año 2012. Así, desde el 2016, Suiza garantiza el derecho a una educación musical gratuita, reivindica el papel de los docentes especializados en esta materia y, también, la facilitación al acceso a escuelas y conservatorios de estudios musicales superiores al alumnado que destaque en este ámbito.', '../../../assets/img/img-blog/shutterstock_760608343.jpg', '2019-11-12', 'Educación', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `IdEvento` int(11) NOT NULL,
  `NombreE` varchar(400) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `DescripcionE` varchar(10000) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `FechaPublicacionE` date DEFAULT NULL,
  `FechaE` date DEFAULT NULL,
  `HoraE` varchar(15) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `LugarE` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ImagenE` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `LinkE` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `IdAdministrador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`IdEvento`, `NombreE`, `DescripcionE`, `FechaPublicacionE`, `FechaE`, `HoraE`, `LugarE`, `ImagenE`, `LinkE`, `IdAdministrador`) VALUES
(1, 'Prueba Nº 1', 'The standard Lorem Ipsum passage, used since the 1500s\r\n\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"\r\n\r\nSection 1.10.32 of \"de Finibus Bonorum et Malorum\", written by Cicero in 45 BC\r\n\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\"\r\n\r\n1914 translation by H. Rackham\r\n\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves.@.', '2019-11-11', '2019-11-16', '2:00 P.M', 'Auditorio de reuniones unicab salón 01', '../../../assets/img/img-eventos/DSC0020-min.jpg', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `IdNoticia` int(11) NOT NULL,
  `TituloN` varchar(400) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `DescripcionN` varchar(10000) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ImagenN` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `FechaPublicacionN` date DEFAULT NULL,
  `HoraPublicacionN` varchar(15) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `CategoriaN` varchar(150) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `FuenteN` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `IdAdministrador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`IdNoticia`, `TituloN`, `DescripcionN`, `ImagenN`, `FechaPublicacionN`, `HoraPublicacionN`, `CategoriaN`, `FuenteN`, `IdAdministrador`) VALUES
(1, ' Estudiantes de la Universidad Distrital se declaran en paro indefinido ', 'En asamblea, la comunidad universitaria acordó suspender actividades y realizar protestas con el fin de exigir la estabilidad administrativa del alma mater, afectada por el escándalo de corrupción. Exigen la creación de una asamblea universitaria que incluya su participación. Después de que saliera a la luz que William Muñoz, quien fue desde 2012 hasta enero de este año director del Instituto de Extensión y Educación para el Trabajo de la Universidad Distrital Francisco José de Caldas (Idexud), volvió “propias” la cuenta corriente y la tarjeta de crédito institucionales, la situación de esta alma mater no calma. Tal escándalo ha sido rechazado por la comunidad universitaria desde entonces, puesto que el alma mater se encuentra en una crisis interna tanto administrativa como económica. Por eso, ayer en asamblea, los estudiantes afirmaron su posición: estarán en paro indefinido hasta que se cumplan sus peticiones y haya una estabilidad para su educación. (Lea: Corrupción en la Universidad Distrital: Recta final para el proceso contra Wilman Muñoz) La principal de sus exigencias, tras conocerse que varios directivos están presuntamente implicados en esta corrupción, es una suspención al rector Ricardo García. Porque, si bien el Consejo Superior aceptó suspenderlo hasta el 19 de noviembre, los estudiantes se quejan de la extendida crisis interna bajo su administración y esperan que en esa fecha vuelva a haber otra suspensión en contra del directivo. Así lo explicó el líder estudiantil Julián Báez a RCN Radio. Su idea, que representa a los estudiantes de la Distrital, es un cambio de gobierno dentro de la institución con el fin de \"reformar a las directivas de la Universidad\", citó el mismo medio. Ya que, aunque García ha colaborado con el proceso que adelanta la Procuraduría por corrupción, en la institución no se han producido los cambios suficientes para el diálogo frente a la crisis y su posible solución, incluyendo la participación de los estudiantes a través de veedurías. Es por esto que los estudiantes se declaran ayer en paro indefinido hasta que el Consejo Superior apruebe la creación de la Asamblea Universitaria que los incluya y los haga parte de las decisiónes dentro del campus. ', '../../../assets/img/img-noticias/judi_distritalph01_20191027042118_0.jpg', '2019-11-11', '11:38 PM', 'Educación', '', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`IdAdministrador`);

--
-- Indices de la tabla `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`IdBlog`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`IdEvento`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`IdNoticia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `IdAdministrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `blog`
--
ALTER TABLE `blog`
  MODIFY `IdBlog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `IdEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `IdNoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
