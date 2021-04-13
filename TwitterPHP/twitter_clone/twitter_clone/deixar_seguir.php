<?php

session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');

	$id_usuario = $_SESSION['id_usuario'];
	$deixar_usuario = $_POST['deixar_usuario'];

	if($id_usuario =='' || $deixar_usuario ==''){
		die();
	}
 
	$objDb = new db();
	$link = $objDb->conecta_mysql();
	
	echo $id_usuario;
$sql = "DELETE FROM usuarios_seguidores ";
$sql .="WHERE id_usuario = $id_usuario AND seguindo_id_usuario = $deixar_usuario";
	
	mysqli_query($link,$sql);
?>
