<h2>Adicionar cliente</h2>

<?php

print $form->create('Cliente');

print $form->input('tipo_pessoa');
print $form->input('nome');
print $form->input('nome_fantasia');
print $form->input('logradouro_nome');
print $form->input('logradouro_numero');
print $form->input('logradouro_complemento');
print $form->input('bairro');
print $form->input('cidade');
print $form->input('uf');
print $form->input('cep');
print $form->input('cnpj');
print $form->input('inscricao_estadual');
print $form->input('cpf');
print $form->input('rg');
print $form->input('numero_telefone');
print $form->input('endereco_email');
print $form->input('observacao');


print $form->end('Gravar');

?>