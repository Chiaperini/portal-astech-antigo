<?php
	session_start();
	date_default_timezone_set('America/Sao_Paulo');
	include('../media/core/conexao.php');
	
	$pagina = $_GET['pagina'];
	
	if($pagina == 'assistentes'){
		$id_assistente = $_POST['input_id'];
		
		$nome_empresa = utf8_encode($_POST['input_nome_empresa']);
		$cnpj = preg_replace("/\D+/", "", $_POST['input_cnpj']);
		$email = $_POST['input_email'];
		$nome_fantasia = utf8_encode($_POST['input_nome_fantasia']);
		$endereco = utf8_encode($_POST['input_endereco']);
		$complemento = utf8_encode($_POST['input_complemento']);
		$bairro = utf8_encode($_POST['input_bairro']);
		$cidade = $_POST['select_cidade'];
		$estado = $_POST['select_estado'];
		$cep = $_POST['input_cep'];
		$ddd = $_POST['input_ddd'];
		$telefone = $_POST['input_telefone'];
		$inscricao_estadual = $_POST['input_inscricao_estadual'];
		
		$sql_update = "UPDATE assistentes SET nome_empresa ='{$nome_empresa}', CNPJ = '{$cnpj}', email = '{$email}', nome_fantasia = '{$nome_fantasia}', 
		endereco = '{$endereco}', complemento = '{$complemento}', bairro = '{$bairro}', cep = '{$cep}', cod_cidade = '{$cidade}', estado = '{$estado}',
		ddd = '{$ddd}', telefone = '{$telefone}', inscricao_estadual = '{$inscricao_estadual}' WHERE id='{$id_assistente}'";
    	if($result_update = mysqli_query($mysqli, $sql_update)){
    		
			$insert_admin = "INSERT into log_informacoes(id_user, nome, email, acao, local, data) VALUES('{$_SESSION['id_admin']}', '{$_SESSION['nome_admin']}', '{$_SESSION['usuario_admin']}', 'atualizacao' , 'Assistente {$nome_empresa}{$id_assistente}' ,'{$_SESSION['ultimoAcesso_admin']}')  ";
    		if ($mysqli->query($insert_admin) === TRUE){
    			?><script>alert('Assistente atualizado com sucesso');window.location.href = "http://portalastech.chiaperini.com.br/admin/pages/assistentes.php?acao=gerenciar";</script><?php
    		}
    	}
		else{
			?><script>alert('Erro ao atualizar assistente. Verifique sua conexão ou entre em contato com o setor responsável');window.history.go(-1);</script><?php
		}
	}
	/* ----- USUARIOS ----- */
	if($pagina == 'usuarios'){
		$id_usuario = $_POST['input_id'];
		
		$nome = utf8_encode($_POST['input_nome']);
		$cnpj = $_POST['input_cnpj'];
		$email = $_POST['input_email'];
		$status = $_POST['select_status'];
		
		$sql_update = "UPDATE usuarios SET nome ='{$nome}', cnpj = '{$cnpj}', email = '{$email}', status = '{$status}' WHERE id='{$id_usuario}'";
    	if($result_update = mysqli_query($mysqli, $sql_update)){
    		
			$insert_admin = "INSERT into log_informacoes(id_user, nome, email, acao, local, data) VALUES('{$_SESSION['id_admin']}', '{$_SESSION['nome_admin']}', '{$_SESSION['usuario_admin']}', 'atualizacao' , 'Usuario {$nome}{$id_usuario}' ,'{$_SESSION['ultimoAcesso_admin']}')  ";
    		if ($mysqli->query($insert_admin) === TRUE){
    			?><script>alert('Usuario atualizado com sucesso');window.location.href = "http://portalastech.chiaperini.com.br/admin/pages/usuarios.php?acao=gerenciar";</script><?php
    		}
    	}
		else{
			?><script>alert('Erro ao atualizar usuario. Verifique sua conexão ou entre em contato com o setor responsável');window.history.go(-1);</script><?php
		}
	}
	/* ------ USUÁRIOS ADMIN ------- */
	if($pagina == 'usuarios_admin'){
		$id_usuario = $_POST['input_id'];
		$nome = utf8_encode($_POST['input_nome']);
		$email = $_POST['input_email'];
		$perfil = $_POST['perfil'];
		
		$sql_update = "UPDATE usuarios_admin SET nome ='{$nome}', email = '{$email}', perfil = '{$perfil}' WHERE id='{$id_usuario}'";
    	if($result_update = mysqli_query($mysqli, $sql_update)){
    		
			$insert_admin = "INSERT into log_informacoes(id_user, nome, email, acao, local, data) VALUES('{$_SESSION['id_admin']}', '{$_SESSION['nome_admin']}', '{$_SESSION['usuario_admin']}', 'atualizacao' , 'Usuario {$nome}{$id_usuario}' ,'{$_SESSION['ultimoAcesso_admin']}')  ";
    		if ($mysqli->query($insert_admin) === TRUE){
    			?><script>alert('Usuario atualizado com sucesso');window.location.href = "http://portalastech.chiaperini.com.br/admin/pages/page.php?pagina=usuarios&acao=gerenciar";</script><?php
    		}
    	}
		else{
			?><script>alert('Erro ao atualizar usuario. Verifique sua conexão ou entre em contato com o setor responsável');window.history.go(-1);</script><?php
		}
	}
?>