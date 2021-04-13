<?php
	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');
	$id_usuario = $_SESSION['id_usuario'];
	$nome_pessoa = $_POST['nome_pessoa'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();
	

	$sql  = "select u.*, us.* from usuarios " ;
	$sql .= "as u LEFT JOIN usuarios_seguidores as us ";
	$sql .= "on(us.id_usuario = $id_usuario and u.id = us.seguindo_id_usuario) ";
	$sql .= "where u.usuario like '%$nome_pessoa%' and u.id <> $id_usuario ";
	//$sql = "select * from usuarios where usuario like '$nome_pessoa%' and id <> '$id_usuario' ";
	//volta um nome de usuario que não tenha o mesmo ID que eu 
	
	
	$resultado_id = mysqli_query($link,$sql);
// mysqli_fetch_array() ---------> tudo que tá linha de consulta sql vira um elemento do array
	// toda vez que roda o laço a $resultado_id recebe a próxima linha do sql
	if($resultado_id){
		while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
												// Dá pra fazer a mesma coisa sem ASSOC
			echo '<a href="#" class="list-group-item">';
				echo '<strong> '.$registro['usuario'].' </strong> <small>  - '.$registro['email'].' </small>';
				echo '<p class="list-group-item-text pull-right">'; 

				$esta_seguindo_usuario_sn = isset($registro['id_usuario_seguidor']) && !empty($registro['id_usuario_seguidor']) ? 'S' : 'N';

				$btn_seguir_display = 'block';
				$btn_deixar_seguir_display = 'block';

				if($esta_seguindo_usuario_sn == 'N'){
					$btn_deixar_seguir_display = 'none';
				}
				else{
					$btn_seguir_display = 'none';
				}


				echo '<button data-id_user="'.$registro['id'].'" id="btn_seguir_'.$registro['id'].'" class=" btn btn-default btn_seguir_" style="display:'.$btn_seguir_display.'" >'; // data é um recurso do html5 que permite criar atributos personalizados
						echo 'Seguir';
					echo '</button>';
				echo '</p>';




				echo '<p class="list-group-item-text pull-right">'; 
				echo '<button data-id_user="'.$registro['id'].'" id="btn_deixar_seguir_'.$registro['id'].'" style="display:'.$btn_deixar_seguir_display.'" class=" btn btn-primary btn_deixar_seguir_" >'; 
						echo 'Deixar de eguir';
					echo '</button>';
				echo '</p>';				



				echo '<div class="clearfix"></div>'; 
			echo '</a>';
			echo '<hr>';
			// echo "<hr>";
		}
	}
	else{
		echo 'erro na consulta de usuários no banco de dados';
	}
?>

