<?php
	session_start();
	date_default_timezone_set('America/Sao_Paulo');
	include('media/core/conexao.php');
	
	//$login = $_POST['input_login'];
	//$senha = md5($_POST['input_senha_login']);
	$login = $_POST['login'];
	$senha = md5($_POST['senha']);
	
	// Dica 2 - Validações de preenchimento e-mail e senha se foi preenchido o e-mail
	if (empty($login)){
		$retorno = array('codigo' => 0, 'mensagem' => 'Preencha seu e-mail!');
		alert($retorno);
		exit();
	}
	
	if (empty($senha)){
		$retorno = array('codigo' => 0, 'mensagem' => 'Preencha sua senha!');
		alert($retorno);
		exit();
	}
		
	// Dica 3 - Verifica se o formato do e-mail é válido
	if (!filter_var($login, FILTER_VALIDATE_EMAIL)){
		 $retorno = array('codigo' => 0, 'mensagem' => 'Formato de e-mail inválido!');
		alert($retorno);
		exit();
	}
	
	$mysqli = new mysqli('localhost', 'paste_pa', 'NwiP^y4-3+=a', 'paste_pa'); 
	$busca_login = "SELECT * FROM usuarios WHERE email = '{$login}' AND senha = '{$senha}' AND status = '1'";
	$result_busca_login = mysqli_query($mysqli, $busca_login);
	
	if($row_busca_login = mysqli_fetch_assoc($result_busca_login)){
		$_SESSION['usuario_logado'] = $row_busca_login['email'];
		$_SESSION['id_usuario'] = $row_busca_login['id'];
		$_SESSION['nome_usuario'] = $row_busca_login['nome'];
		$_SESSION['ultimoAcesso']= date('Y-m-d H:i:s');
		$_SESSION['perfil'] = $row_busca_login['perfil'];
		$_SESSION['sessiontime'] = time() + 600;
		
		$sql_update = "UPDATE usuarios SET data_ultimo_acesso ='{$_SESSION['ultimoAcesso']}' WHERE id='{$_SESSION['id_usuario']}'";
    	$result_update = mysqli_query($mysqli, $sql_update);
		echo '1';
	}
	else{
		echo '0';
	}