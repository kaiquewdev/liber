<?php

/**
 * Componente para executar funcoes relacionadas as 'Contas a receber'
 *
 * @author tobias
 */
class ContasReceberComponent {
	
	/**
	 * Gera conta a receber
	 * Executar depois de se ter os dados prontos para serem inseridos no banco
	 * 
	 * @param $dados (array) conteudo de $this->data['Modelo'] mais $dados['numero_documento'] e $dados['valor_total'], este ultimo em formato americano
	 * 
	 * @return false em caso de erros de validação. Seta mensagem no flash
	 * @return null em casos de argumentos faltantes. Não seta mensagem no flash
	 * @return true em caso de sucesso. Não seta mensagem no flash
	 * @return Dados já são inseridos no banco
	 */
	function gerarContaReceber ($dados=array()) {
		if (empty($dados)) return null;
		$padrao = array (
			'plano_conta_id' => 11,
		);
		
		$dados = array_merge($padrao,$dados);
		
		$valor_liquido = abs($dados['valor_total']);
		
		$FormaPagamento = ClassRegistry::init('FormaPagamento'); // carrega model
		$FormaPagamentoItem = ClassRegistry::init('FormaPagamentoItem');
		$forma_pagamento = $FormaPagamento->find('all',array('conditions'=>array('FormaPagamento.id' => $dados['forma_pagamento_id']),'recursive'=>'-1') );
		if (empty($forma_pagamento)) {
			$this->Session->setFlash('Forma de pagamento não encontrada!','flash_erro');
			return false;
		}
		$forma_pagamento = $forma_pagamento[0]['FormaPagamento'];
		// sao duas consultas pois a primeira estava retonando resultados desnecessarios
		$forma_pagamento_itens = $FormaPagamentoItem->find('all',array('conditions'=>array('FormaPagamentoItem.forma_pagamento_id' => $dados['forma_pagamento_id']),'recursive'=>'-1') );
		
		$numero_parcelas = count($forma_pagamento_itens);
		$valor_a_receber = $valor_liquido / $numero_parcelas;
		$valor_a_receber = number_format($valor_a_receber,2,'.','');
		if ($valor_a_receber <= 0) {
			$this->Session->setFlash('Valor da conta a receber é muito baixo!','flash_erro');
			return false;
		}
		$conta_receber['ReceberConta'] = array();
		$i = 0;
		// para cada parcela
		foreach ($forma_pagamento_itens as $parcela) {
			$parcela = $parcela['FormaPagamentoItem'];
			$conta =  array (
					($i) => array (
						'data_hora_cadastrada' => date('Y-m-d H:i:s'),
						'eh_fiscal' => 0, //#TODO mudar quando houver nota fiscal e/ou uma abrangencia fiscal maior
						'eh_cliente_ou_fornecedor' => 'C',
						'cliente_fornecedor_id' => $dados['cliente_id'],
						'tipo_documento_id' => $forma_pagamento['tipo_documento_id'],
						'numero_documento' => $dados['numero_documento'],
						'valor' => $valor_a_receber,
						'conta_origem' => $forma_pagamento['conta_principal'],
						'plano_conta_id' => $dados['plano_conta_id'],
						'data_vencimento' => date("Y-m-d",time()+3600*24*($parcela['dias_intervalo_parcela'])),
						'situacao' => 'N',
						'empresa_id' => $dados['empresa_id'],
					),
				);
				$conta_receber['ReceberConta'] = array_merge($conta_receber['ReceberConta'],$conta);
				$i++;
		}
		
		$ReceberConta = ClassRegistry::init('ReceberConta'); // carrega model
		if (! ($ReceberConta->saveAll($conta_receber['ReceberConta']))) {
			$this->Session->setFlash('Erro ao gerar a conta a receber.','flash_erro');
			return false;
		}
		
		return true;
		
	}
	
	
}

?>
