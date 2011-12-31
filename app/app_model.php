<?php

class AppModel extends Model {
	
	/**
	 * Métodos para utilizar transações
	 */
	
	/**
	 * Inicia uma transação (transaction) no banco de dados
	 * 
	 * @return true
	 */
	public function begin() {
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$db->begin($this);
		
		return true;
    }
	
	/**
	 * Grava no banco (faz commit) os dados que estao na transação atual
	 * 
	 * @return true
	 */
    public function commit() {
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$db->commit($this);
		
		return true;
    }

	/**
	 * Desfaz a transação corrente
	 * 
	 * @return true
	 */
    public function rollback() {
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$db->rollback($this);
		
		return true;
    }
	
}

?>