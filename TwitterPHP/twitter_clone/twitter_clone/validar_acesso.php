<?php

	session_start();

	require_once('db.class.php');

	$objDb = new db();
	$link = $objDb->conecta_mysql();


	$usuario = $_POST['usuario'];
	$senha 	= md5($_POST['senha']);

	$sql = "select id, usuario, email from usuarios where usuario = '$usuario' and senha = '$senha' ;"; 

	$resultado_Id =	mysqli_query($link, $sql);

	if($resultado_Id){
		$dados_usuario = mysqli_fetch_array($resultado_Id);
		
		if(isset($dados_usuario['usuario'])){ 
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
?>