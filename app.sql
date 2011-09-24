SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `gfreedom` ;
CREATE SCHEMA IF NOT EXISTS `gfreedom` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `gfreedom` ;

-- -----------------------------------------------------
-- Table `gfreedom`.`usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`usuarios` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`usuarios` (
  `id` INT(5) NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  `login` VARCHAR(50) NOT NULL ,
  `senha` CHAR(40) NOT NULL ,
  `permissao` INT(2) NOT NULL ,
  `ativo` TINYINT(1)  NOT NULL DEFAULT 1 ,
  `email` VARCHAR(100) NULL ,
  `tempo_criado` DATETIME NOT NULL ,
  `ultimo_login` DATETIME NULL ,
  `ultimo_logout` DATETIME NULL ,
  `eh_tecnico` TINYINT(1)  NOT NULL DEFAULT 0 ,
  `eh_vendedor` TINYINT(1)  NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `usuario_UNIQUE` (`login` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `gfreedom`.`empresas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`empresas` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`empresas` (
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
-- Table `gfreedom`.`cliente_categorias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`cliente_categorias` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`cliente_categorias` (
  `id` INT(5) NOT NULL AUTO_INCREMENT ,
  `descricao` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`clientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`clientes` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`clientes` (
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
    REFERENCES `gfreedom`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clientes_usuarios2`
    FOREIGN KEY (`usuario_alterou` )
    REFERENCES `gfreedom`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clientes_empresas1`
    FOREIGN KEY (`empresa_id` )
    REFERENCES `gfreedom`.`empresas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clientes_cliente_categorias1`
    FOREIGN KEY (`cliente_categoria_id` )
    REFERENCES `gfreedom`.`cliente_categorias` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`fornecedor_categorias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`fornecedor_categorias` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`fornecedor_categorias` (
  `id` INT(5) NOT NULL AUTO_INCREMENT ,
  `descricao` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`fornecedores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`fornecedores` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`fornecedores` (
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
    REFERENCES `gfreedom`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fornecedores_usuarios2`
    FOREIGN KEY (`usuario_alterou` )
    REFERENCES `gfreedom`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fornecedores_empresas1`
    FOREIGN KEY (`empresa_id` )
    REFERENCES `gfreedom`.`empresas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fornecedores_fornecedor_categorias1`
    FOREIGN KEY (`fornecedor_categoria_id` )
    REFERENCES `gfreedom`.`fornecedor_categorias` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`plano_contas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`plano_contas` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`plano_contas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  `tipo` CHAR(1) NOT NULL COMMENT 'Tipo:\nD=Despesas\nR=Receitas\nE=Especiais' ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`contas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`contas` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`contas` (
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
-- Table `gfreedom`.`forma_pagamentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`forma_pagamentos` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`forma_pagamentos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  `numero_maximo_parcelas` INT(2) NOT NULL ,
  `numero_parcelas_sem_juros` INT(2) NOT NULL ,
  `dias_intervalo_parcelamento` INT(2) NOT NULL ,
  `porcentagem_juros` FLOAT(5) NOT NULL DEFAULT 0 ,
  `valor_taxa_fixa` FLOAT(5) NOT NULL ,
  `porcentagem_desconto_a_vista` FLOAT(5) NOT NULL ,
  `conta_principal` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_forma_pagamentos_contas1` (`conta_principal` ASC) ,
  CONSTRAINT `fk_forma_pagamentos_contas1`
    FOREIGN KEY (`conta_principal` )
    REFERENCES `gfreedom`.`contas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`categoria_produtos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`categoria_produtos` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`categoria_produtos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`produtos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`produtos` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`produtos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  `categoria_produto_id` INT NOT NULL ,
  `tipo_produto` CHAR(1) NOT NULL COMMENT 'Tipo_produto:\nPara venda\nMatéria-prima\nMatéria-prima e venda\nProduto composto' ,
  `codigo_ean` VARCHAR(45) NULL ,
  `codigo_dun` VARCHAR(45) NULL ,
  `preco_custo` FLOAT NULL ,
  `preco_venda` FLOAT NULL ,
  `margem_lucro` FLOAT NULL ,
  `tem_estoque_ilimitado` TINYINT(1)  NOT NULL DEFAULT 0 ,
  `estoque_minimo` INT(10) NULL ,
  `unidade` VARCHAR(45) NULL ,
  `quantidade_estoque_fiscal` INT(5) NOT NULL ,
  `quantidade_estoque_nao_fiscal` INT(5) NOT NULL ,
  `situacao` CHAR(1) NOT NULL DEFAULT 'L' COMMENT 'L = Em linha\nF = Fora de linha' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_produtos_categoria_produtos1` (`categoria_produto_id` ASC) ,
  CONSTRAINT `fk_produtos_categoria_produtos1`
    FOREIGN KEY (`categoria_produto_id` )
    REFERENCES `gfreedom`.`categoria_produtos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`tipo_documentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`tipo_documentos` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`tipo_documentos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`pagar_contas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`pagar_contas` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`pagar_contas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data_hora_cadastrada` DATETIME NOT NULL ,
  `eh_fiscal` TINYINT(1)  NOT NULL ,
  `eh_cliente_ou_fornecedor` CHAR(1) NOT NULL ,
  `cliente_fornecedor_id` INT(5) NOT NULL ,
  `tipo_documento_id` INT NOT NULL ,
  `numero_documento` VARCHAR(20) NULL ,
  `valor` FLOAT(5) NOT NULL ,
  `conta_origem` INT NOT NULL ,
  `plano_conta_id` INT NOT NULL ,
  `data_vencimento` DATE NOT NULL ,
  `observacao` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_contas_pagar_contas1` (`conta_origem` ASC) ,
  INDEX `fk_contas_pagar_plano_contas1` (`plano_conta_id` ASC) ,
  INDEX `fk_contas_pagar_tipo_documentos1` (`tipo_documento_id` ASC) ,
  CONSTRAINT `fk_contas_pagar_contas1`
    FOREIGN KEY (`conta_origem` )
    REFERENCES `gfreedom`.`contas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_pagar_plano_contas1`
    FOREIGN KEY (`plano_conta_id` )
    REFERENCES `gfreedom`.`plano_contas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_pagar_tipo_documentos1`
    FOREIGN KEY (`tipo_documento_id` )
    REFERENCES `gfreedom`.`tipo_documentos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`receber_contas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`receber_contas` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`receber_contas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data_hora_cadastrada` DATETIME NOT NULL ,
  `eh_fiscal` TINYINT(1)  NOT NULL ,
  `eh_cliente_ou_fornecedor` CHAR(1) NOT NULL ,
  `cliente_fornecedor_id` INT(5) NOT NULL ,
  `tipo_documento_id` INT NOT NULL ,
  `numero_documento` VARCHAR(20) NULL ,
  `valor` FLOAT(5) NOT NULL ,
  `conta_origem` INT NOT NULL ,
  `plano_conta_id` INT NOT NULL ,
  `data_vencimento` DATE NOT NULL ,
  `observacao` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_contas_pagar_contas1` (`conta_origem` ASC) ,
  INDEX `fk_contas_pagar_plano_contas1` (`plano_conta_id` ASC) ,
  INDEX `fk_contas_pagar_tipo_documentos1` (`tipo_documento_id` ASC) ,
  CONSTRAINT `fk_contas_pagar_contas10`
    FOREIGN KEY (`conta_origem` )
    REFERENCES `gfreedom`.`contas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_pagar_plano_contas10`
    FOREIGN KEY (`plano_conta_id` )
    REFERENCES `gfreedom`.`plano_contas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_pagar_tipo_documentos10`
    FOREIGN KEY (`tipo_documento_id` )
    REFERENCES `gfreedom`.`tipo_documentos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`produto_estoque_logs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`produto_estoque_logs` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`produto_estoque_logs` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data_hora_registro` DATETIME NOT NULL ,
  `produto_id` INT NOT NULL ,
  `quantidade_estoque_fiscal` INT(5) NOT NULL ,
  `quantidade_estoque_nao_fiscal` INT(5) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_log_estoque_produtos_produtos1` (`produto_id` ASC) ,
  CONSTRAINT `fk_log_estoque_produtos_produtos1`
    FOREIGN KEY (`produto_id` )
    REFERENCES `gfreedom`.`produtos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`pedido_vendas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`pedido_vendas` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`pedido_vendas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data_hora_cadastrado` DATETIME NOT NULL ,
  `cliente_id` INT(5) NOT NULL ,
  `usuario_vendeu` INT(5) NOT NULL ,
  `forma_pagamento_id` INT NOT NULL ,
  `data_saida` DATE NULL ,
  `data_entrega` DATE NULL ,
  `data_venda` DATE NULL ,
  `custo_frete` FLOAT(5) NULL ,
  `custo_seguro` FLOAT(5) NULL ,
  `custo_outros` FLOAT(5) NULL ,
  `desconto` FLOAT(5) NULL ,
  `situacao` CHAR(1) NOT NULL COMMENT 'A = Aberto\nO = Orçamento\nC = Cancelado\nV = Vendido' ,
  `usuario_alterou` INT(5) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pedido_vendas_clientes1` (`cliente_id` ASC) ,
  INDEX `fk_pedido_vendas_usuarios1` (`usuario_vendeu` ASC) ,
  INDEX `fk_pedido_vendas_forma_pagamentos1` (`forma_pagamento_id` ASC) ,
  INDEX `fk_pedido_vendas_usuarios2` (`usuario_alterou` ASC) ,
  CONSTRAINT `fk_pedido_vendas_clientes1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `gfreedom`.`clientes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_vendas_usuarios1`
    FOREIGN KEY (`usuario_vendeu` )
    REFERENCES `gfreedom`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_vendas_forma_pagamentos1`
    FOREIGN KEY (`forma_pagamento_id` )
    REFERENCES `gfreedom`.`forma_pagamentos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_vendas_usuarios2`
    FOREIGN KEY (`usuario_alterou` )
    REFERENCES `gfreedom`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`pedido_venda_itens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`pedido_venda_itens` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`pedido_venda_itens` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `pedido_venda_id` INT NOT NULL ,
  `produto_id` INT NOT NULL ,
  `quantidade` INT(5) NOT NULL ,
  `valor` FLOAT(5) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pedido_vendas_itens_pedido_vendas1` (`pedido_venda_id` ASC) ,
  INDEX `fk_pedido_vendas_itens_produtos1` (`produto_id` ASC) ,
  CONSTRAINT `fk_pedido_vendas_itens_pedido_vendas1`
    FOREIGN KEY (`pedido_venda_id` )
    REFERENCES `gfreedom`.`pedido_vendas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_vendas_itens_produtos1`
    FOREIGN KEY (`produto_id` )
    REFERENCES `gfreedom`.`produtos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`servico_ordens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`servico_ordens` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`servico_ordens` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data_hora_cadastrada` DATETIME NOT NULL ,
  `cliente_id` INT(5) NOT NULL ,
  `usuario_id` INT(5) NOT NULL ,
  `forma_pagamento_id` INT NOT NULL ,
  `situacao` CHAR(1) NOT NULL COMMENT 'O = Orçamento\nE = Em espera\nX = Em execução\nF = Finalizada\nE = Entregue\nC = Cancelada' ,
  `dias_garantia` INT(3) NULL ,
  `data_hora_inicio` DATETIME NOT NULL ,
  `data_hora_fim` DATETIME NULL ,
  `defeitos_relatados` TEXT NULL ,
  `laudo_tecnico` TEXT NULL ,
  `observacao` TEXT NULL ,
  `usuario_alterou` INT(5) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_servico_ordens_clientes1` (`cliente_id` ASC) ,
  INDEX `fk_servico_ordens_usuarios1` (`usuario_id` ASC) ,
  INDEX `fk_servico_ordens_forma_pagamentos1` (`forma_pagamento_id` ASC) ,
  INDEX `fk_servico_ordens_usuarios2` (`usuario_alterou` ASC) ,
  CONSTRAINT `fk_servico_ordens_clientes1`
    FOREIGN KEY (`cliente_id` )
    REFERENCES `gfreedom`.`clientes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servico_ordens_usuarios1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `gfreedom`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servico_ordens_forma_pagamentos1`
    FOREIGN KEY (`forma_pagamento_id` )
    REFERENCES `gfreedom`.`forma_pagamentos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servico_ordens_usuarios2`
    FOREIGN KEY (`usuario_alterou` )
    REFERENCES `gfreedom`.`usuarios` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`servico_categorias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`servico_categorias` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`servico_categorias` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`servicos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`servicos` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`servicos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  `servico_categoria_id` INT NOT NULL ,
  `valor` FLOAT(5) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_servico_tipos_servico_categorias1` (`servico_categoria_id` ASC) ,
  CONSTRAINT `fk_servico_tipos_servico_categorias1`
    FOREIGN KEY (`servico_categoria_id` )
    REFERENCES `gfreedom`.`servico_categorias` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gfreedom`.`servico_ordem_itens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gfreedom`.`servico_ordem_itens` ;

CREATE  TABLE IF NOT EXISTS `gfreedom`.`servico_ordem_itens` (
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
    REFERENCES `gfreedom`.`servicos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servico_ordem_itens_servico_ordens1`
    FOREIGN KEY (`servico_ordem_id` )
    REFERENCES `gfreedom`.`servico_ordens` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `gfreedom`.`usuarios`
-- -----------------------------------------------------
START TRANSACTION;
USE `gfreedom`;
INSERT INTO `gfreedom`.`usuarios` (`id`, `nome`, `login`, `senha`, `permissao`, `ativo`, `email`, `tempo_criado`, `ultimo_login`, `ultimo_logout`, `eh_tecnico`, `eh_vendedor`) VALUES (1, 'Administrador', 'gnu', 'beb7c234ae8addda5ccff27ee0106a83deb7ce91', 0, 1, 'tobias@gnu.eti.br', '2011-06-28 23:34:00', '', '', NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `gfreedom`.`cliente_categorias`
-- -----------------------------------------------------
START TRANSACTION;
USE `gfreedom`;
INSERT INTO `gfreedom`.`cliente_categorias` (`id`, `descricao`) VALUES (1, 'Padrão');

COMMIT;

-- -----------------------------------------------------
-- Data for table `gfreedom`.`fornecedor_categorias`
-- -----------------------------------------------------
START TRANSACTION;
USE `gfreedom`;
INSERT INTO `gfreedom`.`fornecedor_categorias` (`id`, `descricao`) VALUES (1, 'Padrão');

COMMIT;

-- -----------------------------------------------------
-- Data for table `gfreedom`.`plano_contas`
-- -----------------------------------------------------
START TRANSACTION;
USE `gfreedom`;
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (1, 'Assinaturas', 'R');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (2, 'Contas mensais', 'D');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Despesas gerais', 'D');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Imobilizado', 'D');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Impostos e taxas', 'D');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Investimentos', 'D');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Material de escritório', 'D');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Outros', 'E');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Pagamento fornecedor', 'D');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Receita serviço', 'R');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Receita venda', 'R');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Receita venda (cupom fiscal)', 'R');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Receitas gerais', 'R');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Retorno de empréstimos', 'R');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Retorno de investimentos', 'R');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Transferência entre contas', 'E');
INSERT INTO `gfreedom`.`plano_contas` (`id`, `nome`, `tipo`) VALUES (NULL, 'Vales e empréstimos', 'D');

