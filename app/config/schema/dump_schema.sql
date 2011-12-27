#App sql generated on: 2011-12-15 17:23:39 : 1323977019

DROP TABLE IF EXISTS `carregamento_itens`;
DROP TABLE IF EXISTS `carregamentos`;
DROP TABLE IF EXISTS `categoria_produtos`;
DROP TABLE IF EXISTS `cliente_categorias`;
DROP TABLE IF EXISTS `clientes`;
DROP TABLE IF EXISTS `contas`;
DROP TABLE IF EXISTS `empresas`;
DROP TABLE IF EXISTS `forma_pagamentos`;
DROP TABLE IF EXISTS `fornecedor_categorias`;
DROP TABLE IF EXISTS `fornecedores`;
DROP TABLE IF EXISTS `motoristas`;
DROP TABLE IF EXISTS `pagar_contas`;
DROP TABLE IF EXISTS `pedido_venda_itens`;
DROP TABLE IF EXISTS `pedido_vendas`;
DROP TABLE IF EXISTS `plano_contas`;
DROP TABLE IF EXISTS `produtos`;
DROP TABLE IF EXISTS `receber_contas`;
DROP TABLE IF EXISTS `servico_categorias`;
DROP TABLE IF EXISTS `servico_ordem_itens`;
DROP TABLE IF EXISTS `servico_ordens`;
DROP TABLE IF EXISTS `servicos`;
DROP TABLE IF EXISTS `tipo_documentos`;
DROP TABLE IF EXISTS `usuarios`;
DROP TABLE IF EXISTS `veiculos`;


