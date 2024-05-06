<?php
	session_start();
	date_default_timezone_set('America/Sao_Paulo');
	include('media/core/conexao.php');
	
	$login = $_POST['login'];
	$senha = md5($_POST['senha']);
	
	if (($login) == ''){
		$retorno = array('codigo' => 0, 'mensagem' => 'Preencha seu e-mail!');
		alert($retorno);
		exit();
	}
	if (($senha) == ''){
		$retorno = array('codigo' => 0, 'mensagem' => 'Preencha sua senha!');
		alert($retorno);
		exit();
	}	
	
	$mysqli = new mysqli('localhost', 'paste_pa', 'NwiP^y4-3+=a', 'paste_pa'); 
	$busca_admin = "SELECT * FROM usuarios_admin WHERE email = '{$login}' AND senha = '{$senha}'";
	$result_admin = mysqli_query($mysqli, $busca_admin);
	
	if($row_admin = mysqli_fetch_assoc($result_admin)){
		$_SESSION['usuario_admin'] = $row_admin['email'];
		$_SESSION['id_admin'] = $row_admin['id'];
		$_SESSION['nome_admin'] = $row_admin['nome'];
		$_SESSION['ultimoAcesso_admin']= date('Y-m-d H:i:s');
		
		$insert_admin = "INSERT into log_informacoes(id_user, nome, email, acao, local, data) VALUES('{$_SESSION['id_admin']}', '{$_SESSION['nome_admin']}', '{$_SESSION['usuario_admin']}', 'login' , 'area-login' , '{$_SESSION['ultimoAcesso_admin']}')  ";
    	mysqli_query($mysqli, $insert_admin);
		
		echo '1';
	}
	else{
		echo '0';
	}
?>