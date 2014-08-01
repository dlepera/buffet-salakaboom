-- Dias da semana
CREATE TABLE IF NOT EXISTS salakaboom_dias_semana(
    dia_semana_id BIGINT NOT NULL AUTO_INCREMENT,
    dia_semana_descr VARCHAR(20) NOT NULL,
    dia_semana_abrev VARCHAR(3) NOT NULL,
    dia_semana_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(dia_semana_id),
    CONSTRAINT CK_dia_semana_delete CHECK( dia_semana_delete IN(0,1) )
) ENGINE=INNODB;

INSERT INTO salakaboom_dias_semana (dia_semana_descr, dia_semana_abrev) VALUES
('Domingo', 'Dom'), ('Segunda-feira', 'Seg'), ('Terça-feira', 'Ter'), ('Quarta-feira', 'Qua'),
('Quinta-feira', 'Qui'), ('Sexta-feira', 'Sex'), ('Sábado', 'Sab');

-- Estrutura de cadastro do cardápio
CREATE TABLE IF NOT EXISTS salakaboom_cardapios(
    cardapio_id BIGINT NOT NULL AUTO_INCREMENT,
    cardapio_titulo VARCHAR(50) NOT NULL,
    cardapio_descr TEXT,
    cardapio_ordem INT NOT NULL DEFAULT 0,
    cardapio_publicar INT NOT NULL DEFAULT 1,
    cardapio_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(cardapio_id),
    CONSTRAINT CK_cardapio_publicar CHECK( cardapio_publicar IN(0,1) ),
    CONSTRAINT CK_cardapio_delete CHECK( cardapio_delete IN(0,1) )
) ENGINE=INNODB;


CREATE TABLE IF NOT EXISTS salakaboom_cardapios_itens(
    item_cardapio BIGINT NOT NULL,
    item_cardapio_id BIGINT NOT NULL AUTO_INCREMENT,
    item_cardapio_descr VARCHAR(50) NOT NULL,
    item_cardapio_publicar INT NOT NULL DEFAULT 1,
    item_cardapio_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(item_cardapio_id),
    CONSTRAINT FK_item_cardapio FOREIGN KEY(item_cardapio) REFERENCES salakaboom_cardapios(cardapio_id) ON DELETE CASCADE,
    CONSTRAINT CK_item_cardapio_publicar CHECK( item_cardapio_publicar IN(0,1) ),
    CONSTRAINT CK_item_cardapio_delete CHECK( item_cardapio_delete IN(0,1) )
) ENGINE=INNODB;

