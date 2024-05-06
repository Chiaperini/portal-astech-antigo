<?php
	session_start();
	include('../media/core/conexao.php');
	date_default_timezone_set('America/Sao_Paulo');
	$date_hora = date('d/m/Y H:m:s');
	$date = date('Y-m-d');
	$pagina = $_GET['pagina'];

/* ---------------- USUÁRIOS ------------------ */
if($pagina == 'usuarios'){
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$perfil = $_POST['perfil'];
	$senha = md5($_POST['senha']);
	
	$insert_usuario = "INSERT into usuarios_admin(nome, email, senha, perfil, data_cadastro) VALUES('{$nome}', '{$email}', '{$senha}', '{$perfil}', '{$date_hora}')";
	if ($mysqli->query($insert_usuario) === TRUE){
    	
		?><script>alert('Usuário inserido com sucesso');window.location.href = "http://portalastech.chiaperini.com.br/admin/pages/index.php";</script><?php
	}
	else{
		?><script>alert('Erro ao inserir usuário.');window.history.go(-1);</script><?php
	}
}
/* ---------- ASSISTENTES -------------- */
if($pagina == 'assistentes'){
	$nome_empresa = utf8_encode($_POST['input_nome_empresa']);
	$codigo = $_POST['input_codigo_assistente'];
	$cnpj = preg_replace("/\D+/", "", $_POST['input_cnpj']);
	$email = $_POST['input_email'];
	$nome_fantasia = utf8_encode($_POST['input_nome_fantasia']);
	$endereco = utf8_encode($_POST['input_endereco']);
	$complemento = utf8_encode($_POST['input_complemento']);
	$bairro = utf8_encode($_POST['input_bairro']);
	$cidade = $_POST['select_cidade'];
	$estado = $_POST['select_estado'];
	$cep = $_POST['input_cep'];
	$ddd = preg_replace("/\(|\)/", "", $_POST['input_ddd']);
	$telefone = $_POST['input_telefone'];
	$inscricao_estadual = $_POST['input_inscricao_estadual'];
	
	$busca_cnpj = "SELECT * FROM assistentes WHERE CNPJ = '{$cnpj}'";
	$result_cnpj = mysqli_query($mysqli, $busca_cnpj);
	$row_cnpj = mysqli_num_rows($result_cnpj);
	if($row_cnpj != '0'){
		$erro = 1;
		?><script>alert('CNPJ já cadastrado no nosso sistema');window.history.go(-1);</script><?php
		
	}
	$busca_email = "SELECT * FROM assistentes WHERE email = '{$email}'";
	$result_email = mysqli_query($mysqli, $busca_email);
	$row_email = mysqli_num_rows($result_email);
	if($row_email != '0'){
		$erro = 1;
		?><script>alert('Email já cadastrado no nosso sistema');window.history.go(-1);</script><?php
	}
	if($erro == 0){
		$insert_assistente = "INSERT into assistentes(codigo, nome_empresa, CNPJ, email, nome_fantasia, endereco, complemento, bairro, cep, cod_cidade,
		estado, ddd, telefone, inscricao_estadual, status, data_insercao) VALUES('{$codigo}','{$nome_empresa}', '{$cnpj}', '{$email}', '{$nome_fantasia}' , '{$endereco}' ,'{$complemento}',
		'{$bairro}', '{$cep}', '{$cidade}', '{$estado}', '{$ddd}', '{$telefone}', '{$inscricao_estadual}', '1', '{$date}')  ";
		if ($mysqli->query($insert_assistente) === TRUE){
				
			$insert_log = "INSERT into log_informacoes(id_user, nome, email, acao, local, data) VALUES('{$_SESSION['id_admin']}', '{$_SESSION['nome_admin']}', '{$_SESSION['usuario_admin']}', 'insercao' , 'Assistente {$nome_empresa}{$id_assistente}' ,'{$_SESSION['ultimoAcesso_admin']}')  ";
	    	$mysqli->query($insert_log);
	    	
			?><script>alert('Assistente inserido com sucesso');window.location.href = "http://portalastech.chiaperini.com.br/admin/pages/assistentes.php?acao=gerenciar";</script><?php
		}
		else{
			?><script>alert('Erro ao atualizar assistente. Verifique sua conexão ou entre em contato com o setor responsável');window.history.go(-1);</script><?php
		}
	}
}
?>