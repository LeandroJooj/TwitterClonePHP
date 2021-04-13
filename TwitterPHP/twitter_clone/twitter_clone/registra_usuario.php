<?php 

	require_once('db.class.php');

	$user = $_POST['usuario'];	
	$email= $_POST['email'];	
	$senha= md5($_POST['senha']);

	$objDb = new db();
	$link = $objDb->conecta_mysql();


	$usuario_existe = false;
	$email_existe = false;


	//verificar se usuario já existe 
		$sql = "select * from usuarios where usuario = '$user';";
		
		if($resultado_id =mysqli_query($link,$sql)){
			$dados_usuario = mysqli_fetch_array($resultado_id);

			if(isset($dados_usuario['usuario'])){ // isset verifica se a variavel inicializou
				$usuario_existe = true;
				
			}
		}
		else{
			echo 'erro ao tentar localizar registro<br>';
		}

	//verificar se email já existe 

		$sql = "select * from usuarios where email = '$email';";
		
		if($resultado_id =mysqli_query($link,$sql)){
			$dados_usuario = mysqli_fetch_array($resultado_id);

			if(isset($dados_usuario['email'])){ // isset verifica se a variavel inicializou
				$email_existe = true;
			}
		}
		else{
			echo 'erro ao tentar localizar registro';	
}

		if($usuario_existe || $email_existe){
			$retorno_get = ''; 
			if ($usuario_existe) {
				$retorno_get.= 'erro_usuario=1&'; 
				// o caracter & serve para separar as variaveis e os valores
				//   .= é para concatenar
			}

			if ($email_existe) {
				$retorno_get.= 'erro_email=1&';
			}
			header('Location: inscrevase.php?'.$retorno_get);
			die();//interrompe a execução do script
		}
		


	//querys
	$sqlInsert = "insert into usuarios(usuario, email, senha) values ('$user', '$email', '$senha')";


	if(mysqli_query($link,$sqlInsert)){
		header('Location: index.php');

	}
	else{
		echo 'erro ao registrar usuário';
	}

	



?>

<!--
Há duas formas de recuperar os registros do usuário : com as super globais $_POST[valor] e $_GET[valor]
o que define se usaremos post ou get será o método usado no formulário de envio(method="post")

post e get são arrays associativos,o php faz a associação do valor para as sper globais de acordo com os nomes definidos em cada um dos campos(name="email")
	

	// a função conecta_mysql retorna uma conexão, ou seja, um link de conexão

	// como as aspas duplas já fazem a conversão direto então podemos colocar direto o nome das variaveis

	//executar a query
	//mysqli_query(conexão,query) <---- executa query


-->