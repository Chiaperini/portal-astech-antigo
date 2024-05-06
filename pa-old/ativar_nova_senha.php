<?php 
include('media/core/functions.php');
include('header.php'); 
require('phpmailer/PHPMailerAutoload.php');
require('phpmailer/class.phpmailer.php');

	$nova_senha = $_POST['inputNovaSenha'];
	$confirma_senha = $_POST['inputConfirmaSenha'];
	
	if($nova_senha === $confirma_senha){
		if(atualizaSenha($nova_senha, $confirma_senha)){
			?><script>alert('Nova Senha alterada com sucesso!');</script><?php
			session_destroy();
		   ?><script>window.location.href = "https://portalastech.chiaperini.com.br";</script><?php
		}
		else{
			?><script>alert('Erro ao cadastrar nova senha. Por favor entre em contato através do email astecnica@chiaperini.com.br');window.location.href = "http://portalastech.chiaperini.com.br";</script><?php
		}
	}
	else{
		?><script>alert('A nova senha e a confirmação de senha estão diferentes');window.history.back();</script><?php
	}
?>