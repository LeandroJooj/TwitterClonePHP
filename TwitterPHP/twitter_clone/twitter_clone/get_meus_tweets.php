<?php
	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');
	$id_usuario = $_SESSION['id_usuario'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();
	

	//essa query é o que faz possivel vermos os  nosso tweets e os de quem seguimos
	$sql = "select DATE_FORMAT(t.data_inclusao, '%d/%b/%Y- %T') as data_inclusao_formatada, t.tweet, u.usuario, t.id_usuario from tweet AS t JOIN usuarios AS u On(t.id_usuario = u.id) where id_usuario = $id_usuario order by data_inclusao_formatada desc ";
	
	
	$resultado_id = mysqli_query($link,$sql);
// mysqli_fetch_array() ---------> tudo que tá linha de consulta sql vira um elemento do array
	// toda vez que roda o laço a $resultado_id recebe a próxima linha do sql
	if($resultado_id){
		while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
												// Dá pra fazer a mesma coisa sem ASSOC
			$urlFoto = 'src="../../uploads/'.$registro['id_usuario'].'/fotoDePerfil.jpg"';

			echo '<a href="#" class="list-group-item">';
				echo '<h4 class="list-group-item-heading">';
					echo '<img '.$urlFoto.' class="img-circle" width="45" height="45">'.$registro['usuario'].'<small> - '.$registro['data_inclusao_formatada'].'</small>';
				echo '</h4>';
					echo '<p class="list-group-item-text">'.$registro['tweet'].'</p>';
				
			echo '</a>';
			echo "<hr>";
		}
	}
	else{
		echo 'erro na consulta do banco de dados';
	}
?>

