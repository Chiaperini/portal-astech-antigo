<?php
	session_start();
	date_default_timezone_set('America/Sao_Paulo');
	include('conexao.php');
	
	$url_vistas = "https://portalastech.chiaperini.com.br/media/vistas-explodidas/";
	$url_atual = "http://portalastech.chiaperini.com.br/admin/pages/";
	$url = "http://portalastech.chiaperini.com.br/";	

	function usuarioestalogado()//retorna se usuario esta logado ou nao
	{
	return isset($_SESSION['usuario_admin']) && !empty($_SESSION['usuario_admin'])  ? true : false;
 	}
	
	function logarUsuario($login, $senha){ //verifica se o usuario tem cadastro de login
		$mysqli = new mysqli('localhost', 'paste_pa', 'NwiP^y4-3+=a', 'paste_pa'); 
		$senha = $senha;
		$busca_login = "SELECT * FROM usuarios WHERE email = '{$login}' AND senha = '{$senha}'";
		$result_busca_login = mysqli_query($mysqli, $busca_login);
		
		if($row_busca_login = mysqli_fetch_assoc($result_busca_login)){
			
			$_SESSION['usuario_logado'] = $row_busca_login['email'];
			$_SESSION['id_usuario'] = $row_busca_login['id'];
			$_SESSION['nome_usuario'] = $row_busca_login['nome'];
			$_SESSION['ultimoAcesso']= date('Y-m-d H:i:s');

			$sql_update = "UPDATE usuarios SET data_ultimo_acesso ='{$_SESSION['ultimoAcesso']}' WHERE id='{$_SESSION['id_usuario']}'";
	    	$result_update = mysqli_query($mysqli, $sql_update);
			return true;
		}
		else{
			return false;
		}
	}
	function buscaDadosAssistente(){
		$mysqli = new mysqli('localhost', 'paste_pa', 'NwiP^y4-3+=a', 'paste_pa'); 
		$busca_Dados = "SELECT * FROM assistentes WHERE email = '{$_SESSION['usuario_logado']}'";
		$result_busca_dados = mysqli_query($mysqli, $busca_Dados);
		
		if($row_busca_dados = mysqli_fetch_assoc($result_busca_dados)){
			echo $row_busca_dados['nome_empresa'];
		}
	}
	function trocaSenha($senha_atual, $nova_senha){
		$mysqli = new mysqli('localhost', 'paste_pa', 'NwiP^y4-3+=a', 'paste_pa'); 
		$busca_usuario= "SELECT * FROM usuarios WHERE id = '{$_SESSION['id_usuario']}'";
		$result_usuario = mysqli_query($mysqli, $busca_usuario);
		
		if($row_usuario = mysqli_fetch_assoc($result_usuario)){
			if($row_usuario['senha'] === md5($senha_atual)){
				$nova_senha = md5($nova_senha);
				$sql_update = "UPDATE usuarios SET senha ='{$nova_senha}' WHERE id='{$_SESSION['id_usuario']}'";
		    	$result_update = mysqli_query($mysqli, $sql_update);
				return true;
			}
			else{
				?><script>alert('Senha atual incorreta');window.history.back();</script><?php
			}
		}
	}
	function atualizaSenha($nova_senha, $confirma_senha){
		$mysqli = new mysqli('localhost', 'paste_pa', 'NwiP^y4-3+=a', 'paste_pa'); 
		$busca_usuario= "SELECT * FROM usuarios WHERE id = '{$_SESSION['id_usuario']}'";
		$result_usuario = mysqli_query($mysqli, $busca_usuario);
		
		if($row_usuario = mysqli_fetch_assoc($result_usuario)){
			if($nova_senha === $confirma_senha){
				$nova_senha = md5($nova_senha);
				$sql_update = "UPDATE usuarios SET senha ='{$nova_senha}' WHERE id='{$_SESSION['id_usuario']}'";
		    	$result_update = mysqli_query($mysqli, $sql_update);
				return true;
			}
			else{
				?><script>alert('Os campos senha e repetir senha estão diferentes');window.history.back();</script><?php
			}
		}
	}
	function cadastraRat(){
		$mysqli = new mysqli('localhost', 'paste_pa', 'NwiP^y4-3+=a', 'paste_pa');
	}
	function tratar_arquivo_upload($string){
	   // pegando a extensao do arquivo
	   $partes 	= explode(".", $string);
	   $extensao 	= $partes[count($partes)-1];	
	   // somente o nome do arquivo
	   $nome	= preg_replace('/\.[^.]*$/', '', $string);	
	   // removendo simbolos, acentos etc
	   $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýýþÿŔŕ?';
	   $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuuyybyRr-';
	   $nome = strtr($nome, utf8_decode($a), $b);
	   $nome = str_replace(".","-",$nome);
	   $nome = preg_replace( "/[^0-9a-zA-Z\.]+/",'-',$nome);
	   return utf8_decode(strtolower($nome.".".$extensao));
	}
	function logout(){
		session_destroy();
		header("location: index.php");
	}
?>