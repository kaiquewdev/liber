<?php if (! isset($fornecedor) || ! $fornecedor) die; ?>

<h2 class="descricao_cabecalho">Visualizar fornecedor</h2>

Nome: <h1><?php print $fornecedor['Fornecedor']['nome'] ?></h1>
Nome fantasia: <h1><?php  print $fornecedor['Fornecedor']['nome_fantasia'];?></h1>
Tipo pessoa: <?php
					if ( $fornecedor['Fornecedor']['tipo_pessoa'] == 'J'):
						print '<h1>Jurídica</h1>';
					elseif ( $fornecedor['Fornecedor']['tipo_pessoa'] == 'F' ):
						print '<h1>Física</h1>';
					endif;
				?>
<p>
	<small>
		Criado em: <?php print '<h1>'.$fornecedor['Fornecedor']['data_cadastrado'].'</h1>'; ?>
		por <?php print '<h1>'.$fornecedor['Usuario']['nome'].'</h1>'; ?>
	</small>
</p>
<p>
	<small>
		Atualizado em: <?php print '<h1>'.$fornecedor['Fornecedor']['atualizado'].'</h1>'; ?>
		por <?php print '<h1>'.$fornecedor['Usuario2']['nome'].'</h1>';?>
	</small>
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
			<?php if ( $fornecedor['Fornecedor']['tipo_pessoa'] = 'J'): ?>
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
			<td><?php  print $fornecedor['Fornecedor']['nome'];?></td>
			<td><?php  print $fornecedor['Fornecedor']['logradouro_nome'];?></td>
			<td><?php  print $fornecedor['Fornecedor']['logradouro_numero'];?></td>
			<td><?php  print $fornecedor['Fornecedor']['logradouro_complemento'];?></td>
			<td><?php  print $fornecedor['Fornecedor']['bairro'];?></td>
			<td><?php  print $fornecedor['Fornecedor']['cidade'];?></td>
			<td><?php  print $fornecedor['Fornecedor']['uf'];?></td>
			<td><?php  print $fornecedor['Fornecedor']['cep'];?></td>
			<?php if ( $fornecedor['Fornecedor']['tipo_pessoa'] == 'J'): ?>
				<td><?php  print $fornecedor['Fornecedor']['cnpj'];?></td>
				<td><?php  print $fornecedor['Fornecedor']['inscricao_estadual'];?></td>
			<?php else: ?>
				<td><?php  print $fornecedor['Fornecedor']['cpf'];?></td>
				<td><?php  print $fornecedor['Fornecedor']['rg'];?></td>
			<?php endif; ?>
			<td><?php  print $fornecedor['Fornecedor']['numero_telefone'];?></td>
			<td><?php  print $fornecedor['Fornecedor']['numero_celular'];?></td>
			<td><?php  print $fornecedor['Fornecedor']['endereco_email'];?></td>
		</tr>
	</tbody>
	
</table>

Observação: <textarea rows="5" readonly="readonly"><?php  print $fornecedor['Fornecedor']['observacao'];?></textarea>
