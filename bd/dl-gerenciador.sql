-- Gravar informações do registro
CREATE TABLE IF NOT EXISTS dl_painel_registros_logs(
    log_registro_tabela VARCHAR(100) NOT NULL,
    log_registro_idreg BIGINT NOT NULL,
    log_registro_data_criacao DATETIME NOT NULL,
    log_registro_data_alteracao DATETIME NULL,
    log_registro_data_exclusao DATETIME NULL
    log_registro_usuario_criacao BIGINT NOT NULL,
    log_registro_usuario_alteracao BIGINT NULL,
    log_registro_usuario_exclusao BIGINT NULL,
    PRIMARY KEY(log_registro_tabela, log_registro_idreg)
) ENGINE=INNODB;

-- Estrutura da configuração de e-mails
CREATE TABLE IF NOT EXISTS dl_painel_email_config(
    config_email_id BIGINT NOT NULL AUTO_INCREMENT,
    config_email_titulo VARCHAR(30) NOT NULL,
    config_email_host VARCHAR(80) NOT NULL,
    config_email_porta INT NOT NULL DEFAULT 25,
    config_email_autent INT NOT NULL,
    config_email_cripto VARCHAR(5) NOT NULL,
    config_email_conta VARCHAR(100) NOT NULL,
    config_email_senha VARCHAR(20) NOT NULL,
    config_email_de_email VARCHAR(100),
    config_email_de_nome VARCHAR(100),
    config_email_responder_para VARCHAR(100),
    config_email_html INT NOT NULL DEFAULT '1',
    config_email_principal INT NOT NULL DEFAULT '0',
    config_email_delete INT NOT NULL DEFAULT '0',
    PRIMARY KEY(config_email_id)
) ENGINE=INNODB;

-- Logs de tentativas e envios de e-mails
CREATE TABLE IF NOT EXISTS dl_painel_email_logs(
    log_email_id BIGINT NOT NULL AUTO_INCREMENT,
    log_email_config BIGINT NULL,
    log_email_ip VARCHAR(80) NOT NULL COMMENT 'IP de onde saiu a requisição',
    log_email_classe VARCHAR(20) NOT NULL COMMENT 'Nome da classe que executou o envio',
    log_email_tabela VARCHAR(30),
    log_email_idreg BIGINT COMMENT 'ID do registro que referencia o envio desse e-mail',
    log_email_status ENUM('S', 'E', 'F') NOT NULL DEFAULT 'S',
    log_email_mensagem TEXT,
    PRIMARY KEY(log_email_id),
    CONSTRAINT FK_log_email_config FOREIGN KEY(log_email_config) REFERENCES dl_painel_email_config(config_email_id) ON DELETE SET NULL
) ENGINE=INNODB;

-- Pacotes de idiomas do sistema
CREATE TABLE IF NOT EXISTS dl_painel_idiomas(
    idioma_id BIGINT NOT NULL AUTO_INCREMENT,
    idioma_descr VARCHAR(20) NOT NULL,
    idioma_sigla VARCHAR(5) NOT NULL,
    idioma_publicar INT NOT NULL DEFAULT '1',
    idioma_delete INT NOT NULL DEFAULT '0',
    PRIMARY KEY(idioma_id)
) ENGINE=INNODB;

-- Módulos do sistema
CREATE TABLE IF NOT EXISTS dl_painel_modulos(
    modulo_id BIGINT(20) NOT NULL AUTO_INCREMENT,
    modulo_pai BIGINT(20) DEFAULT NULL,
    modulo_nome VARCHAR(30) NOT NULL,
    modulo_descr TEXT,
    modulo_link VARCHAR(100) NOT NULL,
    modulo_publicar ENUM('0','1') NOT NULL DEFAULT '1',
    modulo_ordem INT(11) NOT NULL DEFAULT '0',
    modulo_delete INT NOT NULL DEFAULT '0',
    PRIMARY KEY (modulo_id),
    CONSTRAINT FK_modulo_pai FOREIGN KEY(modulo_pai) REFERENCES dl_painel_modulos(modulo_id) ON DELETE CASCADE
) ENGINE=INNODB;

