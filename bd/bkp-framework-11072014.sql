-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: framework
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dl_gerenc_email_config`
--

DROP TABLE IF EXISTS `dl_gerenc_email_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_gerenc_email_config` (
  `config_email_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `config_email_titulo` varchar(30) NOT NULL,
  `config_email_host` varchar(80) NOT NULL,
  `config_email_porta` int(11) NOT NULL DEFAULT '25',
  `config_email_autent` int(11) NOT NULL DEFAULT '1',
  `config_email_cripto` varchar(5) NOT NULL,
  `config_email_conta` varchar(100) NOT NULL,
  `config_email_senha` varchar(20) NOT NULL,
  `config_email_de_email` varchar(100) DEFAULT NULL,
  `config_email_de_nome` varchar(100) DEFAULT NULL,
  `config_email_responder_para` varchar(100) DEFAULT NULL,
  `config_email_html` int(11) NOT NULL DEFAULT '1',
  `config_email_principal` int(11) NOT NULL DEFAULT '0',
  `config_email_delete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`config_email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_gerenc_email_config`
--

LOCK TABLES `dl_gerenc_email_config` WRITE;
/*!40000 ALTER TABLE `dl_gerenc_email_config` DISABLE KEYS */;
INSERT INTO `dl_gerenc_email_config` VALUES (15,'GMAIL','smtp.gmail.com',465,1,'ssl','dlepera88@gmail.com','atabaque2611','dlepera88@gmail.com','FrameworkDL','dlepera88@gmail.com',1,0,0);
/*!40000 ALTER TABLE `dl_gerenc_email_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_gerenc_email_logs`
--

DROP TABLE IF EXISTS `dl_gerenc_email_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_gerenc_email_logs` (
  `log_email_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `log_email_config` bigint(20) DEFAULT NULL,
  `log_email_ip` varchar(80) NOT NULL COMMENT 'IP de onde saiu a requisi��o',
  `log_email_classe` varchar(20) NOT NULL COMMENT 'Nome da classe que executou o envio',
  `log_email_tabela` varchar(30) DEFAULT NULL,
  `log_email_idreg` bigint(20) DEFAULT NULL COMMENT 'ID do registro que referencia o envio desse e-mail',
  `log_email_status` enum('S','E','F') NOT NULL DEFAULT 'S',
  `log_email_mensagem` text,
  PRIMARY KEY (`log_email_id`),
  KEY `FK_log_email_config` (`log_email_config`),
  CONSTRAINT `FK_log_email_config` FOREIGN KEY (`log_email_config`) REFERENCES `dl_gerenc_email_config` (`config_email_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_gerenc_email_logs`
--

LOCK TABLES `dl_gerenc_email_logs` WRITE;
/*!40000 ALTER TABLE `dl_gerenc_email_logs` DISABLE KEYS */;
INSERT INTO `dl_gerenc_email_logs` VALUES (1,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',1,'E',''),(2,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',2,'E',''),(3,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',3,'E',''),(4,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',4,'E',''),(5,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',5,'E',''),(6,15,'127.0.0.1','ControleUsuario','dl_gerenc_usuarios',0,'E',''),(7,15,'127.0.0.1','ControleUsuario','dl_gerenc_usuarios',0,'E',''),(8,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',6,'E',''),(9,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',9,'E',''),(10,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',11,'E',''),(11,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',12,'E',''),(12,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',8,'E',''),(13,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',7,'E',''),(14,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',13,'E',''),(15,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',14,'E',''),(16,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',10,'E',''),(17,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',16,'E',''),(18,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',17,'E',''),(19,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',15,'E',''),(20,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',19,'E',''),(21,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',21,'E',''),(22,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',22,'E',''),(23,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',18,'E',''),(24,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',24,'E',''),(25,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',20,'E',''),(26,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',23,'E',''),(27,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',27,'E',''),(28,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',26,'E',''),(29,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',29,'E',''),(30,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',25,'E',''),(31,15,'127.0.0.1','ControleContatoSite','dl_site_contatos',28,'E','');
/*!40000 ALTER TABLE `dl_gerenc_email_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_gerenc_formatos_data`
--

DROP TABLE IF EXISTS `dl_gerenc_formatos_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_gerenc_formatos_data` (
  `formato_data_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `formato_data_descr` varchar(20) NOT NULL,
  `formato_data_completo` varchar(20) NOT NULL,
  `formato_data_data` varchar(10) NOT NULL,
  `formato_data_hora` varchar(10) NOT NULL,
  `formato_data_publicar` int(11) NOT NULL DEFAULT '1',
  `formato_data_delete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`formato_data_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_gerenc_formatos_data`
--

LOCK TABLES `dl_gerenc_formatos_data` WRITE;
/*!40000 ALTER TABLE `dl_gerenc_formatos_data` DISABLE KEYS */;
INSERT INTO `dl_gerenc_formatos_data` VALUES (1,'dd/mm/aaaa hh:mm','d/m/Y H:i','d/m/Y','H:i',1,0),(2,'mm/dd/aaaa hh:mm:ss','m/d/Y H:i:s','m/d/Y','H:i:s',1,0),(3,'aaaa/mm/dd hh:mm:ss','Y/m/d H:i:s','Y/m/d','H:i:s',1,0);
/*!40000 ALTER TABLE `dl_gerenc_formatos_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_gerenc_grupos_permissoes`
--

DROP TABLE IF EXISTS `dl_gerenc_grupos_permissoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_gerenc_grupos_permissoes` (
  `permissao_grupo` bigint(20) NOT NULL,
  `permissao_modulo` bigint(20) NOT NULL,
  `permissao_ver` int(11) NOT NULL,
  `permissao_inserir` int(11) NOT NULL DEFAULT '0',
  `permissao_editar` int(11) NOT NULL,
  `permissao_remover` int(11) NOT NULL DEFAULT '0',
  `permissao_total` int(11) NOT NULL,
  PRIMARY KEY (`permissao_grupo`,`permissao_modulo`),
  KEY `FK_permissao_grupo_modulo` (`permissao_modulo`),
  CONSTRAINT `FK_permissao_grupo` FOREIGN KEY (`permissao_grupo`) REFERENCES `dl_gerenc_grupos_usuarios` (`grupo_usuario_id`) ON DELETE CASCADE,
  CONSTRAINT `FK_permissao_grupo_modulo` FOREIGN KEY (`permissao_modulo`) REFERENCES `dl_gerenc_modulos` (`modulo_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_gerenc_grupos_permissoes`
--

LOCK TABLES `dl_gerenc_grupos_permissoes` WRITE;
/*!40000 ALTER TABLE `dl_gerenc_grupos_permissoes` DISABLE KEYS */;
INSERT INTO `dl_gerenc_grupos_permissoes` VALUES (12,2,1,1,1,1,1),(12,3,1,1,1,1,1),(12,4,1,1,1,1,1),(12,6,1,1,1,1,1),(12,7,1,1,1,1,1),(12,8,1,1,1,1,1),(13,2,0,0,0,0,0),(13,3,0,0,0,0,0),(13,4,0,0,0,0,0),(13,6,1,0,0,1,0),(13,7,1,1,1,1,0),(13,8,1,1,1,1,0),(14,2,0,0,0,0,0),(14,3,0,0,0,0,0),(14,4,0,0,0,0,0),(14,6,1,0,0,0,0),(14,7,1,0,0,0,0),(14,8,1,0,0,0,0);
/*!40000 ALTER TABLE `dl_gerenc_grupos_permissoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_gerenc_grupos_usuarios`
--

DROP TABLE IF EXISTS `dl_gerenc_grupos_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_gerenc_grupos_usuarios` (
  `grupo_usuario_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `grupo_usuario_descr` varchar(30) NOT NULL,
  `grupo_usuario_publicar` int(11) NOT NULL DEFAULT '1',
  `grupo_usuario_delete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`grupo_usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_gerenc_grupos_usuarios`
--

LOCK TABLES `dl_gerenc_grupos_usuarios` WRITE;
/*!40000 ALTER TABLE `dl_gerenc_grupos_usuarios` DISABLE KEYS */;
INSERT INTO `dl_gerenc_grupos_usuarios` VALUES (12,'Admin',1,0),(13,'Comum',1,0),(14,'Convidado',1,0);
/*!40000 ALTER TABLE `dl_gerenc_grupos_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_gerenc_idiomas`
--

DROP TABLE IF EXISTS `dl_gerenc_idiomas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_gerenc_idiomas` (
  `idioma_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idioma_descr` varchar(20) NOT NULL,
  `idioma_sigla` varchar(5) NOT NULL,
  `idioma_publicar` int(11) NOT NULL DEFAULT '1',
  `idioma_delete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idioma_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_gerenc_idiomas`
--

LOCK TABLES `dl_gerenc_idiomas` WRITE;
/*!40000 ALTER TABLE `dl_gerenc_idiomas` DISABLE KEYS */;
INSERT INTO `dl_gerenc_idiomas` VALUES (1,'Português (Brasil)','pt-BR',1,0),(2,'English','en-US',1,0);
/*!40000 ALTER TABLE `dl_gerenc_idiomas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_gerenc_modulos`
--

DROP TABLE IF EXISTS `dl_gerenc_modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_gerenc_modulos` (
  `modulo_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `modulo_pai` bigint(20) DEFAULT NULL,
  `modulo_nome` varchar(30) NOT NULL,
  `modulo_descr` text,
  `modulo_link` varchar(100) NOT NULL,
  `modulo_publicar` int(11) NOT NULL DEFAULT '1',
  `modulo_ordem` int(11) NOT NULL DEFAULT '0',
  `modulo_delete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`modulo_id`),
  KEY `FK_modulo_pai` (`modulo_pai`),
  CONSTRAINT `FK_modulo_pai` FOREIGN KEY (`modulo_pai`) REFERENCES `dl_gerenc_modulos` (`modulo_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_gerenc_modulos`
--

LOCK TABLES `dl_gerenc_modulos` WRITE;
/*!40000 ALTER TABLE `dl_gerenc_modulos` DISABLE KEYS */;
INSERT INTO `dl_gerenc_modulos` VALUES (1,NULL,'Admin','Contém os sub-módulos de administração do sistema.\r\nEx.: gerenciar usuários, configurações de emails, permissionamentos, etc.','admin',1,99,0),(2,1,'Usuários','Gerenciar os usuários do sistema. Entre os recursos disponíveis estão: bloqueio de usuários, reset de senha e configuração de permissionamentos.','admin/usuarios/lista',1,99,0),(3,1,'E-mails','Gerenciar as configurações de envio de e-mails. Você pode configurar várias contas SMTP e definir a que será a principal.','admin/emails/lista',1,0,0),(4,1,'Grupos de usuários','Gerenciar os grupos de usuário do sistema. Podem ser definidos os permissionamentos padrões para os usuários que serão incluídos em cada grupo.','admin/grupos-de-usuarios/lista',1,0,0),(5,NULL,'Web Site','Contém os sub-módulos que gerenciam diretamente o conteúdo exibido no site ou recebido do site.','web-site',1,0,0),(6,5,'Contatos recebidos','Lista dos contatos recebidos através do formulário de contato do site. É possível verificar se houve falha no envio do e-mail, qual foi a falha encontrada e remover contatos não desejados.','web-site/contatos-recebidos/lista',1,0,0),(7,5,'Dados para contato','Dados para contato que serão exibidos no site.\r\nEx.: e-mails, telefones e redes sociais.','web-site/dados-para-contato/lista',1,0,0),(8,5,'Assuntos de contatos','Assuntos de contatos estão disponíveis na tela de contato do site e cada assunto pode direcionar para um e-mail diferente. Ideal para vínculo com gerenciadores de chamado ou segmentação dos retornos.','web-site/assuntos-de-contatos/lista',1,0,0);
/*!40000 ALTER TABLE `dl_gerenc_modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_gerenc_registros_logs`
--

DROP TABLE IF EXISTS `dl_gerenc_registros_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_gerenc_registros_logs` (
  `log_registro_tabela` varchar(100) NOT NULL,
  `log_registro_idreg` bigint(20) NOT NULL,
  `log_registro_data_criacao` datetime NOT NULL,
  `log_registro_data_alteracao` datetime NOT NULL,
  `log_registro_data_exclusao` datetime DEFAULT NULL,
  `log_registro_usuario_criacao` bigint(20) NOT NULL,
  `log_registro_usuario_alteracao` bigint(20) NOT NULL,
  `log_registro_usuario_exclusao` datetime DEFAULT NULL,
  PRIMARY KEY (`log_registro_tabela`,`log_registro_idreg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_gerenc_registros_logs`
--

LOCK TABLES `dl_gerenc_registros_logs` WRITE;
/*!40000 ALTER TABLE `dl_gerenc_registros_logs` DISABLE KEYS */;
INSERT INTO `dl_gerenc_registros_logs` VALUES ('dl_gerenc_email_config',15,'2014-06-28 16:51:56','2014-07-09 18:13:28',NULL,4,0,NULL),('dl_gerenc_email_config',16,'2014-07-09 18:21:10','0000-00-00 00:00:00','2014-07-09 18:26:56',0,0,'0000-00-00 00:00:00'),('dl_gerenc_grupos_permissoes',0,'2014-06-28 17:08:46','2014-07-11 11:44:51',NULL,4,0,NULL),('dl_gerenc_grupos_permissoes',1,'2014-06-27 18:49:32','2014-07-10 08:47:05',NULL,0,0,NULL),('dl_gerenc_grupos_usuarios',12,'2014-06-27 18:49:32','0000-00-00 00:00:00','2014-07-09 15:58:35',0,0,'0000-00-00 00:00:00'),('dl_gerenc_grupos_usuarios',13,'2014-06-27 18:55:17','2014-06-28 17:08:55',NULL,4,4,NULL),('dl_gerenc_grupos_usuarios',14,'2014-06-27 18:59:26','0000-00-00 00:00:00','2014-07-09 15:58:36',4,0,'0000-00-00 00:00:00'),('dl_gerenc_grupos_usuarios',15,'2014-07-10 08:43:12','2014-07-10 08:44:02','2014-07-10 08:44:14',0,0,'0000-00-00 00:00:00'),('dl_gerenc_grupos_usuarios',16,'2014-07-10 08:45:29','0000-00-00 00:00:00','2014-07-10 08:45:37',0,0,'0000-00-00 00:00:00'),('dl_gerenc_grupos_usuarios',17,'2014-07-10 08:47:00','0000-00-00 00:00:00','2014-07-10 08:49:58',0,0,'0000-00-00 00:00:00'),('dl_gerenc_grupos_usuarios',18,'2014-07-10 08:47:01','0000-00-00 00:00:00','2014-07-10 08:50:10',0,0,'0000-00-00 00:00:00'),('dl_gerenc_grupos_usuarios',19,'2014-07-10 08:47:01','0000-00-00 00:00:00','2014-07-10 08:50:10',0,0,'0000-00-00 00:00:00'),('dl_gerenc_grupos_usuarios',20,'2014-07-10 08:47:02','0000-00-00 00:00:00','2014-07-10 08:50:10',0,0,'0000-00-00 00:00:00'),('dl_gerenc_grupos_usuarios',21,'2014-07-10 08:47:03','0000-00-00 00:00:00','2014-07-10 08:50:10',0,0,'0000-00-00 00:00:00'),('dl_gerenc_grupos_usuarios',22,'2014-07-10 08:47:04','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_gerenc_grupos_usuarios',23,'2014-07-10 08:47:05','0000-00-00 00:00:00','2014-07-10 08:50:10',0,0,'0000-00-00 00:00:00'),('dl_gerenc_modulos',1,'2014-07-11 10:53:54','2014-07-11 11:42:31',NULL,0,0,NULL),('dl_gerenc_modulos',2,'2014-07-09 17:02:29','2014-07-09 17:34:13',NULL,0,0,NULL),('dl_gerenc_modulos',3,'2014-07-09 11:42:59','2014-07-09 17:29:07',NULL,0,0,NULL),('dl_gerenc_modulos',4,'2014-07-09 17:02:12','2014-07-11 11:44:51',NULL,0,0,NULL),('dl_gerenc_modulos',5,'2014-07-09 16:45:51','2014-07-11 10:57:44',NULL,0,0,NULL),('dl_gerenc_modulos',6,'2014-07-09 17:03:11','2014-07-11 11:41:02',NULL,0,0,NULL),('dl_gerenc_modulos',7,'2014-07-09 17:03:27','2014-07-11 11:41:50',NULL,0,0,NULL),('dl_gerenc_modulos',8,'2014-07-09 17:02:54','2014-07-09 17:36:00',NULL,0,0,NULL),('dl_gerenc_modulos',12,'2014-07-09 15:53:15','0000-00-00 00:00:00','2014-07-09 15:59:23',0,0,'0000-00-00 00:00:00'),('dl_gerenc_modulos',13,'2014-07-09 15:56:50','0000-00-00 00:00:00','2014-07-09 15:59:23',0,0,'0000-00-00 00:00:00'),('dl_gerenc_modulos',14,'2014-07-09 15:57:00','0000-00-00 00:00:00','2014-07-09 16:45:22',0,0,'0000-00-00 00:00:00'),('dl_gerenc_modulos',15,'2014-07-09 15:57:56','0000-00-00 00:00:00','2014-07-09 15:59:23',0,0,'0000-00-00 00:00:00'),('dl_gerenc_modulos',16,'2014-07-09 16:04:31','0000-00-00 00:00:00','2014-07-09 16:08:15',0,0,'0000-00-00 00:00:00'),('dl_gerenc_modulos',17,'2014-07-09 16:07:51','0000-00-00 00:00:00','2014-07-09 16:08:15',0,0,'0000-00-00 00:00:00'),('dl_gerenc_modulos',18,'2014-07-09 16:09:06','2014-07-09 16:44:16',NULL,0,0,NULL),('dl_gerenc_modulos',19,'2014-07-09 17:39:05','2014-07-09 17:40:26','2014-07-09 17:41:22',0,0,'0000-00-00 00:00:00'),('dl_gerenc_modulos',20,'2014-07-09 17:41:08','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_gerenc_usuarios',4,'2014-06-27 18:54:08','2014-07-10 11:40:52',NULL,0,4,NULL),('dl_gerenc_usuarios',5,'2014-06-28 16:46:59','2014-07-11 16:31:55',NULL,4,5,NULL),('dl_gerenc_usuarios',6,'2014-06-30 16:05:26','2014-07-02 10:41:01',NULL,4,4,NULL),('dl_gerenc_usuarios',7,'2014-06-30 16:06:52','2014-07-10 09:08:41','2014-07-10 09:14:08',6,0,'0000-00-00 00:00:00'),('dl_gerenc_usuarios_permissoes',0,'2014-06-28 17:09:31','2014-07-02 10:41:01',NULL,4,4,NULL),('dl_gerenc_usuarios_permissoes',1,'2014-06-27 18:54:08','2014-07-10 09:08:41',NULL,0,0,NULL),('dl_gerenc_usuarios_recuperacoes',1,'2014-07-01 16:57:06','2014-07-01 17:45:50',NULL,0,0,NULL),('dl_gerenc_usuarios_recuperacoes',2,'2014-07-01 17:17:39','2014-07-01 23:18:59',NULL,0,0,NULL),('dl_gerenc_usuarios_recuperacoes',3,'2014-07-01 17:18:29','2014-07-01 23:23:07',NULL,0,0,NULL),('dl_gerenc_usuarios_recuperacoes',4,'2014-07-01 17:25:11','2014-07-02 16:47:36',NULL,0,0,NULL),('dl_gerenc_usuarios_recuperacoes',5,'2014-07-01 17:25:47','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_gerenc_usuarios_recuperacoes',6,'2014-07-01 16:47:12','2014-07-01 17:26:04',NULL,0,0,NULL),('dl_gerenc_usuarios_recuperacoes',7,'2014-07-01 17:26:26','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_assuntos_contato',6,'2014-06-28 16:48:09','2014-06-28 16:49:54',NULL,4,4,NULL),('dl_site_assuntos_contato',7,'2014-06-28 16:48:25','2014-06-28 16:49:31',NULL,4,4,NULL),('dl_site_assuntos_contato',8,'2014-06-28 16:49:14','0000-00-00 00:00:00',NULL,4,0,NULL),('dl_site_assuntos_contato',9,'2014-06-28 16:50:27','2014-07-02 12:40:13',NULL,4,4,NULL),('dl_site_assuntos_contato',10,'2014-06-30 11:30:49','2014-07-10 09:31:48','2014-07-10 09:32:00',0,0,'0000-00-00 00:00:00'),('dl_site_assuntos_contato',11,'2014-07-11 09:47:15','0000-00-00 00:00:00','2014-07-11 09:47:22',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',1,'2014-07-02 11:51:58','2014-07-02 11:58:57','2014-07-08 12:57:57',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',2,'2014-07-02 11:55:23','2014-07-02 12:01:23','2014-07-08 12:55:31',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',3,'2014-07-02 12:06:29','0000-00-00 00:00:00','2014-07-08 12:51:56',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',4,'2014-07-02 11:45:07','2014-07-02 12:07:42','2014-07-08 12:51:20',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',5,'2014-07-02 16:47:01','0000-00-00 00:00:00','2014-07-08 12:53:23',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',6,'2014-07-08 12:58:26','0000-00-00 00:00:00','2014-07-08 13:01:02',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',7,'2014-07-08 12:58:26','0000-00-00 00:00:00','2014-07-08 13:01:02',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',8,'2014-07-08 12:58:27','0000-00-00 00:00:00','2014-07-08 13:01:02',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',9,'2014-07-08 12:58:27','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',10,'2014-07-08 12:58:27','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',11,'2014-07-08 12:58:28','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',12,'2014-07-08 12:58:30','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',13,'2014-07-08 12:58:31','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',14,'2014-07-08 12:58:31','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',15,'2014-07-08 12:58:33','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',16,'2014-07-08 12:58:33','0000-00-00 00:00:00','2014-07-08 12:59:12',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',17,'2014-07-08 12:58:33','0000-00-00 00:00:00','2014-07-08 13:01:02',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',18,'2014-07-08 12:58:34','0000-00-00 00:00:00','2014-07-08 13:01:02',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',19,'2014-07-08 12:58:35','0000-00-00 00:00:00','2014-07-08 13:01:02',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',20,'2014-07-08 12:58:36','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',21,'2014-07-08 12:58:36','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',22,'2014-07-08 12:58:36','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',23,'2014-07-08 12:58:38','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',24,'2014-07-08 12:58:38','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',25,'2014-07-08 12:58:40','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',26,'2014-07-08 12:58:40','0000-00-00 00:00:00',NULL,0,0,NULL),('dl_site_contatos',27,'2014-07-08 12:58:40','0000-00-00 00:00:00','2014-07-08 13:00:38',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',28,'2014-07-08 12:58:42','0000-00-00 00:00:00','2014-07-08 13:01:02',0,0,'0000-00-00 00:00:00'),('dl_site_contatos',29,'2014-07-08 12:58:43','0000-00-00 00:00:00','2014-07-08 12:59:30',0,0,'0000-00-00 00:00:00'),('dl_site_dados_contato',1,'2014-06-28 17:10:25','2014-07-10 09:39:44',NULL,4,0,NULL),('dl_site_dados_contato',2,'2014-07-10 09:40:02','0000-00-00 00:00:00','2014-07-10 09:40:11',0,0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `dl_gerenc_registros_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_gerenc_temas`
--

DROP TABLE IF EXISTS `dl_gerenc_temas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_gerenc_temas` (
  `tema_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tema_descr` varchar(20) NOT NULL,
  `tema_diretorio` varchar(10) NOT NULL,
  `tema_publicar` int(11) NOT NULL DEFAULT '1',
  `tema_delete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tema_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_gerenc_temas`
--

LOCK TABLES `dl_gerenc_temas` WRITE;
/*!40000 ALTER TABLE `dl_gerenc_temas` DISABLE KEYS */;
INSERT INTO `dl_gerenc_temas` VALUES (1,'Padrão','/padrao/',1,0);
/*!40000 ALTER TABLE `dl_gerenc_temas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_gerenc_usuarios`
--

DROP TABLE IF EXISTS `dl_gerenc_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_gerenc_usuarios` (
  `usuario_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario_info_grupo` bigint(20) NOT NULL,
  `usuario_info_nome` varchar(50) NOT NULL,
  `usuario_info_email` varchar(100) NOT NULL,
  `usuario_info_telefone` varchar(16) DEFAULT NULL,
  `usuario_info_sexo` enum('M','F') NOT NULL,
  `usuario_info_login` varchar(20) NOT NULL,
  `usuario_info_senha` varchar(32) NOT NULL COMMENT 'Hash MD5 dupla da senha do usuário',
  `usuario_pref_idioma` bigint(20) NOT NULL DEFAULT '1',
  `usuario_pref_tema` bigint(20) NOT NULL DEFAULT '1',
  `usuario_pref_formato_data` bigint(20) NOT NULL DEFAULT '1',
  `usuario_pref_num_registros` int(11) NOT NULL DEFAULT '20',
  `usuario_conf_bloq` int(11) NOT NULL DEFAULT '0',
  `usuario_conf_reset` int(11) NOT NULL DEFAULT '1',
  `usuario_delete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuario_info_email` (`usuario_info_email`),
  UNIQUE KEY `usuario_info_login` (`usuario_info_login`),
  KEY `FK_usuario_info_grupo` (`usuario_info_grupo`),
  KEY `FK_usuario_pref_idioma` (`usuario_pref_idioma`),
  KEY `FK_usuario_pref_tema` (`usuario_pref_tema`),
  KEY `FK_usuario_pref_formato_data` (`usuario_pref_formato_data`),
  CONSTRAINT `FK_usuario_info_grupo` FOREIGN KEY (`usuario_info_grupo`) REFERENCES `dl_gerenc_grupos_usuarios` (`grupo_usuario_id`),
  CONSTRAINT `FK_usuario_pref_formato_data` FOREIGN KEY (`usuario_pref_formato_data`) REFERENCES `dl_gerenc_formatos_data` (`formato_data_id`),
  CONSTRAINT `FK_usuario_pref_idioma` FOREIGN KEY (`usuario_pref_idioma`) REFERENCES `dl_gerenc_idiomas` (`idioma_id`),
  CONSTRAINT `FK_usuario_pref_tema` FOREIGN KEY (`usuario_pref_tema`) REFERENCES `dl_gerenc_temas` (`tema_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_gerenc_usuarios`
--

LOCK TABLES `dl_gerenc_usuarios` WRITE;
/*!40000 ALTER TABLE `dl_gerenc_usuarios` DISABLE KEYS */;
INSERT INTO `dl_gerenc_usuarios` VALUES (4,12,'Administrador','admin@gerenc.com.br','(__) _ ____-____','M','admin','c3284d0f94606de1fd2af172aba15bf3',1,1,1,2,0,0,0),(5,14,'Convidado','convidado@gerenc.com.br','(__) _ ____-____','M','convidado','1cafb68f9598ee2ee8c3fe41ae76e809',1,1,1,20,0,0,0),(6,13,'Diego Lepera','d_lepera@hotmail.com','(__) _ ____-____','M','diego.lepera','fade225f096f9138f98f29887fc1f10d',2,1,1,20,0,0,0);
/*!40000 ALTER TABLE `dl_gerenc_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_gerenc_usuarios_permissoes`
--

DROP TABLE IF EXISTS `dl_gerenc_usuarios_permissoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_gerenc_usuarios_permissoes` (
  `permissao_usuario` bigint(20) NOT NULL,
  `permissao_modulo` bigint(20) NOT NULL,
  `permissao_ver` int(11) NOT NULL DEFAULT '0',
  `permissao_inserir` int(11) NOT NULL DEFAULT '0',
  `permissao_editar` int(11) NOT NULL DEFAULT '0',
  `permissao_remover` int(11) NOT NULL DEFAULT '0',
  `permissao_total` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`permissao_usuario`,`permissao_modulo`),
  KEY `FK_permissao_modulo` (`permissao_modulo`),
  CONSTRAINT `FK_permissao_modulo` FOREIGN KEY (`permissao_modulo`) REFERENCES `dl_gerenc_modulos` (`modulo_id`) ON DELETE CASCADE,
  CONSTRAINT `FK_permissao_usuario` FOREIGN KEY (`permissao_usuario`) REFERENCES `dl_gerenc_usuarios` (`usuario_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_gerenc_usuarios_permissoes`
--

LOCK TABLES `dl_gerenc_usuarios_permissoes` WRITE;
/*!40000 ALTER TABLE `dl_gerenc_usuarios_permissoes` DISABLE KEYS */;
INSERT INTO `dl_gerenc_usuarios_permissoes` VALUES (4,2,1,1,1,1,1),(4,3,1,1,1,1,1),(4,4,1,1,1,1,1),(4,6,1,1,1,1,1),(4,7,1,1,1,1,1),(4,8,1,1,1,1,1),(5,2,0,0,0,0,0),(5,3,0,0,0,0,0),(5,4,0,0,0,0,0),(5,6,1,0,0,0,0),(5,7,1,0,0,0,0),(5,8,1,0,0,0,0),(6,2,0,0,0,0,0),(6,3,0,0,0,0,0),(6,4,0,0,0,0,0),(6,6,1,0,0,1,0),(6,7,1,1,1,1,0),(6,8,1,1,1,1,0);
/*!40000 ALTER TABLE `dl_gerenc_usuarios_permissoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_gerenc_usuarios_recuperacoes`
--

DROP TABLE IF EXISTS `dl_gerenc_usuarios_recuperacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_gerenc_usuarios_recuperacoes` (
  `recuperacao_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `recuperacao_usuario` bigint(20) NOT NULL,
  `recuperacao_hash` varchar(32) NOT NULL,
  `recuperacao_status` enum('E','C','R','X') DEFAULT 'E' COMMENT 'E => Enviado; C => Cancelado; R => Recuperado; X => Expirado',
  PRIMARY KEY (`recuperacao_id`),
  UNIQUE KEY `recuperacao_hash` (`recuperacao_hash`),
  KEY `FK_recuperacao_usuario` (`recuperacao_usuario`),
  CONSTRAINT `FK_recuperacao_usuario` FOREIGN KEY (`recuperacao_usuario`) REFERENCES `dl_gerenc_usuarios` (`usuario_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_gerenc_usuarios_recuperacoes`
--

LOCK TABLES `dl_gerenc_usuarios_recuperacoes` WRITE;
/*!40000 ALTER TABLE `dl_gerenc_usuarios_recuperacoes` DISABLE KEYS */;
INSERT INTO `dl_gerenc_usuarios_recuperacoes` VALUES (1,6,'0d1aa620d0622659beb0dca1f1e3da13','R'),(2,6,'6614afc90b08deef1661d3ff27fcf2c5','R'),(3,6,'04e2a951dc661a2634ae31404f2cc4dc','R'),(4,5,'10565c530f3352a88d4e1f2fa9209326','E');
/*!40000 ALTER TABLE `dl_gerenc_usuarios_recuperacoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_site_assuntos_contato`
--

DROP TABLE IF EXISTS `dl_site_assuntos_contato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_assuntos_contato` (
  `assunto_contato_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `assunto_contato_descr` varchar(80) NOT NULL,
  `assunto_contato_email` varchar(100) NOT NULL,
  `assunto_contato_publicar` int(11) NOT NULL DEFAULT '1',
  `assunto_contato_delete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`assunto_contato_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_site_assuntos_contato`
--

LOCK TABLES `dl_site_assuntos_contato` WRITE;
/*!40000 ALTER TABLE `dl_site_assuntos_contato` DISABLE KEYS */;
INSERT INTO `dl_site_assuntos_contato` VALUES (6,'Dúvida','d_lepera@hotmail.com',1,0),(7,'Elogio','d_lepera@hotmail.com',1,0),(8,'Sugestão','d_lepera@hotmail.com',1,0),(9,'Outro','d_lepera@hotmail.com',1,0);
/*!40000 ALTER TABLE `dl_site_assuntos_contato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_site_contatos`
--

DROP TABLE IF EXISTS `dl_site_contatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_contatos` (
  `contato_site_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `contato_site_nome` varchar(80) NOT NULL,
  `contato_site_email` varchar(100) NOT NULL,
  `contato_site_telefone` varchar(16) DEFAULT NULL,
  `contato_site_assunto` bigint(20) NOT NULL,
  `contato_site_mensagem` longtext NOT NULL,
  `contato_site_delete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`contato_site_id`),
  KEY `FK_contato_site_assunto` (`contato_site_assunto`),
  CONSTRAINT `FK_contato_site_assunto` FOREIGN KEY (`contato_site_assunto`) REFERENCES `dl_site_assuntos_contato` (`assunto_contato_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_site_contatos`
--

LOCK TABLES `dl_site_contatos` WRITE;
/*!40000 ALTER TABLE `dl_site_contatos` DISABLE KEYS */;
INSERT INTO `dl_site_contatos` VALUES (9,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0),(10,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0),(11,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0),(12,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0),(13,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0),(14,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0),(15,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0),(20,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0),(21,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0),(22,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0),(23,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0),(24,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0),(25,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0),(26,'Diego Lepera','d_lepera@hotmail.com','6183503517',7,'teste',0);
/*!40000 ALTER TABLE `dl_site_contatos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_site_dados_contato`
--

DROP TABLE IF EXISTS `dl_site_dados_contato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_dados_contato` (
  `dado_contato_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dado_contato_tipo` bigint(20) NOT NULL,
  `dado_contato_descr` varchar(100) NOT NULL,
  `dado_contato_publicar` int(11) NOT NULL DEFAULT '1',
  `dado_contato_delete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`dado_contato_id`),
  KEY `FK_dado_contato_tipo` (`dado_contato_tipo`),
  CONSTRAINT `FK_dado_contato_tipo` FOREIGN KEY (`dado_contato_tipo`) REFERENCES `dl_site_dados_contato_tipos` (`tipo_dado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_site_dados_contato`
--

LOCK TABLES `dl_site_dados_contato` WRITE;
/*!40000 ALTER TABLE `dl_site_dados_contato` DISABLE KEYS */;
INSERT INTO `dl_site_dados_contato` VALUES (1,4,'d_lepera@hotmail.com',1,0);
/*!40000 ALTER TABLE `dl_site_dados_contato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_site_dados_contato_tipos`
--

DROP TABLE IF EXISTS `dl_site_dados_contato_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_site_dados_contato_tipos` (
  `tipo_dado_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipo_dado_descr` varchar(30) NOT NULL,
  `tipo_dado_icone` varchar(255) DEFAULT NULL,
  `tipo_dado_publicar` int(11) NOT NULL DEFAULT '1',
  `tipo_dado_delete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tipo_dado_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_site_dados_contato_tipos`
--

LOCK TABLES `dl_site_dados_contato_tipos` WRITE;
/*!40000 ALTER TABLE `dl_site_dados_contato_tipos` DISABLE KEYS */;
INSERT INTO `dl_site_dados_contato_tipos` VALUES (1,'Fone fixo',NULL,1,0),(2,'Fone celular',NULL,1,0),(3,'Fone comercial',NULL,1,0),(4,'E-mail',NULL,1,0);
/*!40000 ALTER TABLE `dl_site_dados_contato_tipos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-11 16:45:44