-- Estrutura de cadastro dos parceiros
CREATE TABLE IF NOT EXISTS salakaboom_parceiros_tipos(
    tipo_parceiro_id BIGINT NOT NULL AUTO_INCREMENT,
    tipo_parceiro_descr VARCHAR(50) NOT NULL,
    tipo_parceiro_publicar INT NOT NULL DEFAULT 1,
    tipo_parceiro_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(tipo_parceiro_id),
    CONSTRAINT CK_tipo_parceiro_publicar CHECK( tipo_parceiro_publicar IN(0,1) ),
    CONSTRAINT CK_tipo_parceiro_delete CHECK( tipo_parceiro_delete IN(0,1) )
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS salakaboom_parceiros(
    parceiro_id BIGINT NOT NULL AUTO_INCREMENT,
    parceiro_tipo BIGINT NOT NULL,
    parceiro_nome VARCHAR(50) NOT NULL,
    parceiro_descr TEXT NOT NULL,
    parceiro_email VARCHAR(100),
    parceiro_telefone VARCHAR(17),
    parceiro_site VARCHAR(100),
    parceiro_imagem VARCHAR(100) NOT NULL,
    parceiro_publicar INT NOT NULL DEFAULT 1,
    parceiro_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(parceiro_id),
    CONSTRAINT FK_parceiro_tipo FOREIGN KEY(parceiro_tipo) REFERENCES salakaboom_parceiros_tipos(tipo_parceiro_id),
    CONSTRAINT CK_parceiro_publicar CHECK( parceiro_publicar IN(0,1) ),
    CONSTRAINT CK_parceiro_delete CHECK( parceiro_delete IN(0,1) )
) ENGINE=INNODB;

-- Estrutura de cadastro dos produtos
CREATE TABLE IF NOT EXISTS salakaboom_produtos_tipos(
    tipo_produto_id BIGINT NOT NULL AUTO_INCREMENT,
    tipo_produto_descr VARCHAR(50) NOT NULL,
    tipo_produto_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(tipo_produto_id),
    CONSTRAINT CK_tipo_produto_delete CHECK( tipo_produto_delete IN(0,1) )
) ENGINE=INNODB;

-- Incluir os tipos de produtos
INSERT INTO salakaboom_produtos_tipos (tipo_produto_descr) VALUES
('Pacote de festa'), ('Opcional'), ('Serviço tercerizado'), ('Convidados adicionais');

CREATE TABLE IF NOT EXISTS salakaboom_produtos_tipos_valores(
    tipo_valor_id BIGINT NOT NULL AUTO_INCREMENT,
    tipo_valor_descr VARCHAR(50) NOT NULL,
    tipo_valor_fator INT NOT NULL,
    tipo_valor_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(tipo_valor_id),
    CONSTRAINT CK_tipo_valor_delete CHECK( tipo_valor_delete IN(0,1) )
) ENGINE=INNODB;

-- Incluir os tipos de valores
INSERT INTO salakaboom_produtos_tipos_valores (tipo_valor_descr, tipo_valor_fator) VALUES
('Por pessoa', 1), ('Preço fixo', 0), ('Tercerizado', 0), ('Pacote de festa', 50);

CREATE TABLE IF NOT EXISTS salakaboom_produtos(
    produto_id BIGINT NOT NULL AUTO_INCREMENT,
    produto_tipo BIGINT NOT NULL,
    produto_nome VARCHAR(80) NOT NULL,
    produto_descr TEXT,
    produto_valor DECIMAL(10,2) NOT NULL,
    produto_tipo_valor BIGINT NOT NULL, 
    produto_publicar INT NOT NULL DEFAULT 1,
    produto_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(produto_id),
    CONSTRAINT CK_produto_publicar CHECK( produto_publicar IN(0,1) ),
    CONSTRAINT CK_produto_delete CHECK( produto_delete IN(0,1) )
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS salakaboom_produtos_dispon(
    dispon_produto BIGINT NOT NULL,
    dispon_dia_semana BIGINT NOT NULL,
    PRIMARY KEY(dispon_produto, dispon_dia_semana),
    CONSTRAINT FK_dispon_produto FOREIGN KEY(dispon_produto) REFERENCES salakaboom_produtos(produto_id) ON DELETE CASCADE
) ENGINE=INNODB;

-- Estrutura de cadastro dos orçamentos
CREATE TABLE IF NOT EXISTS salakaboom_orcamentos(
    orcamento_id BIGINT NOT NULL AUTO_INCREMENT,
    orcamento_info_nome VARCHAR(100) NOT NULL,
    orcamento_info_email VARCHAR(100) NOT NULL,
    orcamento_info_telefone VARCHAR(17),
    orcamento_festa_data DATE NOT NULL,
    orcamento_festa_pacote BIGINT NOT NULL,
    orcamento_festa_valor_pacote DECIMAL(10,2) NOT NULL,
    orcamento_festa_convidados INT NOT NULL,
    orcamento_delete INT NOT NULL DEFAULT 0,
    PRIMARY KEY(orcamento_id),
    CONSTRAINT FK_orcamento_festa_pacote FOREIGN KEY(orcamento_festa_pacote) REFERENCES salakaboom_produtos(produto_id),
    CONSTRAINT CK_orcamento_delete CHECK( orcamento_delete IN(0,1) )
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS salakaboom_orcamentos_opcionais(
    opcional_orcamento BIGINT NOT NULL,
    opcional_orcamento_id BIGINT NOT NULL AUTO_INCREMENT,
    opcional_orcamento_produto BIGINT NOT NULL,
    opcional_orcamento_qtde INT NOT NULL,
    opcional_orcamento_valor DECIMAL(10,2) NOT NULL COMMENT 'Valor unitário',
    PRIMARY KEY(opcional_orcamento_id),
    UNIQUE KEY(opcional_orcamento_produto, opcional_orcamento),
    CONSTRAINT FK_opcional_orcamento FOREIGN KEY(opcional_orcamento) REFERENCES salakaboom_orcamentos(orcamento_id) ON DELETE CASCADE,
    CONSTRAINT FK_opcional_orcamento_produto FOREIGN KEY(opcional_orcamento_produto) REFERENCES salakaboom_produtos(produto_id),
    CONSTRAINT CK_opcional_qtde CHECK( opcional_qtde > 0 )
) ENGINE=INNODB;