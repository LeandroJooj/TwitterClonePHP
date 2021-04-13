<?php 
session_start();
	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}
	$id_usuario = $_SESSION['id_usuario'];




$_UP['pasta'] 		= '/var/www/html/uploads/';

$_UP['tamanho'] 	= 1024 * 1024 *2;

$_UP['extensoes'] 	= array('jpg','jpeg','png','gif');

$_UP['renomeia'] 	= false;



$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';


if ($_FILES['arquivo']['error'] != 0) {
	die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
	exit; 
}

$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
if (array_search($extensao, $_UP['extensoes']) === false)
{
echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
}

else if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
}
 

else {

	if ($_UP['renomeia'] == true) {

		$nome_final = time().'.jpg'; 
	} 
	else {

	$nome_final = $_FILES['arquivo']['name'];
	}
	 

	 echo $_FILES['arquivo']['tmp_name']; 
	 echo '<br>';
	 $novoNome = $_UP['pasta'].$id_usuario.'/'.basename('fotoDePerfil.jpg');

	 if(!$_UP['pasta'].$id_usuario){
	 	mkdir($_UP['pasta'].$id_usuario);
	 }
	$uploadfile = $_UP['pasta'].basename($_FILES['arquivo']['name']);
	if (move_uploaded_file($_FILES['arquivo']['tmp_name'],$uploadfile)) {
				if(file_exists($novoNome)) {
					unlink($novoNome);
				}
				rename($uploadfile, $novoNome);

	} 
	else {
		echo "Não foi possível enviar o arquivo, tente novamente";
	}
 
}
	echo $novoNome;

?>





