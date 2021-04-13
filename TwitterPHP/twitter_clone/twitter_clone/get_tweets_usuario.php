<?php
	session_start();

	require_once('db.class.php');
	$id_usuario = $_POST['id_seguidor'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();
	

	
	$sql = "select DATE_FORMAT(t.data_inclusao, '%d/%b/%Y- %T') as data_inclusao_formatada, t.tweet, u.usuario, t.id_usuario from tweet AS t JOIN usuarios AS u On(t.id_usuario = u.id) where id_usuario = $id_usuario order by data_inclusao_formatada desc";

	
	
	$resultado_id = mysqli_query($link,$sql);

	if($resultado_id){
		while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
												

			$urlFoto = 'src="../../uploads/'.$registro['id_usuario'].'/fotoDePerfil.jpg"';
			echo '<form id="form_re_'.$registro['id_tweet'].'" method="post" action="perfil_usuario.php">';
				echo '<a href="#"  name="selecao"class="list-group-item">';


				echo '<input type="text" name="user" value="'.$registro['id_usuario'].'" style="display:none">';
				echo '<h4  class="list-group-item-heading">';
					echo '<img id="selecao_'.$registro['id_tweet'].'"  ' .$urlFoto.' class="img-circle" width="45" height="45">'.$registro['usuario'].'<small> - '.$registro['data_inclusao_formatada'].'</small>';

				echo '</h4>';
					echo '<p class="list-group-item-text">'.$registro['tweet'].'</p>';
				
				echo '</a>';
			echo '</form>';
			echo "<hr>";
			echo '<script type="text/javascript"> $("#selecao_'.$registro['id_tweet'].'").click( function(){$("#form_re_'.$registro['id_tweet'].'").submit();});</script>';			
		}
		//
		
	}
	else{
		echo 'erro na consulta do banco de dados';
	}
?>

