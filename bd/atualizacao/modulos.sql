-- Alteração da estrutura de módulos
-- Data: 09/07/2014


-- Incluir a coluna nome
ALTER TABLE dl_gerenc_modulos ADD COLUMN modulo_nome VARCHAR(30) NOT NULL AFTER modulo_pai;

-- Passar o valor da coluna 'modulo_descr' para 'modulo_nome'
UPDATE dl_gerenc_modulos SET modulo_nome = modulo_descr;

-- Apagar os valores do campo 'modulo_descr'
UPDATE dl_gerenc_modulos SET modulo_descr = '';

-- Alterar a caluna 'modulo_descr'
ALTER TABLE dl_gerenc_modulos MODIFY modulo_descr TEXT;