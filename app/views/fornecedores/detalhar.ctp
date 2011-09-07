<?php if (! isset($cliente) || ! $cliente) die; ?>

<h2 class="descricao_cabecalho">Visualizar fornecedor</h2>

Nome: <h1><?php print $cliente['Fornecedor']['nome'] ?></h1>
Nome fantasia: <h1><?php  print $cliente['Fornecedor']['nome_fantasia'];?></h1>
Tipo pessoa: <?php
					if ( $cliente['Fornecedor']['tipo_pessoa'] == 'J'):
						print '<h1>Jurídica</h1>';
					elseif ( $cliente['Fornecedor']['tipo_pessoa'] == 'F' ):
						print '<h1>Física</h1>';
					endif;
				?>
<p>
	<small>Criado em: <?php print '<h1>'.$cliente['Fornecedor']['data_cadastrado'].'</h1>'; ?></small>
</p>
<p>
	<small>Atualizado em: <?php print '<h1>'.$cliente['Fornecedor']['atualizado'].'</h1>'; ?></small>
</p>

<table>
	<thead>
		<tr>
			<th>Nome</th>
			<th>Log. nome</th>
			<th>Log. número</th>
			<th>Log. complemento</th>
			<th>Bairro</th>
			<th>Cidade</th>
			<th>UF</th>
			<th>CEP</th>
			<?php if ( $cliente['Fornecedor']['tipo_pessoa'] = 'J'): ?>
				<th>CNPJ</th>
				<th>IE.</th>
			<?php else: ?>
				<th>CPF</th>
				<th>RG</th>
			<?php endif; ?>
			<th>Telefone</th>
			<th>Celular</th>
			<th>E-mail</th>
		</tr>
	</thead>
	
	<tbody>
		<tr>
			<td><?php  print $cliente['Fornecedor']['nome'];?></td>
			<td><?php  print $cliente['Fornecedor']['logradouro_nome'];?></td>
			<td><?php  print $cliente['Fornecedor']['logradouro_numero'];?></td>
			<td><?php  print $cliente['Fornecedor']['logradouro_complemento'];?></td>
			<td><?php  print $cliente['Fornecedor']['bairro'];?></td>
			<td><?php  print $cliente['Fornecedor']['cidade'];?></td>
			<td><?php  print $cliente['Fornecedor']['uf'];?></td>
			<td><?php  print $cliente['Fornecedor']['cep'];?></td>
			<?php if ( $cliente['Fornecedor']['tipo_pessoa'] = 'J'): ?>
				<td><?php  print $cliente['Fornecedor']['cnpj'];?></td>
				<td><?php  print $cliente['Fornecedor']['inscricao_estadual'];?></td>
			<?php else: ?>
				<td><?php  print $cliente['Fornecedor']['cpf'];?></td>
				<td><?php  print $cliente['Fornecedor']['rg'];?></td>
			<?php endif; ?>
			<td><?php  print $cliente['Fornecedor']['numero_telefone'];?></td>
			<td><?php  print $cliente['Fornecedor']['numero_celular'];?></td>
			<td><?php  print $cliente['Fornecedor']['endereco_email'];?></td>
		</tr>
	</tbody>
	
</table>

Observação: <textarea rows="5" readonly="readonly"><?php  print $cliente['Fornecedor']['observacao'];?></textarea>
