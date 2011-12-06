<?php
/**
 * @author        Tobias Sette Ferreira
 * @copyright     Tobias Sette Ferreira - 2011
 * @link          http://gnu.eti.br
 * @package       Liber
 * @license       GPL v3
 */
?>
<h2><?php echo $name; ?></h2>
<p class="error">
	<strong><?php __('Error'); ?>: </strong>
	<?php printf(__('O endereço solicitado %s não foi encontrado neste servidor.', true), "<strong>'{$message}'</strong>"); ?>
</p>