<?php

	require_once('db.class.php');

	$objDb = new db();
	$link = $objDb->conecta_mysql();


	$sql = "select * from usuarios;"; 

	$resultado_Id =	mysqli_query($link, $sql);

	if($resultado_Id){ 
		#$dados_usuario = mysqli_fetch_array($resultado_Id); 
		// Nesse é retornado indice numerico e associativo


		#$dados_usuario = mysqli_fetch_array($resultado_Id, MYSQLI_ASSOC);
		//MYSQLI_NUM faz retonar apenas indices numéricos
		//MYSQLI_ASSOC faz retornar apenas indices associativos(dicionario)
		//MYSQLI_BOTH retorna ambos, quando o segundo parametro é omitido esse é lançado por padrão

		
		#var_dump($dados_usuario['email']);
		//nesse só é retornado uma linha do banco de dados, mesmo eu pedindo tudo

		//var_dump($dados_usuario['email']) <-- volta só o tipo,tamanho e o email, como o dicionario 
		//var_dump($dados_usuario[0]) <-- volta só o tipo,tamanho e o indice zero, como um array comum
		//echo $dados_usuario['email'] <-- volta somente o email


		echo '<br>';
		echo '<br>';


		if ($resultado_Id) {
			$dados_usuario = array();
		}
		$i =0;
		while ($linha = mysqli_fetch_array($resultado_Id, MYSQLI_ASSOC)) {
			$dados_usuario[$i] = $linha;
			$i++;
		}

		foreach($dados_usuario as $usuario){ //foreach faz uma cópida do array e podemos aplicar a essa cópia um apelido
			var_dump($usuario['email']);//damos um var_dump em cada um dos indices individuais 
			echo '<br> <br>';
		}





/*----------------TODAS AS VEZES QUEE A FUNÇÃO EXECUTA ELA AUMENTA UMA LINHA--------------------------*/
		// echo '<br>';
		// var_dump(mysqli_fetch_array($resultado_Id, MYSQLI_ASSOC));
		// echo '<br>';
		// var_dump(mysqli_fetch_array($resultado_Id, MYSQLI_ASSOC));
		// echo '<br>';
		// var_dump(mysqli_fetch_array($resultado_Id, MYSQLI_ASSOC));
		
	}
	else{
		echo 'erro na consulta sql';
	}
?>

<!--
array(8) {
 [0]=> string(1) "1" 	<---------- retorna índice numérico, tipo e a informação
 ["id"]=> string(1) "1" <---------- retorna índice associativo com texto descritivo, tipo e a informação

 [1]=> string(2) "CJ" 	
 ["usuario"]=> string(2) "CJ" 

 [2]=> string(13) "CJGTA@gta.com" 
 ["email"]=> string(13) "CJGTA@gta.com" 

 [3]=> string(32) "81dc9bdb52d04dc20036dbd8313ed055" 
 ["senha"]=> string(32) "81dc9bdb52d04dc20036dbd8313ed055" } 

 -->