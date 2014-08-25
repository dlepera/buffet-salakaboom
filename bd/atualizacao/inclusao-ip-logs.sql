-- Incluir o IP remoto nos logs de registros
ALTER TABLE dl_painel_registros_logs ADD log_registro_ip_criacao VARCHAR(15) NOT NULL;
ALTER TABLE dl_painel_registros_logs ADD log_registro_ip_alteracao VARCHAR(15);
ALTER TABLE dl_painel_registros_logs ADD log_registro_ip_exclusao VARCHAR(15);
