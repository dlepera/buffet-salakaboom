-- Adequar os campos 'delete' e 'publicar' (aumentando compatibilidade com MSSQL)
-- Data: 09/07/2014

-- Tabela dl_gerenc_modulos
-- Alterar a estrutura
ALTER TABLE dl_gerenc_modulos MODIFY modulo_publicar INT NOT NULL DEFAULT 1;
ALTER TABLE dl_gerenc_modulos MODIFY modulo_delete INT NOT NULL DEFAULT 0;

-- Criar as restrições
ALTER TABLE dl_gerenc_modulos ADD CONSTRAINT CK_modulo_publicar CHECK ( modulo_publicar IN(0,1) );
ALTER TABLE dl_gerenc_modulos ADD CONSTRAINT CK_modulo_delete CHECK ( modulo_delete IN(0,1) );

-- Ajustar os valores dos campos alterados
UPDATE dl_gerenc_modulos SET modulo_publicar = 1, modulo_delete = 0;



-- Tabela dl_gerenc_email_config
-- Alterar a estrutura
ALTER TABLE dl_gerenc_email_config MODIFY config_email_autent INT NOT NULL DEFAULT 1;
ALTER TABLE dl_gerenc_email_config MODIFY config_email_html INT NOT NULL DEFAULT 1;
ALTER TABLE dl_gerenc_email_config MODIFY config_email_principal INT NOT NULL DEFAULT 0;
ALTER TABLE dl_gerenc_email_config MODIFY config_email_delete INT NOT NULL DEFAULT 0;

-- Criar as restrições
ALTER TABLE dl_gerenc_email_config ADD CONSTRAINT CK_config_email_autent CHECK ( config_email_autent IN(0,1) );
ALTER TABLE dl_gerenc_email_config ADD CONSTRAINT CK_config_email_html CHECK ( config_email_html IN(0,1) );
ALTER TABLE dl_gerenc_email_config ADD CONSTRAINT CK_config_email_principal CHECK ( config_email_principal IN(0,1) );
ALTER TABLE dl_gerenc_email_config ADD CONSTRAINT CK_config_email_delete CHECK ( config_email_delete IN(0,1) );

-- Ajustar os valores dos campos alterados
UPDATE dl_gerenc_email_config SET config_email_autent = 1, config_email_html = 1, config_email_principal = 0, config_email_delete = 0;

-- Tabela dl_gerenc_grupos_usuarios
-- Alterar a estrutura
ALTER TABLE dl_gerenc_grupos_usuarios MODIFY grupo_usuario_publicar INT NOT NULL DEFAULT 1;
ALTER TABLE dl_gerenc_grupos_usuarios MODIFY grupo_usuario_delete INT NOT NULL DEFAULT 0;

-- Criar as restrições
ALTER TABLE dl_gerenc_grupos_usuarios ADD CONSTRAINT CK_grupo_usuario_publicar CHECK ( grupo_usuario_publicar IN(0,1) );
ALTER TABLE dl_gerenc_grupos_usuarios ADD CONSTRAINT CK_grupo_usuario_delete CHECK ( grupo_usuario_delete IN(0,1) );

-- Ajustar os valores dos campos alterados
UPDATE dl_gerenc_grupos_usuarios SET grupo_usuario_publicar = 1, grupo_usuario_delete = 0;


-- Tabela dl_gerenc_usuarios
-- Alterar a estrutura
ALTER TABLE dl_gerenc_usuarios MODIFY usuario_conf_bloq INT NOT NULL DEFAULT 0;
ALTER TABLE dl_gerenc_usuarios MODIFY usuario_conf_reset INT NOT NULL DEFAULT 1;
ALTER TABLE dl_gerenc_usuarios MODIFY usuario_delete INT NOT NULL DEFAULT 0;

-- Criar as restrições
ALTER TABLE dl_gerenc_usuarios ADD CONSTRAINT CK_usuario_conf_bloq CHECK ( usuario_conf_bloq IN(0,1) );
ALTER TABLE dl_gerenc_usuarios ADD CONSTRAINT CK_usuario_conf_reset CHECK ( usuario_conf_reset IN(0,1) );
ALTER TABLE dl_gerenc_usuarios ADD CONSTRAINT CK_usuario_delete CHECK ( usuario_delete IN(0,1) );

-- Ajustar os valores dos campos alterados
UPDATE dl_gerenc_usuarios SET usuario_conf_bloq = 0, usuario_conf_reset = 0, usuario_delete = 0;

-- Tabela dl_site_assuntos_contato
-- Alterar a estrutura
ALTER TABLE dl_site_assuntos_contato MODIFY assunto_contato_publicar INT NOT NULL DEFAULT 1;
ALTER TABLE dl_site_assuntos_contato MODIFY assunto_contato_delete INT NOT NULL DEFAULT 0;