COMMIT;

-- -----------------------------------------------------
-- Data for table `gfreedom`.`contas`
-- -----------------------------------------------------
START TRANSACTION;
USE `gfreedom`;
INSERT INTO `gfreedom`.`contas` (`id`, `nome`, `apelido`, `banco`, `agencia`, `conta`, `titular`) VALUES (1, 'Caixa interno da empresa', 'Caixa interno', NULL, NULL, NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `gfreedom`.`categoria_produtos`
-- -----------------------------------------------------
START TRANSACTION;
USE `gfreedom`;
INSERT INTO `gfreedom`.`categoria_produtos` (`id`, `nome`) VALUES (1, 'Padrão');

COMMIT;

-- -----------------------------------------------------
-- Data for table `gfreedom`.`tipo_documentos`
-- -----------------------------------------------------
START TRANSACTION;
USE `gfreedom`;
INSERT INTO `gfreedom`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Dinheiro');
INSERT INTO `gfreedom`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Cheque');
INSERT INTO `gfreedom`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Boleto');
INSERT INTO `gfreedom`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Cartão de crédito');
INSERT INTO `gfreedom`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Cartão de débito');
INSERT INTO `gfreedom`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Duplicata');
INSERT INTO `gfreedom`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Carnê');
INSERT INTO `gfreedom`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Transferência eletrônica');
INSERT INTO `gfreedom`.`tipo_documentos` (`id`, `nome`) VALUES (NULL, 'Sem documento');

COMMIT;
