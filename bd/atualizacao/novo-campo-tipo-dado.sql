-- Incluir o campo 'tipo_dado_rede_social' na tabela 'dl_site_dados_contato_tipos'
ALTER TABLE dl_site_dados_contato_tipos ADD tipo_dado_rede_social INT NOT NULL DEFAULT 0 AFTER tipo_dado_icone;
ALTER TABLE dl_site_dados_contato_tipos ADD CONSTRAINT CK_tipo_dado_rede_social CHECK( tipo_dado_rede_social IN(0,1) );