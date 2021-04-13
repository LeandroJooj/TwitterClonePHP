<?php
	session_start();

	unset($_SESSION['usuario']);
	unset($_SESSION['email']); 

	header("Location: index.php");

?>

<!-- 

unset(array[indice_do_array_que_queremos_eliminar]) --- elimina indices de um array

-->