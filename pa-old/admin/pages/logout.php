<?php 
include_once('../media/core/functions.php');

if(usuarioestalogado()){
	echo "<script>confirm('Deseja sair do sistema?')</script>";
   	session_destroy();
   	header("location: http://portalastech.chiaperini.com.br/admin");
   	exit();
}
else{
	echo '<script>alert("Você já saiu do sistema.");</script>';
	header("location: http://portalastech.chiaperini.com.br/admin");
}

?>