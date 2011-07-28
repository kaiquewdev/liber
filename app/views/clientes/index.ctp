<!-- Arquivo: /app/views/clientes/index.ctp -->
<h1>Clientes cadastrados</h1>
<table>
	<tr>
		<th>Código</th>
		<th>Pessoa</th>
		<th>Nome</th>
		<th>Nome fantasia</th>
		<th>Logradouro</th>
		<th>Telefone fixo</th>
		<th>Celular</th>
	</tr>
	<?php foreach ($clientes as $cliente):
	?>
	<tr>
		<td><?php print $cliente['Cliente']['id'];?></td>
		<td><?php print $cliente['Cliente']['tipo_pessoa']; ?></td>
		<td><?php print $html -> link($cliente['Cliente']['nome'], "/clientes/ver/" . $cliente['Cliente']['id']);?></td><br/>
		<td><?php print $cliente['Cliente']['nome_fantasia']; ?></td>
		<td><?php print $cliente['Cliente']['logradouro_nome']; ?></td>
		<td><?php print $cliente['Cliente']['numero_telefone'] ?></td>
		<td><?php print $cliente['Cliente']['numero_celular'] ?></td>
	</tr>
	<?php endforeach;?>
</table>
