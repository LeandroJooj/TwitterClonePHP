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

	$sql = "SELECT  COUNT(*) as qtde_pessoas_segue FROM usuarios_seguidores WHERE id_usuario = $id_usuario ";
	$resultado_id = mysqli_query($link,$sql);
	$qtde_pessoas_segue = 0;
	if($resultado_id){
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		$qtde_pessoas_segue = $registro['qtde_pessoas_segue'];
	}
	else{
		echo 'erro na query';
	}

	$sql = "select DATE_FORMAT(`data_registro`,'%M de %Y') as data_registro_nova  from usuarios_seguidores where id_usuario = $id_usuario;";
	$resultado_id = mysqli_query($link,$sql); 
	if($resultado_id){
		$passa_pra_array = mysqli_fetch_array($resultado_id); 

		$data_de_ingressao = $passa_pra_array['data_registro_nova'];

	}
	else{
		echo 'acho que rolou um erro';
	}

	$urlFoto = 'src="../../uploads/'.$id_usuario.'/fotoDePerfil.jpg" class="img-responsive img-thumbnail"';


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
			function atualiza(){
						$.ajax({
						url:'get_meus_tweets.php',
						success: function(data){
							$('#tweeta').html(data);
						}
					});
				}	
				atualiza();
				setInterval(atualiza, 30000);		
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
	            <li><a href="home.php"> Home </a> </li>
	          </ul>
	        </div>
	      </div>
	    </nav>


	    <div class=" container">
	    	<br><br>
	    	<div class="col-md-2">
	    		<div style="border-color: none" >
	    			<img <?= $urlFoto ?>>

	    		</div>
	    	</div>
	    	<div class="col-md-6" >
		    	<form method="post" action="trocar_foto.php" enctype="multipart/form-data">
		    		<p><?php echo $_SESSION['usuario']; ?></p>
		    		<label>Adicionar nova foto</label>
		    		<input type="file" name="arquivo" placeholder="Escolha uma foto">
		    		<button type="submit">Mudar foto</button>
	    		</form>
	    	</div>
	    </div>


	    <div class="container">
	    	
	    	<br /><br />

	    	<div class="col-md-12">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    			
	    				<hr>

	    				<div class="col-md-6" id="casca">
	    					<ul>
	    					<li><h4> Quantidade de tweets: <?= $qtd_tweets ?> </h4>  </li>
	    					<li><h4> Quantidade de seguidores: <?= $qtde_seguidores ?> </h4></li>
	    					<li><h4> Quantidade de pessoas que você segue: <?= $qtde_pessoas_segue ?></h4> </li><br>
	    					</ul>
	    				</div>

	    				<div class="col-md-6">
	    					<h4> Ingressou em: <?=$data_de_ingressao?> </h4>
	    				</div>
	    			</div>
	    		</div>

	    	</div>

	    	<div class="col-md-12">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<h4> Seus tweets </h4>
	    				<hr>
	    				<div id="tweeta" class="list-group" style="word-wrap: break-word;">

	    				</div>
	    			</div>
	    		</div>


			</div>


		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>