-- Temas do sistema
CREATE TABLE IF NOT EXISTS dl_painel_temas(
    tema_id BIGINT NOT NULL AUTO_INCREMENT,
    tema_descr VARCHAR(20) NOT NULL,
    tema_diretorio VARCHAR(10) NOT NULL,
    tema_padrao INT NOT NULL DEFAULT 0,
    tema_publicar INT NOT NULL DEFAULT '1',
    tema_delete INT NOT NULL DEFAULT '0',
    PRIMARY KEY(tema_id),
    CONSTRAINT CK_tema_padrao CHECK( tema_padrao IN(0,1) )
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS dl_painel_formatos_data(
    formato_data_id BIGINT NOT NULL AUTO_INCREMENT,
    formato_data_descr VARCHAR(20) NOT NULL,
    formato_data_completo VARCHAR(20) NOT NULL,
    formato_data_data VARCHAR(10) NOT NULL,
    formato_data_hora VARCHAR(10) NOT NULL,
    formato_data_publicar INT NOT NULL DEFAULT '1',
    formato_data_delete INT NOT NULL DEFAULT '0',
    PRIMARY KEY(formato_data_id)
) ENGINE=INNODB;

-- Grupos de usuários
CREATE TABLE IF NOT EXISTS dl_painel_grupos_usuarios(
    grupo_usuario_id BIGINT NOT NULL AUTO_INCREMENT,
    grupo_usuario_descr VARCHAR(30) NOT NULL,   
    grupo_usuario_publicar INT NOT NULL DEFAULT '1',
    grupo_usuario_delete INT NOT NULL DEFAULT '0',
    PRIMARY KEY(grupo_usuario_id)
) ENGINE=INNODB;

-- Permissionamento padrão por grupo de usuários
CREATE TABLE IF NOT EXISTS dl_painel_grupos_permissoes(
    permissao_grupo BIGINT NOT NULL,
    permissao_modulo BIGINT NOT NULL,
    permissao_ver INT NOT NULL,
    permissao_incluir INT NOT NULL,
    permissao_editar INT NOT NULL,
    permissao_excluir INT NOT NULL,
    permissao_total INT NOT NULL,
    PRIMARY KEY(permissao_grupo, permissao_modulo),
    CONSTRAINT FK_permissao_grupo FOREIGN KEY(permissao_grupo) REFERENCES dl_painel_grupos_usuarios(grupo_usuario_id) ON DELETE CASCADE,
    CONSTRAINT FK_permissao_grupo_modulo FOREIGN KEY(permissao_modulo) REFERENCES dl_painel_modulos(modulo_id) ON DELETE CASCADE,
    CONSTRAINT CK_permissao_grupo_ver CHECK ( permissao_ver IN(0, 1) ),
    CONSTRAINT CK_permissao_grupo_incluir CHECK ( permissao_incluir IN(0, 1) ),
    CONSTRAINT CK_permissao_grupo_editar CHECK ( permissao_editar IN(0, 1) ),
    CONSTRAINT CK_permissao_grupo_excluir CHECK ( permissao_excluir IN(0, 1) ),
    CONSTRAINT CK_permissao_grupo_total CHECK ( permissao_total IN(0, 1) )
) ENGINE=INNODB;

-- Cadastro de usuários
CREATE TABLE IF NOT EXISTS dl_painel_usuarios(
    usuario_id BIGINT NOT NULL AUTO_INCREMENT,
    usuario_info_grupo BIGINT NOT NULL,
    usuario_info_nome VARCHAR(50) NOT NULL,
    usuario_info_email VARCHAR(100) NOT NULL,
    usuario_info_telefone VARCHAR(16),
    usuario_info_sexo ENUM('M', 'F') NOT NULL,
    usuario_info_login VARCHAR(20) NOT NULL,
    usuario_info_senha VARCHAR(32) NOT NULL COMMENT 'Hash MD5 dupla da senha do usuário',
    usuario_pref_idioma BIGINT NOT NULL DEFAULT 1,
    usuario_pref_tema BIGINT NOT NULL DEFAULT 1,
    usuario_pref_formato_data BIGINT NOT NULL DEFAULT 1,
    usuario_pref_num_registros INT NOT NULL DEFAULT 20,
    usuario_conf_bloq INT NOT NULL DEFAULT '0',
    usuario_conf_reset INT NOT NULL DEFAULT '0',
    usuario_delete INT NOT NULL DEFAULT '0',
    PRIMARY KEY(usuario_id),
    UNIQUE KEY(usuario_info_email),
    UNIQUE KEY(usuario_info_login),
    CONSTRAINT FK_usuario_info_grupo FOREIGN KEY(usuario_info_grupo) REFERENCES dl_painel_grupos_usuarios(grupo_usuario_id),
    CONSTRAINT FK_usuario_pref_idioma FOREIGN KEY(usuario_pref_idioma) REFERENCES dl_painel_idiomas(idioma_id),
    CONSTRAINT FK_usuario_pref_tema FOREIGN KEY(usuario_pref_tema) REFERENCES dl_painel_temas(tema_id),
    CONSTRAINT FK_usuario_pref_formato_data FOREIGN KEY(usuario_pref_formato_data) REFERENCES dl_painel_formatos_data(formato_data_id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS dl_painel_usuarios_recuperacoes(
    recuperacao_id BIGINT NOT NULL AUTO_INCREMENT,
    recuperacao_usuario BIGINT NOT NULL,
    recuperacao_hash VARCHAR(32) NOT NULL,
    recuperacao_status ENUM('E', 'C', 'R', 'X') DEFAULT 'E' COMMENT 'E => Enviado; C => Cancelado; R => Recuperado; X => Expirado',
    PRIMARY KEY(recuperacao_id),
    UNIQUE KEY(recuperacao_hash),
    CONSTRAINT FK_recuperacao_usuario FOREIGN KEY(recuperacao_usuario) REFERENCES dl_painel_usuarios(usuario_id) ON DELETE CASCADE
) ENGINE=INNODB;

-- Permissionamento do usuários
CREATE TABLE IF NOT EXISTS dl_painel_usuarios_permissoes(
    permissao_usuario BIGINT NOT NULL,
    permissao_modulo BIGINT NOT NULL,
    permissao_ver INT NOT NULL DEFAULT 0,
    permissao_inserir INT NOT NULL DEFAULT 0,
    permissao_editar INT NOT NULL DEFAULT 0,
    permissao_remover INT NOT NULL DEFAULT 0,
    permissao_total INT NOT NULL DEFAULT 0,
    PRIMARY KEY(permissao_usuario, permissao_modulo),
    CONSTRAINT FK_permissao_usuario FOREIGN KEY(permissao_usuario) REFERENCES dl_painel_usuarios(usuario_id) ON DELETE CASCADE,
    CONSTRAINT FK_permissao_modulo FOREIGN KEY(permissao_modulo) REFERENCES dl_painel_modulos(modulo_id) ON DELETE CASCADE,
    CONSTRAINT CK_permissao_ver CHECK( permissao_ver IN(0,1) ),
    CONSTRAINT CK_permissao_inserir CHECK( permissao_inserir IN(0,1) ),
    CONSTRAINT CK_permissao_editar CHECK( permissao_editar IN(0,1) ),
    CONSTRAINT CK_permissao_remover CHECK( permissao_remover IN(0,1) ),
    CONSTRAINT CK_permissao_total CHECK( permissao_total IN(0,1) )
) ENGINE=INNODB;