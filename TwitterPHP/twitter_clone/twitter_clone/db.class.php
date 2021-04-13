<?php

class db
{	
	//host 			<------- endereço de onde o mysql stá instalado

	private $host = 'localhost';
	//usuário		<------- usuário de conxão com mysql
	private $usuario  =  'root';
	//senha 
	private $senha = '84404714';
	//banco de dados 
	private $dataBase = 'twitter_clone';

	public function conecta_mysql(){
		//$conexao é o objeto de conexao
		$conexao = mysqli_connect($this -> $host,$this->usuario,$this->senha,$this->dataBase);

		//charset da comunicação entre a aplicação e o bancode dados 
		//ajustar o charset no processo de comunicação:
		mysqli_set_charset($conexao, 'utf8');

		//verificação de erros de conexão 
		// mysqli_connect_errno() nos retorna um código de erro, que se não for zero então existem erros no processo de conexão 
		if(mysqli_connect_errno()){
			echo 'erro ao tentar se conectar no mysql: '.mysqli_connect_error();
		}

		return $conexao;
	}

	


}
//mysqli_connect(localizacao_bd, usuario, senha bd)

?>