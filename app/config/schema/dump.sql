SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `liber` ;
CREATE SCHEMA IF NOT EXISTS `liber` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `liber` ;

-- -----------------------------------------------------
-- Table `liber`.`usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`usuarios` ;

CREATE  TABLE IF NOT EXISTS `liber`.`usuarios` (
  `id` INT(5) NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  `login` VARCHAR(50) NOT NULL ,
  `senha` CHAR(40) NOT NULL ,
  `tipo` INT(2) NOT NULL ,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1 ,
  `email` VARCHAR(100) NULL ,
  `tempo_criado` DATETIME NOT NULL ,
  `ultimo_login` DATETIME NULL ,
  `ultimo_logout` DATETIME NULL ,
  `eh_tecnico` TINYINT(1) NOT NULL DEFAULT 0 ,
  `eh_vendedor` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `usuario_UNIQUE` (`login` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `liber`.`empresas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`empresas` ;

CREATE  TABLE IF NOT EXISTS `liber`.`empresas` (
  `id` INT(5) NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  `cnpj` CHAR(14) NULL ,
  `inscricao_estadual` CHAR(12) NULL ,
  `telefone` CHAR(10) NULL ,
  `fax` CHAR(10) NULL ,
  `site` VARCHAR(100) NULL ,
  `endereco_email_principal` VARCHAR(100) NULL ,
  `endereco_email_secundario` VARCHAR(100) NULL ,
  `logradouro` VARCHAR(100) NOT NULL ,
  `numero` CHAR(10) NOT NULL ,
  `bairro` VARCHAR(100) NOT NULL ,
  `complemento` VARCHAR(30) NULL ,
  `cidade` VARCHAR(100) NOT NULL ,
  `estado` CHAR(2) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`cliente_categorias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`cliente_categorias` ;

CREATE  TABLE IF NOT EXISTS `liber`.`cliente_categorias` (
  `id` INT(5) NOT NULL AUTO_INCREMENT ,
  `descricao` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`clientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`clientes` ;

CREATE  TABLE IF NOT EXISTS `liber`.`clientes` (
  `id` INT(5) NULL AUTO_INCREMENT COMMENT 'Situacao:\nA -> Ativo\nI -> Inativo\nB -> Bloqueado' ,
  `data_cadastrado` DATETIME NOT NULL ,
  `tipo_pessoa` CHAR(1) NULL ,
  `nome` VARCHAR(100) NOT NULL ,
  `nome_fantasia` VARCHAR(100) NULL ,
  `logradouro_nome` VARCHAR(100) NOT NULL ,
  `logradouro_numero` CHAR(10) NOT NULL ,
  `logradouro_complemento` VARCHAR(50) NULL ,
  `bairro` VARCHAR(100) NOT NULL ,
  `cidade` VARCHAR(100) NULL ,
  `uf` CHAR(2) NULL ,
  `cep` CHAR(8) NULL ,
  `cnpj` CHAR(14) NULL ,
  `inscricao_estadual` CHAR(12) NULL ,
  `cpf` CHAR(11) NULL ,
  `rg` VARCHAR(50) NULL ,
  `inscricao_municipal` VARCHAR(100) NULL ,
  `numero_telefone` CHAR(10) NULL ,
  `numero_celular` CHAR(10) NULL ,
  `endereco_email` VARCHAR(100) NULL ,
  `observacao` TEXT NULL ,
  `situacao` CHAR(1) NOT NULL ,
  `cliente_categoria_id` INT(5) NOT NULL ,
  `empresa_id` INT(5) NOT NULL ,
  `atualizado` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  `usuario_cadastrou` INT(5) NOT NULL ,
  `usuario_alterou` INT(5) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_clientes_usuarios1` (`usuario_cadastrou` ASC) ,
  INDEX `fk_clientes_usuarios2` (`usuario_alterou` ASC) ,
  INDEX `fk_clientes_empresas1` (`empresa_id` ASC) ,
  INDEX `fk_clientes_cliente_categorias1` (`cliente_categoria_id` ASC) ,
  CONSTRAINT `fk_clientes_usuarios1`
    FOREIGN KEY (`usuario_cadastrou` )
    REFERENCES `liber`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clientes_usuarios2`
    FOREIGN KEY (`usuario_alterou` )
    REFERENCES `liber`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clientes_empresas1`
    FOREIGN KEY (`empresa_id` )
    REFERENCES `liber`.`empresas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clientes_cliente_categorias1`
    FOREIGN KEY (`cliente_categoria_id` )
    REFERENCES `liber`.`cliente_categorias` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`fornecedor_categorias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`fornecedor_categorias` ;

CREATE  TABLE IF NOT EXISTS `liber`.`fornecedor_categorias` (
  `id` INT(5) NOT NULL AUTO_INCREMENT ,
  `descricao` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`fornecedores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`fornecedores` ;

CREATE  TABLE IF NOT EXISTS `liber`.`fornecedores` (
  `id` INT(5) NULL AUTO_INCREMENT COMMENT 'Situacao:\nA -> Ativo\nI -> Inativo\nB -> Bloqueado' ,
  `data_cadastrado` DATETIME NOT NULL ,
  `tipo_pessoa` CHAR(1) NULL ,
  `nome` VARCHAR(100) NOT NULL ,
  `nome_fantasia` VARCHAR(100) NULL ,
  `logradouro_nome` VARCHAR(100) NOT NULL ,
  `logradouro_numero` CHAR(10) NOT NULL ,
  `logradouro_complemento` VARCHAR(50) NULL ,
  `bairro` VARCHAR(100) NOT NULL ,
  `cidade` VARCHAR(100) NULL ,
  `uf` CHAR(2) NULL ,
  `cep` CHAR(8) NULL ,
  `cnpj` CHAR(14) NULL ,
  `inscricao_estadual` CHAR(12) NULL ,
  `cpf` CHAR(11) NULL ,
  `rg` VARCHAR(50) NULL ,
  `inscricao_municipal` VARCHAR(100) NULL ,
  `numero_telefone` CHAR(10) NULL ,
  `numero_celular` CHAR(10) NULL ,
  `endereco_email` VARCHAR(100) NULL ,
  `observacao` TEXT NULL ,
  `situacao` CHAR(1) NOT NULL ,
  `fornecedor_categoria_id` INT(5) NOT NULL ,
  `empresa_id` INT(5) NOT NULL ,
  `atualizado` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  `usuario_cadastrou` INT(5) NOT NULL ,
  `usuario_alterou` INT(5) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_fornecedores_usuarios1` (`usuario_cadastrou` ASC) ,
  INDEX `fk_fornecedores_usuarios2` (`usuario_alterou` ASC) ,
  INDEX `fk_fornecedores_empresas1` (`empresa_id` ASC) ,
  INDEX `fk_fornecedores_fornecedor_categorias1` (`fornecedor_categoria_id` ASC) ,
  CONSTRAINT `fk_fornecedores_usuarios1`
    FOREIGN KEY (`usuario_cadastrou` )
    REFERENCES `liber`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fornecedores_usuarios2`
    FOREIGN KEY (`usuario_alterou` )
    REFERENCES `liber`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fornecedores_empresas1`
    FOREIGN KEY (`empresa_id` )
    REFERENCES `liber`.`empresas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fornecedores_fornecedor_categorias1`
    FOREIGN KEY (`fornecedor_categoria_id` )
    REFERENCES `liber`.`fornecedor_categorias` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`plano_contas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`plano_contas` ;

CREATE  TABLE IF NOT EXISTS `liber`.`plano_contas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  `tipo` CHAR(1) NOT NULL COMMENT 'Tipo:\nD=Despesas\nR=Receitas\nE=Especiais' ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`contas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`contas` ;

CREATE  TABLE IF NOT EXISTS `liber`.`contas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  `apelido` VARCHAR(50) NOT NULL ,
  `banco` VARCHAR(50) NULL ,
  `agencia` VARCHAR(50) NULL ,
  `conta` VARCHAR(50) NULL ,
  `titular` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`tipo_documentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`tipo_documentos` ;

CREATE  TABLE IF NOT EXISTS `liber`.`tipo_documentos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`forma_pagamentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`forma_pagamentos` ;

CREATE  TABLE IF NOT EXISTS `liber`.`forma_pagamentos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  `conta_principal` INT NOT NULL ,
  `tipo_documento_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_forma_pagamentos_contas1` (`conta_principal` ASC) ,
  INDEX `fk_forma_pagamentos_tipo_documentos1` (`tipo_documento_id` ASC) ,
  CONSTRAINT `fk_forma_pagamentos_contas1`
    FOREIGN KEY (`conta_principal` )
    REFERENCES `liber`.`contas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_forma_pagamentos_tipo_documentos1`
    FOREIGN KEY (`tipo_documento_id` )
    REFERENCES `liber`.`tipo_documentos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`categoria_produtos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`categoria_produtos` ;

CREATE  TABLE IF NOT EXISTS `liber`.`categoria_produtos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`produtos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`produtos` ;

CREATE  TABLE IF NOT EXISTS `liber`.`produtos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  `categoria_produto_id` INT NOT NULL ,
  `tipo_produto` CHAR(1) NOT NULL COMMENT 'Tipo_produto:\nPara venda\nMatéria-prima\nMatéria-prima e venda\nProduto composto' ,
  `codigo_ean` VARCHAR(45) NULL ,
  `codigo_dun` VARCHAR(45) NULL ,
  `preco_custo` FLOAT NULL ,
  `preco_venda` FLOAT NULL ,
  `margem_lucro` FLOAT NULL ,
  `tem_estoque_ilimitado` TINYINT(1) NOT NULL DEFAULT 0 ,
  `estoque_minimo` INT(10) NULL ,
  `unidade` VARCHAR(45) NULL ,
  `quantidade_estoque_fiscal` INT(5) NOT NULL ,
  `quantidade_estoque_nao_fiscal` INT(5) NOT NULL ,
  `situacao` CHAR(1) NOT NULL DEFAULT 'L' COMMENT 'L = Em linha\nF = Fora de linha' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_produtos_categoria_produtos1` (`categoria_produto_id` ASC) ,
  CONSTRAINT `fk_produtos_categoria_produtos1`
    FOREIGN KEY (`categoria_produto_id` )
    REFERENCES `liber`.`categoria_produtos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`pagar_contas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`pagar_contas` ;

CREATE  TABLE IF NOT EXISTS `liber`.`pagar_contas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data_hora_cadastrada` DATETIME NOT NULL ,
  `eh_fiscal` TINYINT(1) NOT NULL ,
  `eh_cliente_ou_fornecedor` CHAR(1) NOT NULL ,
  `cliente_fornecedor_id` INT(5) NOT NULL ,
  `tipo_documento_id` INT NOT NULL ,
  `numero_documento` VARCHAR(20) NULL ,
  `valor` FLOAT(5) NOT NULL ,
  `conta_origem` INT NOT NULL ,
  `plano_conta_id` INT NOT NULL ,
  `data_vencimento` DATE NOT NULL ,
  `observacao` TEXT NULL ,
  `empresa_id` INT(5) NOT NULL ,
  `situacao` CHAR(1) NOT NULL COMMENT 'P = Paga\nN = Não paga' ,
  `numero_parcelas` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_contas_pagar_contas1` (`conta_origem` ASC) ,
  INDEX `fk_contas_pagar_plano_contas1` (`plano_conta_id` ASC) ,
  INDEX `fk_contas_pagar_tipo_documentos1` (`tipo_documento_id` ASC) ,
  INDEX `fk_pagar_contas_empresas1` (`empresa_id` ASC) ,
  CONSTRAINT `fk_contas_pagar_contas1`
    FOREIGN KEY (`conta_origem` )
    REFERENCES `liber`.`contas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_pagar_plano_contas1`
    FOREIGN KEY (`plano_conta_id` )
    REFERENCES `liber`.`plano_contas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_pagar_tipo_documentos1`
    FOREIGN KEY (`tipo_documento_id` )
    REFERENCES `liber`.`tipo_documentos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pagar_contas_empresas1`
    FOREIGN KEY (`empresa_id` )
    REFERENCES `liber`.`empresas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`receber_contas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`receber_contas` ;

CREATE  TABLE IF NOT EXISTS `liber`.`receber_contas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data_hora_cadastrada` DATETIME NOT NULL ,
  `eh_fiscal` TINYINT(1) NOT NULL ,
  `eh_cliente_ou_fornecedor` CHAR(1) NOT NULL ,
  `cliente_fornecedor_id` INT(5) NOT NULL ,
  `tipo_documento_id` INT NOT NULL ,
  `numero_documento` VARCHAR(20) NULL ,
  `valor` FLOAT(5) NOT NULL ,
  `conta_origem` INT NOT NULL ,
  `plano_conta_id` INT NOT NULL ,
  `data_vencimento` DATE NOT NULL ,
  `observacao` TEXT NULL ,
  `empresa_id` INT(5) NOT NULL ,
  `situacao` CHAR(1) NOT NULL COMMENT 'P = Paga\nN = Não paga' ,
  `numero_parcelas` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_contas_pagar_contas1` (`conta_origem` ASC) ,
  INDEX `fk_contas_pagar_plano_contas1` (`plano_conta_id` ASC) ,
  INDEX `fk_contas_pagar_tipo_documentos1` (`tipo_documento_id` ASC) ,
  INDEX `fk_receber_contas_empresas1` (`empresa_id` ASC) ,
  CONSTRAINT `fk_contas_pagar_contas10`
    FOREIGN KEY (`conta_origem` )
    REFERENCES `liber`.`contas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_pagar_plano_contas10`
    FOREIGN KEY (`plano_conta_id` )
    REFERENCES `liber`.`plano_contas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_pagar_tipo_documentos10`
    FOREIGN KEY (`tipo_documento_id` )
    REFERENCES `liber`.`tipo_documentos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_receber_contas_empresas1`
    FOREIGN KEY (`empresa_id` )
    REFERENCES `liber`.`empresas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`produto_estoque_logs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`produto_estoque_logs` ;

CREATE  TABLE IF NOT EXISTS `liber`.`produto_estoque_logs` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data_hora_registro` DATETIME NOT NULL ,
  `produto_id` INT NOT NULL ,
  `quantidade_estoque_fiscal` INT(5) NOT NULL ,
  `quantidade_estoque_nao_fiscal` INT(5) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_log_estoque_produtos_produtos1` (`produto_id` ASC) ,
  CONSTRAINT `fk_log_estoque_produtos_produtos1`
    FOREIGN KEY (`produto_id` )
    REFERENCES `liber`.`produtos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`pedido_vendas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`pedido_vendas` ;

CREATE  TABLE IF NOT EXISTS `liber`.`pedido_vendas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data_hora_cadastrado` DATETIME NOT NULL ,
  `cliente_id` INT(5) NOT NULL ,
  `forma_pagamento_id` INT NOT NULL ,
  `data_saida` DATE NULL ,
  `data_entrega` DATE NULL ,
  `data_venda` DATE NULL ,
  `custo_frete` FLOAT(5) NULL ,
  `custo_seguro` FLOAT(5) NULL ,
  `custo_outros` FLOAT(5) NULL ,
  `desconto` FLOAT(5) NULL ,
  `situacao` CHAR(1) NOT NULL COMMENT 'A = Aberto\nO = Orçamento\nC = Cancelado\nV = Vendido' ,
  `observacao` TEXT NULL ,
  `usuario_cadastrou` INT(5) NOT NULL ,
  `valor_bruto` FLOAT NOT NULL ,
  `valor_liquido` FLOAT NOT NULL ,
  `usuario_alterou` INT(5) NULL ,
  `empresa_id` INT(5) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pedido_vendas_clientes1` (`cliente_id` ASC) ,
  INDEX `fk_pedido_vendas_forma_pagamentos1` (`forma_pagamento_id` ASC) ,
  INDEX `fk_pedido_vendas_usuarios2` (`usuario_alterou` ASC) ,
  INDEX `fk_pedido_vendas_usuarios3` (`usuario_cadastrou` ASC) ,
  INDEX `fk_pedido_vendas_empresas1` (`empresa_id` ASC) ,
  CONSTRAINT `fk_pedido_vendas_clientes1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `liber`.`clientes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_vendas_forma_pagamentos1`
    FOREIGN KEY (`forma_pagamento_id` )
    REFERENCES `liber`.`forma_pagamentos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_vendas_usuarios2`
    FOREIGN KEY (`usuario_alterou` )
    REFERENCES `liber`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_vendas_usuarios3`
    FOREIGN KEY (`usuario_cadastrou` )
    REFERENCES `liber`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_vendas_empresas1`
    FOREIGN KEY (`empresa_id` )
    REFERENCES `liber`.`empresas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`servico_ordens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`servico_ordens` ;

CREATE  TABLE IF NOT EXISTS `liber`.`servico_ordens` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data_hora_cadastrada` DATETIME NOT NULL ,
  `cliente_id` INT(5) NOT NULL ,
  `usuario_id` INT(5) NOT NULL ,
  `forma_pagamento_id` INT NOT NULL ,
  `situacao` CHAR(1) NOT NULL COMMENT 'O = Orçamento\nS = Em espera\nX = Em execução\nF = Finalizada\nE = Entregue\nC = Cancelada' ,
  `dias_garantia` INT(3) NULL ,
  `data_hora_inicio` DATETIME NOT NULL ,
  `data_hora_fim` DATETIME NULL ,
  `custo_outros` FLOAT NULL ,
  `desconto` FLOAT NULL ,
  `defeitos_relatados` TEXT NULL ,
  `laudo_tecnico` TEXT NULL ,
  `observacao` TEXT NULL ,
  `valor_bruto` FLOAT NOT NULL ,
  `valor_liquido` FLOAT NOT NULL ,
  `usuario_cadastrou` INT(5) NOT NULL ,
  `usuario_alterou` INT(5) NULL ,
  `empresa_id` INT(5) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_servico_ordens_clientes1` (`cliente_id` ASC) ,
  INDEX `fk_servico_ordens_usuarios1` (`usuario_id` ASC) ,
  INDEX `fk_servico_ordens_forma_pagamentos1` (`forma_pagamento_id` ASC) ,
  INDEX `fk_servico_ordens_usuarios2` (`usuario_alterou` ASC) ,
  INDEX `fk_servico_ordens_usuarios3` (`usuario_cadastrou` ASC) ,
  INDEX `fk_servico_ordens_empresas1` (`empresa_id` ASC) ,
  CONSTRAINT `fk_servico_ordens_clientes1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `liber`.`clientes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servico_ordens_usuarios1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `liber`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servico_ordens_forma_pagamentos1`
    FOREIGN KEY (`forma_pagamento_id` )
    REFERENCES `liber`.`forma_pagamentos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servico_ordens_usuarios2`
    FOREIGN KEY (`usuario_alterou` )
    REFERENCES `liber`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servico_ordens_usuarios3`
    FOREIGN KEY (`usuario_cadastrou` )
    REFERENCES `liber`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servico_ordens_empresas1`
    FOREIGN KEY (`empresa_id` )
    REFERENCES `liber`.`empresas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`servico_categorias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`servico_categorias` ;

CREATE  TABLE IF NOT EXISTS `liber`.`servico_categorias` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`servicos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`servicos` ;

CREATE  TABLE IF NOT EXISTS `liber`.`servicos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  `servico_categoria_id` INT NOT NULL ,
  `valor` FLOAT(5) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_servico_tipos_servico_categorias1` (`servico_categoria_id` ASC) ,
  CONSTRAINT `fk_servico_tipos_servico_categorias1`
    FOREIGN KEY (`servico_categoria_id` )
    REFERENCES `liber`.`servico_categorias` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`servico_ordem_itens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`servico_ordem_itens` ;

CREATE  TABLE IF NOT EXISTS `liber`.`servico_ordem_itens` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `servico_ordem_id` INT NOT NULL ,
  `servico_id` INT NOT NULL ,
  `quantidade` INT(5) NOT NULL ,
  `valor` FLOAT(5) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_servico_ordem_itens_servicos1` (`servico_id` ASC) ,
  INDEX `fk_servico_ordem_itens_servico_ordens1` (`servico_ordem_id` ASC) ,
  CONSTRAINT `fk_servico_ordem_itens_servicos1`
    FOREIGN KEY (`servico_id` )
    REFERENCES `liber`.`servicos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servico_ordem_itens_servico_ordens1`
    FOREIGN KEY (`servico_ordem_id` )
    REFERENCES `liber`.`servico_ordens` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`veiculos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`veiculos` ;

CREATE  TABLE IF NOT EXISTS `liber`.`veiculos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `placa` VARCHAR(45) NULL ,
  `fabricante` VARCHAR(50) NULL ,
  `modelo` VARCHAR(50) NULL ,
  `ano` YEAR NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`motoristas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`motoristas` ;

CREATE  TABLE IF NOT EXISTS `liber`.`motoristas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  `cnh_numero_registro` INT NULL ,
  `cnh_data_validade` DATE NULL ,
  `cnh_categoria` CHAR(1) NULL ,
  `logradouro_nome` VARCHAR(100) NULL ,
  `logradouro_numero` VARCHAR(10) NULL ,
  `logradouro_complemento` VARCHAR(50) NULL ,
  `veiculo_padrao` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_motoristas_veiculos1` (`veiculo_padrao` ASC) ,
  CONSTRAINT `fk_motoristas_veiculos1`
    FOREIGN KEY (`veiculo_padrao` )
    REFERENCES `liber`.`veiculos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`carregamentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`carregamentos` ;

CREATE  TABLE IF NOT EXISTS `liber`.`carregamentos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data_hora_criado` DATETIME NOT NULL ,
  `situacao` CHAR(1) NOT NULL COMMENT 'Situacao\nL = Livre\nE = Enviada' ,
  `descricao` VARCHAR(50) NOT NULL ,
  `motorista_id` INT NOT NULL ,
  `veiculo_id` INT NOT NULL ,
  `observacao` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_carregamentos_motoristas1` (`motorista_id` ASC) ,
  INDEX `fk_carregamentos_veiculos1` (`veiculo_id` ASC) ,
  CONSTRAINT `fk_carregamentos_motoristas1`
    FOREIGN KEY (`motorista_id` )
    REFERENCES `liber`.`motoristas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_carregamentos_veiculos1`
    FOREIGN KEY (`veiculo_id` )
    REFERENCES `liber`.`veiculos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`carregamento_itens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`carregamento_itens` ;

CREATE  TABLE IF NOT EXISTS `liber`.`carregamento_itens` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `carregamento_id` INT NOT NULL ,
  `pedido_venda_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_carregamento_itens_carregamentos1` (`carregamento_id` ASC) ,
  INDEX `fk_carregamento_itens_pedido_vendas1` (`pedido_venda_id` ASC) ,
  CONSTRAINT `fk_carregamento_itens_carregamentos1`
    FOREIGN KEY (`carregamento_id` )
    REFERENCES `liber`.`carregamentos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_carregamento_itens_pedido_vendas1`
    FOREIGN KEY (`pedido_venda_id` )
    REFERENCES `liber`.`pedido_vendas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`pedido_venda_itens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`pedido_venda_itens` ;

CREATE  TABLE IF NOT EXISTS `liber`.`pedido_venda_itens` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `pedido_venda_id` INT NOT NULL ,
  `produto_id` INT NOT NULL ,
  `quantidade` INT(5) NOT NULL ,
  `preco_venda` FLOAT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pedido_venda_itens_pedido_vendas1` (`pedido_venda_id` ASC) ,
  INDEX `fk_pedido_venda_itens_produtos1` (`produto_id` ASC) ,
  CONSTRAINT `fk_pedido_venda_itens_pedido_vendas1`
    FOREIGN KEY (`pedido_venda_id` )
    REFERENCES `liber`.`pedido_vendas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_venda_itens_produtos1`
    FOREIGN KEY (`produto_id` )
    REFERENCES `liber`.`produtos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `liber`.`forma_pagamento_itens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `liber`.`forma_pagamento_itens` ;

CREATE  TABLE IF NOT EXISTS `liber`.`forma_pagamento_itens` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `forma_pagamento_id` INT NOT NULL ,
  `dias_intervalo_parcela` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_forma_pagamento_itens_forma_pagamentos1` (`forma_pagamento_id` ASC) ,
  CONSTRAINT `fk_forma_pagamento_itens_forma_pagamentos1`
    FOREIGN KEY (`forma_pagamento_id` )
    REFERENCES `liber`.`forma_pagamentos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `liber`.`usuarios`
-- -----------------------------------------------------
START TRANSACTION;
USE `liber`;
INSERT INTO `liber`.`usuarios` (`id`, `nome`, `login`, `senha`, `tipo`, `ativo`, `email`, `tempo_criado`, `ultimo_login`, `ultimo_logout`, `eh_tecnico`, `eh_vendedor`) VALUES (1, 'Liber administrador', 'liber', 'beb7c234ae8addda5ccff27ee0106a83deb7ce91', 0, 1, 'gnu@liber.localhost', '2011-06-28 23:34:00', '', '', 0, 0);

COMMIT;

-- -----------------------------------------------------
-- Data for table `liber`.`cliente_categorias`
-- -----------------------------------------------------
START TRANSACTION;
USE `liber`;
INSERT INTO `liber`.`cliente_categorias` (`id`, `descricao`) VALUES (1, 'Padrão');

COMMIT;

-- -----------------------------------------------------
-- Data for table `liber`.`fornecedor_categorias`
-- -----------------------------------------------------
START TRANSACTION;
USE `liber`;
INSERT INTO `liber`.`fornecedor_categorias` (`id`, `descricao`) VALUES (1, 'Padrão');

COMMIT;

-- -----------------------------------------------------
-- Data for table `liber`.`plano_contas`
-- -----------------------------------------------------
START TRANSACTION;
USE `liber`;
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (1, 'Assinaturas', 'R');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (2, 'Contas mensais', 'D');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Despesas gerais', 'D');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Imobilizado', 'D');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Impostos e taxas', 'D');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Investimentos', 'D');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Material de escritório', 'D');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Outros', 'E');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Pagamento fornecedor', 'D');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Receita serviço', 'R');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Receita venda', 'R');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Receita venda (cupom fiscal)', 'R');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Receitas gerais', 'R');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Retorno de empréstimos', 'R');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Retorno de investimentos', 'R');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Transferência entre contas', 'E');
INSERT INTO `liber`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Vales e empréstimos', 'D');

COMMIT;

-- -----------------------------------------------------
-- Data for table `liber`.`contas`
-- -----------------------------------------------------
START TRANSACTION;
USE `liber`;
INSERT INTO `liber`.`contas` (`id`, `nome`, `apelido`, `banco`, `agencia`, `conta`, `titular`) VALUES (1, 'Caixa interno da empresa', 'Caixa interno', NULL, NULL, NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `liber`.`tipo_documentos`
-- -----------------------------------------------------
START TRANSACTION;
USE `liber`;
INSERT INTO `liber`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Dinheiro');
INSERT INTO `liber`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Cheque');
INSERT INTO `liber`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Boleto');
INSERT INTO `liber`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Cartão de crédito');
INSERT INTO `liber`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Cartão de débito');
INSERT INTO `liber`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Duplicata');
INSERT INTO `liber`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Carnê');
INSERT INTO `liber`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Transferência eletrônica');
INSERT INTO `liber`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Sem documento');

COMMIT;

-- -----------------------------------------------------
-- Data for table `liber`.`categoria_produtos`
-- -----------------------------------------------------
START TRANSACTION;
USE `liber`;
INSERT INTO `liber`.`categoria_produtos` (`id`, `nome`) VALUES (1, 'Padrão');

COMMIT;