CREATE TABLE `carregamento_itens` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`carregamento_id` int(11) NOT NULL,
	`pedido_venda_id` int(11) NOT NULL,	PRIMARY KEY  (`id`),
	KEY `fk_carregamento_itens_carregamentos1` (`carregamento_id`),
	KEY `fk_carregamento_itens_pedido_vendas1` (`pedido_venda_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `carregamentos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`data_hora_criado` datetime NOT NULL,
	`situacao` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Situacao\nL = Livre\nE = Enviada',
	`descricao` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`motorista_id` int(11) NOT NULL,
	`veiculo_id` int(11) NOT NULL,
	`observacao` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `fk_carregamentos_motoristas1` (`motorista_id`),
	KEY `fk_carregamentos_veiculos1` (`veiculo_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `categoria_produtos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `cliente_categorias` (
	`id` int(5) NOT NULL AUTO_INCREMENT,
	`descricao` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `clientes` (
	`id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Situacao:\nA -> Ativo\nI -> Inativo\nB -> Bloqueado',
	`data_cadastrado` datetime NOT NULL,
	`tipo_pessoa` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`nome_fantasia` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`logradouro_nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`logradouro_numero` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`logradouro_complemento` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`bairro` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`cidade` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`uf` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`cep` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`cnpj` varchar(14) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`inscricao_estadual` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`cpf` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`rg` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`inscricao_municipal` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`numero_telefone` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`numero_celular` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`endereco_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`observacao` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`situacao` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`cliente_categoria_id` int(5) NOT NULL,
	`empresa_id` int(5) NOT NULL,
	`atualizado` timestamp DEFAULT CURRENT_TIMESTAMP,
	`usuario_cadastrou` int(5) NOT NULL,
	`usuario_alterou` int(5) DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `fk_clientes_usuarios1` (`usuario_cadastrou`),
	KEY `fk_clientes_usuarios2` (`usuario_alterou`),
	KEY `fk_clientes_empresas1` (`empresa_id`),
	KEY `fk_clientes_cliente_categorias1` (`cliente_categoria_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `contas` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`apelido` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`banco` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`agencia` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`conta` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`titular` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `empresas` (
	`id` int(5) NOT NULL AUTO_INCREMENT,
	`nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`cnpj` varchar(14) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`inscricao_estadual` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`telefone` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`fax` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`site` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`endereco_email_principal` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`endereco_email_secundario` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`logradouro` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`numero` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`bairro` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`complemento` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`cidade` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`estado` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `forma_pagamentos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`nome` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`numero_maximo_parcelas` int(2) NOT NULL,
	`numero_parcelas_sem_juros` int(2) NOT NULL,
	`dias_intervalo_parcelamento` int(2) NOT NULL,
	`porcentagem_juros` float DEFAULT 0 NOT NULL,
	`valor_minimo_parcela` float NOT NULL,
	`porcentagem_desconto_a_vista` float NOT NULL,
	`conta_principal` int(11) NOT NULL,
	`tipo_documento_id` int(11) NOT NULL,	PRIMARY KEY  (`id`),
	KEY `fk_forma_pagamentos_contas1` (`conta_principal`),
	KEY `fk_forma_pagamentos_tipo_documentos1` (`tipo_documento_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `fornecedor_categorias` (
	`id` int(5) NOT NULL AUTO_INCREMENT,
	`descricao` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `fornecedores` (
	`id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Situacao:\nA -> Ativo\nI -> Inativo\nB -> Bloqueado',
	`data_cadastrado` datetime NOT NULL,
	`tipo_pessoa` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`nome_fantasia` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`logradouro_nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`logradouro_numero` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`logradouro_complemento` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`bairro` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`cidade` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`uf` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`cep` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`cnpj` varchar(14) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`inscricao_estadual` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`cpf` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`rg` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`inscricao_municipal` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`numero_telefone` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`numero_celular` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`endereco_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`observacao` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`situacao` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`fornecedor_categoria_id` int(5) NOT NULL,
	`empresa_id` int(5) NOT NULL,
	`atualizado` timestamp DEFAULT CURRENT_TIMESTAMP,
	`usuario_cadastrou` int(5) NOT NULL,
	`usuario_alterou` int(5) DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `fk_fornecedores_usuarios1` (`usuario_cadastrou`),
	KEY `fk_fornecedores_usuarios2` (`usuario_alterou`),
	KEY `fk_fornecedores_empresas1` (`empresa_id`),
	KEY `fk_fornecedores_fornecedor_categorias1` (`fornecedor_categoria_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `motoristas` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`cnh_numero_registro` int(11) DEFAULT NULL,
	`cnh_data_validade` date DEFAULT NULL,
	`cnh_categoria` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`logradouro_nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`logradouro_numero` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`logradouro_complemento` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`veiculo_padrao` int(11) DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `fk_motoristas_veiculos1` (`veiculo_padrao`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `pagar_contas` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`data_hora_cadastrada` datetime NOT NULL,
	`eh_fiscal` tinyint(1) NOT NULL,
	`eh_cliente_ou_fornecedor` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`cliente_fornecedor_id` int(5) NOT NULL,
	`tipo_documento_id` int(11) NOT NULL,
	`numero_documento` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`valor` float NOT NULL,
	`conta_origem` int(11) NOT NULL,
	`plano_conta_id` int(11) NOT NULL,
	`data_vencimento` date NOT NULL,
	`observacao` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`empresa_id` int(5) NOT NULL,
	`situacao` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P = Paga\nN = Não paga',	PRIMARY KEY  (`id`),
	KEY `fk_contas_pagar_contas1` (`conta_origem`),
	KEY `fk_contas_pagar_plano_contas1` (`plano_conta_id`),
	KEY `fk_contas_pagar_tipo_documentos1` (`tipo_documento_id`),
	KEY `fk_pagar_contas_empresas1` (`empresa_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `pedido_venda_itens` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`pedido_venda_id` int(11) NOT NULL,
	`produto_id` int(11) NOT NULL,
	`quantidade` int(5) NOT NULL,
	`preco_venda` float NOT NULL,	PRIMARY KEY  (`id`),
	KEY `fk_pedido_venda_itens_pedido_vendas1` (`pedido_venda_id`),
	KEY `fk_pedido_venda_itens_produtos1` (`produto_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `pedido_vendas` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`data_hora_cadastrado` datetime NOT NULL,
	`cliente_id` int(5) NOT NULL,
	`forma_pagamento_id` int(11) NOT NULL,
	`data_saida` date DEFAULT NULL,
	`data_entrega` date DEFAULT NULL,
	`data_venda` date DEFAULT NULL,
	`custo_frete` float DEFAULT NULL,
	`custo_seguro` float DEFAULT NULL,
	`custo_outros` float DEFAULT NULL,
	`desconto` float DEFAULT NULL,
	`situacao` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'A = Aberto\nO = Orçamento\nC = Cancelado\nV = Vendido',
	`observacao` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`usuario_cadastrou` int(5) NOT NULL,
	`valor_bruto` float NOT NULL,
	`valor_liquido` float NOT NULL,
	`usuario_alterou` int(5) DEFAULT NULL,
	`empresa_id` int(5) NOT NULL,	PRIMARY KEY  (`id`),
	KEY `fk_pedido_vendas_clientes1` (`cliente_id`),
	KEY `fk_pedido_vendas_forma_pagamentos1` (`forma_pagamento_id`),
	KEY `fk_pedido_vendas_usuarios2` (`usuario_alterou`),
	KEY `fk_pedido_vendas_usuarios3` (`usuario_cadastrou`),
	KEY `fk_pedido_vendas_empresas1` (`empresa_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `plano_contas` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`nome` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`tipo` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Tipo:\nD=Despesas\nR=Receitas\nE=Especiais',	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `produtos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`categoria_produto_id` int(11) NOT NULL,
	`tipo_produto` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Tipo_produto:\nPara venda\nMatéria-prima\nMatéria-prima e venda\nProduto composto',
	`codigo_ean` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`codigo_dun` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`preco_custo` float DEFAULT NULL,
	`preco_venda` float DEFAULT NULL,
	`margem_lucro` float DEFAULT NULL,
	`tem_estoque_ilimitado` tinyint(1) DEFAULT 0 NOT NULL,
	`estoque_minimo` int(10) DEFAULT NULL,
	`unidade` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`quantidade_estoque_fiscal` int(5) NOT NULL,
	`quantidade_estoque_nao_fiscal` int(5) NOT NULL,
	`situacao` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'L' NOT NULL COMMENT 'L = Em linha\nF = Fora de linha',	PRIMARY KEY  (`id`),
	KEY `fk_produtos_categoria_produtos1` (`categoria_produto_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `receber_contas` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`data_hora_cadastrada` datetime NOT NULL,
	`eh_fiscal` tinyint(1) NOT NULL,
	`eh_cliente_ou_fornecedor` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`cliente_fornecedor_id` int(5) NOT NULL,
	`tipo_documento_id` int(11) NOT NULL,
	`numero_documento` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`valor` float NOT NULL,
	`conta_origem` int(11) NOT NULL,
	`plano_conta_id` int(11) NOT NULL,
	`data_vencimento` date NOT NULL,
	`observacao` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`empresa_id` int(5) NOT NULL,
	`situacao` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'P = Paga\nN = Não paga',	PRIMARY KEY  (`id`),
	KEY `fk_contas_pagar_contas1` (`conta_origem`),
	KEY `fk_contas_pagar_plano_contas1` (`plano_conta_id`),
	KEY `fk_contas_pagar_tipo_documentos1` (`tipo_documento_id`),
	KEY `fk_receber_contas_empresas1` (`empresa_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `servico_categorias` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`nome` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `servico_ordem_itens` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`servico_ordem_id` int(11) NOT NULL,
	`servico_id` int(11) NOT NULL,
	`quantidade` int(5) NOT NULL,
	`valor` float NOT NULL,	PRIMARY KEY  (`id`),
	KEY `fk_servico_ordem_itens_servicos1` (`servico_id`),
	KEY `fk_servico_ordem_itens_servico_ordens1` (`servico_ordem_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `servico_ordens` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`data_hora_cadastrada` datetime NOT NULL,
	`cliente_id` int(5) NOT NULL,
	`usuario_id` int(5) NOT NULL,
	`forma_pagamento_id` int(11) NOT NULL,
	`situacao` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'O = Orçamento\nS = Em espera\nX = Em execução\nF = Finalizada\nE = Entregue\nC = Cancelada',
	`dias_garantia` int(3) DEFAULT NULL,
	`data_hora_inicio` datetime NOT NULL,
	`data_hora_fim` datetime DEFAULT NULL,
	`custo_outros` float DEFAULT NULL,
	`desconto` float DEFAULT NULL,
	`defeitos_relatados` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`laudo_tecnico` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`observacao` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`valor_bruto` float NOT NULL,
	`valor_liquido` float NOT NULL,
	`usuario_cadastrou` int(5) NOT NULL,
	`usuario_alterou` int(5) DEFAULT NULL,
	`empresa_id` int(5) NOT NULL,	PRIMARY KEY  (`id`),
	KEY `fk_servico_ordens_clientes1` (`cliente_id`),
	KEY `fk_servico_ordens_usuarios1` (`usuario_id`),
	KEY `fk_servico_ordens_forma_pagamentos1` (`forma_pagamento_id`),
	KEY `fk_servico_ordens_usuarios2` (`usuario_alterou`),
	KEY `fk_servico_ordens_usuarios3` (`usuario_cadastrou`),
	KEY `fk_servico_ordens_empresas1` (`empresa_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `servicos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`nome` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`servico_categoria_id` int(11) NOT NULL,
	`valor` float NOT NULL,	PRIMARY KEY  (`id`),
	KEY `fk_servico_tipos_servico_categorias1` (`servico_categoria_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `tipo_documentos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`nome` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `usuarios` (
	`id` int(5) NOT NULL AUTO_INCREMENT,
	`nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`login` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`senha` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`tipo` int(2) NOT NULL,
	`ativo` tinyint(1) DEFAULT 1 NOT NULL,
	`email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`tempo_criado` datetime NOT NULL,
	`ultimo_login` datetime DEFAULT NULL,
	`ultimo_logout` datetime DEFAULT NULL,
	`eh_tecnico` tinyint(1) DEFAULT 0 NOT NULL,
	`eh_vendedor` tinyint(1) DEFAULT 0 NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `usuario_UNIQUE` (`login`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `veiculos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`placa` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`fabricante` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`modelo` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`ano` text(4) DEFAULT NULL,	PRIMARY KEY  (`id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

