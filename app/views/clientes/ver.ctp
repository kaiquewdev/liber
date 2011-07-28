<!-- Arquivo: /app/views/clientes/ver.ctp --> 
<h2>Visualizar cliente</h2>
Nome: <h1><?php print $cliente['Cliente']['nome'] ?></h1>
Nome fantasia: <h1><?php  print $cliente['Cliente']['nome_fantasia'];?></h1>
Tipo pessoa: <?php
					if ( $cliente['Cliente']['tipo_pessoa'] == 'J'):
						print 'Jurídica';
					elseif ( $cliente['Cliente']['tipo_pessoa'] == 'F' ):
						print 'Física';
					endif;
				?>
<p>
	<small>Criado em: <?php print $cliente['Cliente']['data_cadastrado']; ?></small>
</p>
<p>
	<small>Atualizado em: <?php print $cliente['Cliente']['atualizado']; ?></small>
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
			<?php if ( $cliente['Cliente']['tipo_pessoa'] = 'J'): ?>
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
			<td><?php  print $cliente['Cliente']['nome'];?></td>
			<td><?php  print $cliente['Cliente']['logradouro_nome'];?></td>
			<td><?php  print $cliente['Cliente']['logradouro_numero'];?></td>
			<td><?php  print $cliente['Cliente']['logradouro_complemento'];?></td>
			<td><?php  print $cliente['Cliente']['bairro'];?></td>
			<td><?php  print $cliente['Cliente']['cidade'];?></td>
			<td><?php  print $cliente['Cliente']['uf'];?></td>
			<td><?php  print $cliente['Cliente']['cep'];?></td>
			<?php if ( $cliente['Cliente']['tipo_pessoa'] = 'J'): ?>
				<td><?php  print $cliente['Cliente']['cnpj'];?></td>
				<td><?php  print $cliente['Cliente']['inscricao_estadual'];?></td>
			<?php else: ?>
				<td><?php  print $cliente['Cliente']['cpf'];?></td>
				<td><?php  print $cliente['Cliente']['rg'];?></td>
			<?php endif; ?>
			<td><?php  print $cliente['Cliente']['numero_telefone'];?></td>
			<td><?php  print $cliente['Cliente']['numero_celular'];?></td>
			<td><?php  print $cliente['Cliente']['endereco_email'];?></td>
		</tr>
	</tbody>
	
</table>

Observação: <textarea><?php  print $cliente['Cliente']['observacao'];?></textarea>
