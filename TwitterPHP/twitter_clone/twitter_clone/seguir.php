<?php

session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');
	$id_usuario = $_SESSION['id_usuario'];
	$seguir_id_usuario = $_POST['seguir_id_usuario'];

	if($id_usuario =='' || $seguir_id_usuario ==''){
		die();
	}
 
	$objDb = new db();
	$link = $objDb->conecta_mysql();
	
	$sql = "insert into usuarios_seguidores(id_usuario, seguindo_id_usuario) values($id_usuario, $seguir_id_usuario)";
	//volta um nome de usuario que não tenha o mesmo ID que eu 
	
	mysqli_query($link,$sql);

?>