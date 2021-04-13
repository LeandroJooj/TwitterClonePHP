for (var i = 0; i <= $qtde_seguidores; i++) {
	$("#tweetadas_<?= $id_seguidor; ?>").html(data);
}

$sql = 'select id_usuario from usuarios_seguidores where seguindo_id_usuario= $_SESSION["id_usuario"]';
 

$resultado_id = mysqli_query($link,$sql);

$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);