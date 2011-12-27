<?php

/**
 * contas a receber
 *
 * @author tobias
 */
class ContasReceberComponent {
	/**
	 * Gera conta a receber
	 * Executar depois de se ter os dados prontos para serem inseridos no banco
	 * 
	 * @param $valor_total da conta a receber
	 * @param $dados (array) conteudo de $this->data['Modelo'] mais $dados['numero_documento'] e $dados['valor_total']
	 * 
	 * @return false em caso de erros de validação. Seta mensagem no flash
	 * @return null em casos de argumentos faltantes. Não seta mensagem no flash
	 * @return true em caso de sucesso. Seta mensagem no flash
	 * @return Dados já são inseridos no banco
	 */
	function gerarContaReceber ($dados=array()) {
		if (empty($dados)) return null;
		$padrao = array (
			'plano_conta_id' => 11,
		);
		
		$dados = array_merge($padrao,$dados);
		
		$valor_liquido = $dados['valor_total'];
		
		$FormaPagamento = ClassRegistry::init('FormaPagamento'); // carrega model
		$forma_pagamento = $FormaPagamento->find('all',array('conditions'=>array('FormaPagamento.id' => $dados['forma_pagamento_id']),'recursive'=>'-1') );
		if (empty($forma_pagamento)) {
			$this->Session->setFlash('Forma de pagamento não encontrada!','flash_erro');
			return false;
		}
		$forma_pagamento = $forma_pagamento[0]['FormaPagamento'];

		// se a forma de pagamento for 'A vista'
		if ($forma_pagamento['numero_maximo_parcelas'] == 0) {
			if ( $forma_pagamento['porcentagem_desconto_a_vista'] > 0) {
				//aplico desconto a vista
				$valor_a_receber = $valor_liquido - (($valor_liquido * $forma_pagamento['porcentagem_desconto_a_vista'])/100);
			}
			else $valor_a_receber = $valor_liquido;

			$conta_receber = array(
				'ReceberConta' => array(
					'data_hora_cadastrada' => date('Y-m-d H:i:s'),
					'eh_fiscal' => 0, //#TODO mudar quando houver nota fiscal e/ou uma abrangencia fiscal maior
					'eh_cliente_ou_fornecedor' => 'C',
					'cliente_fornecedor_id' => $dados['cliente_id'],
					'tipo_documento_id' => $forma_pagamento['tipo_documento_id'],
					'numero_documento' => $dados['numero_documento'],
					'valor' => $valor_a_receber,
					'conta_origem' => $forma_pagamento['conta_principal'],
					'plano_conta_id' => $dados['plano_conta_id'],
					'data_vencimento' => date("Y-m-d"),
					'situacao' => 'N',
					'empresa_id' => $dados['empresa_id'],
				),
			);
		}
		else { // a forma de pagamento tem uma ou mais parcelas
			$numero_parcelas = $dados['numero_parcelas'];
			if ($numero_parcelas > $forma_pagamento['numero_maximo_parcelas']) {
				$this->Session->setFlash('Número de parcelas escolhido ultrapassa o máximo permitido!','flash_erro');
				return false;
			}

			// a forma de pagamento nao tem um valor minimo por parcela
			if ($forma_pagamento['valor_minimo_parcela'] <= 0) {
				// crio um array contendo as parcelas
				$valor_a_receber = array();
				for ($j=1;$j<=$numero_parcelas;$j++) {
					$valor_a_receber[$j] = $valor_liquido / $numero_parcelas;
					$valor_a_receber[$j] = number_format($valor_a_receber[$j],2,'.','');
				}

				// se o valor de todas as parcelas somadas for menor que o valor da compra
				// acrescento a diferença na ultima parcela
				// até este momento todos os elementos do array $valor_a_receber sao iguais
				$diferenca = ($valor_liquido - ($valor_a_receber[1]*$numero_parcelas) );
				if ( $diferenca > 0 ) {
					$valor_a_receber[$numero_parcelas-1] += $diferenca;
				}
				else if ($diferenca < 0) {
					//#TODO  o somatorio das parcelas é maior que o valor liquido. Fazer algo?
				}
			}
			else { // a forma de pagamento tem um valor mínimo para cada parcela
				// crio um array contendo as parcelas
				$valor_a_receber = array();
				for ($j=1;$j<=$numero_parcelas;$j++) {
					$valor_a_receber[$j] = $valor_liquido / $numero_parcelas;
					if ($valor_a_receber[$j] < $forma_pagamento['valor_minimo_parcela']) {
						$valor_a_receber[$j] = $forma_pagamento['valor_minimo_parcela'];
					}
					$valor_a_receber[$j] = number_format($valor_a_receber[$j],2,'.','');
				}
				// se o valor de todas as parcelas somadas for menor que o valor da compra
				// acrescento a diferença na ultima parcela
				$s = 0;
				foreach ($valor_a_receber as $v) {
					$s += $v;
				}
				$diferenca = ($valor_liquido - $s );
				if ( $diferenca > 0 ) {
					$valor_a_receber[$numero_parcelas-1] += $diferenca;
				}
				else if ($diferenca < 0) {
					// este é bem provavel que dê mais
					//#TODO  o somatorio das parcelas é maior que o valor liquido. Fazer algo?
				}

			}

			$conta_receber = array(
				'ReceberConta' => array(
					//0 => array(),
				),
			);
			// para cada parcela
			for ($i = 1; $i <= $numero_parcelas; $i++) {
				if ( ($i > $forma_pagamento['numero_parcelas_sem_juros']) && ($forma_pagamento['porcentagem_juros'] > 0) ) {
					// aplicar juros
					$juros = (($valor_a_receber[$i]*number_format($forma_pagamento['porcentagem_juros'],2,'.','')) / 100);
					$valor_a_receber[$i] += $juros;
					$valor_a_receber[$i] = number_format($valor_a_receber[$i],2,'.','');
				}

				$conta =  array(
					($i) => array(
						'data_hora_cadastrada' => date('Y-m-d H:i:s'),
						'eh_fiscal' => 0, //#TODO mudar quando houver nota fiscal e/ou uma abrangencia fiscal maior
						'eh_cliente_ou_fornecedor' => 'C',
						'cliente_fornecedor_id' => $dados['cliente_id'],
						'tipo_documento_id' => $forma_pagamento['tipo_documento_id'],
						'numero_documento' => $dados['numero_documento'],
						'valor' => $valor_a_receber[$i],
						'conta_origem' => $forma_pagamento['conta_principal'],
						'plano_conta_id' => $dados['plano_conta_id'],
						'data_vencimento' => date("Y-m-d",time()+3600*24*($forma_pagamento['dias_intervalo_parcelamento'])),
						'situacao' => 'N',
						'empresa_id' => $dados['empresa_id'],
					),
				);
				$conta_receber['ReceberConta'] = array_merge($conta_receber['ReceberConta'],$conta);
			}
		}
		
		$ReceberConta = ClassRegistry::init('ReceberConta'); // carrega model
		if (! ($ReceberConta->saveAll($conta_receber['ReceberConta']))) {
			$this->Session->setFlash('Erro ao cadastrar o pedido de venda/conta a receber.','flash_erro');
			return false;
		}
		return 1;
		
	}
	
	
}

?>