-- Criar as restrições
ALTER TABLE dl_site_assuntos_contato ADD CONSTRAINT CK_assunto_contato_publicar CHECK ( assunto_contato_publicar IN(0,1) );
ALTER TABLE dl_site_assuntos_contato ADD CONSTRAINT CK_assunto_contato_delete CHECK ( assunto_contato_delete IN(0,1) );

-- Ajustar os valores dos campos alterados
UPDATE dl_site_assuntos_contato SET assunto_contato_publicar = 1, assunto_contato_delete = 0;

-- Tabela dl_site_dados_contato
-- Alterar a estrutura
ALTER TABLE dl_site_dados_contato MODIFY dado_contato_publicar INT NOT NULL DEFAULT 1;
ALTER TABLE dl_site_dados_contato MODIFY dado_contato_delete INT NOT NULL DEFAULT 0;

-- Criar as restrições
ALTER TABLE dl_site_dados_contato ADD CONSTRAINT CK_dado_contato_publicar CHECK ( dado_contato_publicar IN(0,1) );
ALTER TABLE dl_site_dados_contato ADD CONSTRAINT CK_dado_contato_delete CHECK ( dado_contato_delete IN(0,1) );

-- Ajustar os valores dos campos alterados
UPDATE dl_site_dados_contato SET dado_contato_publicar = 1, dado_contato_delete = 0;

-- Tabela dl_site_dados_contato_tipos
-- Alterar a estrutura
ALTER TABLE dl_site_dados_contato_tipos MODIFY tipo_dado_publicar INT NOT NULL DEFAULT 1;
ALTER TABLE dl_site_dados_contato_tipos MODIFY tipo_dado_delete INT NOT NULL DEFAULT 0;

-- Criar as restrições
ALTER TABLE dl_site_dados_contato_tipos ADD CONSTRAINT CK_tipo_dado_publicar CHECK ( tipo_dado_publicar IN(0,1) );
ALTER TABLE dl_site_dados_contato_tipos ADD CONSTRAINT CK_tipo_dado_delete CHECK ( tipo_dado_delete IN(0,1) );

-- Ajustar os valores dos campos alterados
UPDATE dl_site_dados_contato_tipos SET tipo_dado_publicar = 1, tipo_dado_delete = 0;


-- Tabela dl_site_contatos
-- Alterar a estrutura
ALTER TABLE dl_site_contatos MODIFY contato_site_delete INT NOT NULL DEFAULT 0;

-- Criar as restrições
ALTER TABLE dl_site_contatos ADD CONSTRAINT CK_contato_site_delete CHECK ( contato_site_delete IN(0,1) );

-- Ajustar os valores dos campos alterados
UPDATE dl_site_contatos SET contato_site_delete = 0;

-- Tabela dl_gerenc_formatos_data
-- Alterar a estrutura
ALTER TABLE dl_gerenc_formatos_data MODIFY formato_data_publicar INT NOT NULL DEFAULT 1;
ALTER TABLE dl_gerenc_formatos_data MODIFY formato_data_delete INT NOT NULL DEFAULT 0;

-- Criar as restrições
ALTER TABLE dl_gerenc_formatos_data ADD CONSTRAINT CK_formato_data_publicar CHECK ( formato_data_publicar IN(0,1) );
ALTER TABLE dl_gerenc_formatos_data ADD CONSTRAINT CK_formato_data_delete CHECK ( formato_data_delete IN(0,1) );

-- Ajustar os valores dos campos alterados
UPDATE dl_gerenc_formatos_data SET formato_data_publicar = 1, formato_data_delete = 0;


-- Tabela dl_gerenc_idiomas
-- Alterar a estrutura
ALTER TABLE dl_gerenc_idiomas MODIFY idioma_publicar INT NOT NULL DEFAULT 1;
ALTER TABLE dl_gerenc_idiomas MODIFY idioma_delete INT NOT NULL DEFAULT 0;

-- Criar as restrições
ALTER TABLE dl_gerenc_idiomas ADD CONSTRAINT CK_idioma_publicar CHECK ( idioma_publicar IN(0,1) );
ALTER TABLE dl_gerenc_idiomas ADD CONSTRAINT CK_idioma_delete CHECK ( idioma_delete IN(0,1) );

-- Ajustar os valores dos campos alterados
UPDATE dl_gerenc_idiomas SET idioma_publicar = 1, idioma_delete = 0;


-- Tabela dl_gerenc_temas
-- Alterar a estrutura
ALTER TABLE dl_gerenc_temas MODIFY tema_publicar INT NOT NULL DEFAULT 1;
ALTER TABLE dl_gerenc_temas MODIFY tema_delete INT NOT NULL DEFAULT 0;

-- Criar as restrições
ALTER TABLE dl_gerenc_temas ADD CONSTRAINT CK_tema_publicar CHECK ( tema_publicar IN(0,1) );
ALTER TABLE dl_gerenc_temas ADD CONSTRAINT CK_tema_delete CHECK ( tema_delete IN(0,1) );

-- Ajustar os valores dos campos alterados
UPDATE dl_gerenc_temas SET tema_publicar = 1, tema_delete = 0;