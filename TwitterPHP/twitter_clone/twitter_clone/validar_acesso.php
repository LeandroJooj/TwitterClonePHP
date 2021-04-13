<?php

	session_start();//a super variável global session é semelhante ao _POST e ao _GET, a diferença da superglobal session é que ela fica disponível durante todo o escopo da aplicação. Então, enquanto o navegador estiver aberto ela estará disponível em qualquer página sem a necessidade de transportar os dados por _GET ou _POST

	//session_start() deve ser iniciado antes de qualquer output de dados pro navegador 

	//só podemos usar variáveis de sessão após iniciar a sessão

	require_once('db.class.php');

	$objDb = new db();
	$link = $objDb->conecta_mysql();


	$usuario = $_POST['usuario'];
	$senha 	= md5($_POST['senha']);

	$sql = "select id, usuario, email from usuarios where usuario = '$usuario' and senha = '$senha' ;"; 

	$resultado_Id =	mysqli_query($link, $sql);

	
//mysqli_fetch_array(referencia_para_o_resultado_externo_do_php); <------ retorna esses dados em estrutura de array;

	if($resultado_Id){ //teste de erro de sintaxe na query
		$dados_usuario = mysqli_fetch_array($resultado_Id);
		
		if(isset($dados_usuario['usuario'])){ //isset determina se a variavel foi iniciada 
			$_SESSION['usuario'] = $dados_usuario['usuario'];
			$_SESSION['email'] = $dados_usuario['email'];
			$_SESSION['id_usuario'] = $dados_usuario['id'];

			header('Location: home.php?usuario='.$_SESSION['usuario']); 
		}
		else{
			header('Location: index.php?erro=1');
		}
	}
	else{
		echo 'erro na consulta sql';
	}





//mysqli_query -------> o que o result mod dele retorna 
	//update true/false
	//insert true/false
	//select resource/false 
	//delete true/false


#var_dump($dados_usuario); ---> retorna os dados de registro 


?>