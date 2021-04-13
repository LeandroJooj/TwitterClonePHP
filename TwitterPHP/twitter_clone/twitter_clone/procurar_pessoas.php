<?php

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}


	require_once('db.class.php');
		$id_usuario = $_SESSION['id_usuario'];
	$objDb = new db();
	$link = $objDb->conecta_mysql();
	
	$sql = "SELECT  COUNT(*) as qtde_tweets FROM tweet WHERE id_usuario = $id_usuario ";
	$resultado_id = mysqli_query($link,$sql);
	$qtd_tweets = 0;
	if($resultado_id){
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		$qtd_tweets = $registro['qtde_tweets'];
	}
	else{
		echo 'erro na query';
	}
	
	$sql = "SELECT  COUNT(*) as qtde_seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario = $id_usuario ";
	$resultado_id = mysqli_query($link,$sql);
	$qtde_seguidores = 0;
	if($resultado_id){
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		$qtde_seguidores = $registro['qtde_seguidores'];
	}
	else{
		echo 'erro na query';
	}

?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>
			
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script type="text/javascript">
			$(document).ready( function(){
				$('#btn_procurar_pessoa').click( function(){
					if($('#nome_pessoa').val().length > 0){ 


						$.ajax({
							url: 'get_pessoas.php', 
							method: 'post', 
							data: $('#form_procurar_pessoas').serialize(nome_pessoa),
							success: function(data){ 
							$('#pessoas').html(data);								
							$('.btn_seguir_').click( function(){
								var id_user = $(this).data('id_user');
								$('#btn_seguir_'+id_user).hide();
								$('#btn_deixar_seguir_'+id_user).show();
								$.ajax({
									url: 'seguir.php', 
									method: 'post', 
									data: { seguir_id_usuario: id_user }					
								});
							});


							$('.btn_deixar_seguir_').click( function(){
								var id_user = $(this).data('id_user');
								$('#btn_deixar_seguir_'+id_user).hide();
								$('#btn_seguir_'+id_user).show();

								$.ajax({
									url: 'deixar_seguir.php', 
									method: 'post', 
									data: { deixar_usuario: id_user }
								});		
							});													
						}
					});
				}
			});
		});
		</script>
	
	</head>

	<body>


	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="imagens/icone_twitter.png" />
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="sair.php">Sair</a></li>
				<li><a href="home.php">Home</a></li>	
				 <li><a href="perfil.php">Perfil</a><li>            
	          </ul>
	        </div>
	      </div>
	    </nav>


	    <div class="container">
	    	
	    	<br /><br />

	    	<div class="col-md-3">
	    		<div class="panel panel-default">
	    			<div class="panel-body"> 
	    				<h4> <?php echo $_SESSION['usuario']; ?></h4>
	    				<hr>

	    				<div class="col-md-6">
	    					TWEETS <br> <?= $qtd_tweets ?>    	    					
	    				</div>

	    				<div class="col-md-6"> 	 
	    					SEGUIDORES <br> <?= $qtde_seguidores ?>		  					
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    	<div class="col-md-6">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<form id="form_procurar_pessoas"  class="input-group">
	    					<input type="text" name="nome_pessoa" id="nome_pessoa" class="form-controll" placeholder="Quem você quer achar ?" maxlength="140" style="width: 100%"> 
	    					<span class="input-group-btn"> 
	    						<button class="btn btn-default" id="btn_procurar_pessoa" type="button"> Procurar</button>
	    					</span>
	    				</form>
	    			</div>
	    		</div>

	    		<div id="pessoas" class="list-group">
	    			
	    		</div>

			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4>

						</h4>
					</div>
				</div>
			</div>

		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>

