<?php

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}




	require_once('db.class.php');
		$id_usuario = $_SESSION['id_usuario'];
	$objDb = new db();
	$link = $objDb->conecta_mysql();
	//recuperar a quantidade de tweets 


	if ($_POST['user']) {
		$id_usu_perfil = $_POST['user'];
	}
	else{
		$id_usu_perfil = $_SESSION['id_usuario'];
	}


$sqlFLW = 'select us.id_usuario, u.usuario from usuarios_seguidores as us join usuarios as u where us.seguindo_id_usuario= '.$id_usuario.' and us.id_usuario = u.id';

	$follower_id = mysqli_query($link,$sqlFLW);
	
	if ($follower_id) {
		$registrador = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);	
		$id_seguidor = $registrador['id_usuario'];
		$nome_seguidor = $registrador['usuario'];
	}




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
	//recuperar a quantidade de seguidores 

$sql = "SELECT  COUNT(*) as qtde_seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario=$id_usuario ";
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
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script type="text/javascript">
			$(document).ready( function(){
				$(document).keydown(function (e) {
    				if (e.keyCode == 13) {   
      					$('#btn_tweet').trigger();
    				}
			});
				$('#btn_tweet').click( function(){
					if($('#texto_tweet_id').val().trim().length > 0){ //trim() elimina espaços em branco


						$.ajax({
							url: 'inclui_tweet.php', //script que queremos executar/ que será feeito a requisição


							method: 'post', //manda o que tá aqui pra url em forma de post


							data: $('#form_tweet').serialize(texto_tweet_id),
							// usamos a função serialize, que com base em um ID de formulário retorna um JSon, com o name que passamos por parametro a função vai saber com qual chave vai formar o JSon 
							//data: $('#valor').serialize(chave)  <--- isso é o que sera enviado via POST

							/*
								aqui nós não usamos serialize
								data: {	texto_tweet: $('#texto_tweet_id').val()},	

							*/
							//data: {	chave1: valor1, chave2: valor2}

							success: function(data){ 
							//Enviou tudo corretamente ? então execute isso 
							//função que passa por parametro o response text(url)
								 $('#texto_tweet_id').val('');
								 atualizaTweet(); //todo elemento gerado por ajax tem que ser é tratado dentro do próprio ajax
								 atulaizaTweetSeguidores();

							}
						});
					}
				});



				function atualizaTweet(){
					//carregar tweets 
					$.ajax({ 
						url: 'get_tweet.php',
						success: function(data){
							$("#tweetadas_<?= $id_usu_perfil; ?>").html(data);	
												
						}
					});
				}

				function atulaizaTweetSeguidores(){
					$.ajax({ // implementar envio de método e handler
						url: 'home.php?usuario=<?= $nome_seguidor ?>',
						success: function(data){
							for (var i = 0; i <= <?= $qtde_seguidores ?>; i++) {
								
								$("#tweetadas_<?= $id_seguidor; ?>").atualizaTweet();
							}
												
						}
					});

				}
				//executam automaticamente quando a pagina tá pronta
				atualizaTweet(); 
			});
		</script>
	
	</head>

	<body>

		<!-- Static navbar -->
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
	            <li><a href="perfil.php">Perfil</a><li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">
	    	
	    	<br /><br />

	    	<div class="col-md-3">
	    		<div style="border-color: none" >
	    			<img src="../../uploads/<?=$id_usu_perfil ?>/fotoDePerfil.jpg" class="img-responsive img-thumbnail">
	    			<div class="panel panel-default">
	    			<div class="panel-body"> 
	    				
		    			
		    				<h4> <?php echo $_SESSION['usuario']; ?></h4>
		    				<hr>

		    				<div id="ops" class="col-md-6">
		    					TWEETS <br>  	<?= $qtd_tweets ?>    					
		    				</div>

		    				<div class="col-md-6"> 	 
		    					SEGUIDORES <br> <?= $qtde_seguidores ?>					
		    				</div>
		    			</div>
	    			</div>
	    		</div>
	    	</div>
	    	<div class="col-md-6">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<form id="form_tweet"  class="input-group">
	    					<input type="text" name="texto_tweet" id="texto_tweet_id" class="form-controll" placeholder="O que tá rolando agora ?" maxlength="140" style="width: 100%"> 
	    					<!-- maxlength serve para limitar o numero de caracteres-->

	    					<span class="input-group-btn"> 
	    						<button class="btn btn-default" id="btn_tweet" type="button"> Tweet</button>

	    					</span>
	    				</form>
	    			</div>
	    		</div>


	    		<?
				echo '<div id="tweetadas_'.$id_usu_perfil.'" class="list-group" style="word-wrap: break-word;">';
	    		echo '</div>';
	    		?>
			</div>
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4>
							<a href="procurar_pessoas.php">
								procurar por pessoas
							</a>
						</h4>
					</div>
				</div>
			</div>

		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>

<!--
action="registra_usuario.php" os dados preenchidos no formuláario são mandados para registra_usuario.php

-->