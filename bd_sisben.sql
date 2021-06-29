SET FOREIGN_KEY_CHECKS=0;
use bd_sisben;
#----------------------------
# Table structure for baq_logins
#----------------------------
CREATE TABLE `baq_logins` (
  `PK_baq_logins` bigint(20) NOT NULL AUTO_INCREMENT,
  `FK_BAQ_USUARIOS` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_login` varchar(200) NOT NULL,
  PRIMARY KEY (`PK_baq_logins`),
  KEY `FK_BAQ_USUARIOS` (`PK_baq_logins`),
  KEY `FK_BAQ_USUARIOS_BAQ_LOGINS` (`FK_BAQ_USUARIOS`),
  CONSTRAINT `FK_BAQ_USUARIOS_BAQ_LOGINS` FOREIGN KEY (`FK_BAQ_USUARIOS`) REFERENCES `baq_usuarios` (`PK_baq_usuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
#----------------------------
# Records for table baq_logins
#----------------------------


insert  into baq_logins values 
(1, 1, 'admonsisben@gmail.com', '9d0d4e47253527bf6692a8cd15d337f5');
#----------------------------
# Table structure for baq_submenus
#----------------------------
CREATE TABLE `baq_submenus` (
  `PK_baq_submenu` bigint(20) NOT NULL AUTO_INCREMENT,
  `FK_BAQ_MENUS` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ruta` varchar(200) NOT NULL,
  `icono` varchar(200) NOT NULL,
  `borrado` int(1) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `fecha_eliminacion` datetime DEFAULT NULL,
  `usuario_creacion` bigint(20) NOT NULL,
  `usuario_actualizacion` bigint(20) DEFAULT NULL,
  `usuario_eliminacion` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`PK_baq_submenu`),
  KEY `FK_BAQ_MENUS_BAQ_SUBMENUS` (`FK_BAQ_MENUS`),
  CONSTRAINT `FK_BAQ_MENUS_BAQ_SUBMENUS` FOREIGN KEY (`FK_BAQ_MENUS`) REFERENCES `baq_menus` (`PK_baq_menus`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
#----------------------------
# Records for table baq_submenus
#----------------------------


insert  into baq_submenus values 
(1, 1, 'Repo. Sisben', './?view=repo&page=nuevo_archivo&action=null', '', 0, '2000-01-01 00:00:00', null, null, 0, null, null);
#----------------------------
# Table structure for baq_usuarios
#----------------------------
CREATE TABLE `baq_usuarios` (
  `PK_baq_usuarios` bigint(20) NOT NULL AUTO_INCREMENT,
  `p_nombre` varchar(100) NOT NULL,
  `s_nombre` varchar(100) DEFAULT NULL,
  `p_apellido` varchar(100) DEFAULT NULL,
  `s_apellido` varchar(100) DEFAULT NULL,
  `sexo` char(1) NOT NULL,
  `borrado` int(1) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `fecha_eliminacion` datetime DEFAULT NULL,
  `usuario_creacion` bigint(20) NOT NULL,
  `usuario_actualizacion` bigint(20) DEFAULT NULL,
  `usuario_eliminacion` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`PK_baq_usuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
#----------------------------
# Records for table baq_usuarios
#----------------------------


insert  into baq_usuarios values 
(1, 'Administrador', '', '', '', 'm', 0, '2020-01-01 00:00:00', '2020-12-29 00:00:00', '2020-12-30 00:00:00', 1, 1, 1);
#----------------------------
# Table structure for solicitud_sisben
#----------------------------
CREATE TABLE `solicitud_sisben` (
  `id_solicitud` bigint(20) NOT NULL AUTO_INCREMENT,
  `radicado` varchar(20) DEFAULT NULL,
  `documento` varchar(100) DEFAULT NULL,
  `primer_nombre` varchar(100) DEFAULT NULL,
  `segundo_nombre` varchar(100) DEFAULT NULL,
  `primer_apellido` varchar(100) DEFAULT NULL,
  `segundo_apellido` varchar(100) DEFAULT NULL,
  `tipo_tramite` varchar(50) DEFAULT NULL,
  `estado_tramite` varchar(20) DEFAULT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_solicitud`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
#----------------------------
# No records for table solicitud_sisben
#----------------------------


