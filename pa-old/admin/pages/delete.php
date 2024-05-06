<?php include('header.php'); 

$pagina = $_GET['pagina'];

if($pagina == 'usuarios_admin'){
	$id = $_GET['id'];
	$delete_usuario = "DELETE FROM usuarios_admin WHERE id = '{$id}'";
	$result_delete = mysqli_query($mysqli, $delete_usuario);	
	if($result_delete){
		echo '<script>alert("Usuário excluído com sucesso!");window.location.href = "http://portalastech.chiaperini.com.br/admin/pages/index.php";</script>';
	}
	else{
		echo '<script>alert("Erro ao tentar excluir o Usuário");window.history.go(-1);</script>';
	}
}
?>