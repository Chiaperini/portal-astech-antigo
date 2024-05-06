<?php
session_start();
require('../media/phpmailer/PHPMailerAutoload.php');
require('../media/phpmailer/class.phpmailer.php');
date_default_timezone_set('America/Sao_Paulo');
include('../media/core/conexao.php');

$cnpj = preg_replace("/\D+/", "", $_POST['input_cnpj']);

	$id_usuario = $_POST['input_id'];
	$nome = utf8_encode($_POST['input_nome']);
	$email = $_POST['input_email'];
	$status = $_POST['select_status'];

	$busca_usuario = "SELECT * FROM usuarios WHERE id = '$id_usuario'";
	$result_usuario = mysqli_query($mysqli, $busca_usuario);
	if($row_usuario = mysqli_fetch_assoc($result_usuario)){
		        		        		
		$mail = new PHPMailer();
		// Define os dados do servidor e tipo de conexão
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->IsSMTP(); // Define que a mensagem será SMTP
		$mail->Host = "162.241.155.7"; 
		$mail->SMTPAuth = true; 
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465; //  Usar 465 porta SMTP
		$mail->Username = 'chiaperini@chiaperini.com.br'; 
		$mail->Password = 'Ch!@#IoM'; 
		
		// Define o remetente
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->SetFrom('chiaperini@chiaperini.com.br', 'Chiaperini Industrial'); //Seu e-mail
	    //$mail->AddReplyTo('amanda@chiaperini.com.br', 'Chiaperini Industrial'); //Seu e-mail
	    $mail->Subject = 'Portal Assistente Tecnico Chiaperini';//Assunto do e-mail
		
		// Define os destinatário(s)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->AddAddress($email, $nome);
		//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
		//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta
		
		// Define os dados técnicos da Mensagem
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
		$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
		
		$url = sprintf( $id_usuario.'/'.md5($email).'/'.md5($row_usuario['uid']).'/'.md5($row_usuario['data_cadastro']));
		
		// Define a mensagem (Texto e Assunto)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		//$mail->Subject  = "Relatório de Assistência Técnica"; // Assunto da mensagem
		$mail->Body = '
		<html xmlns="http://www.w3.org/1999/xhtml">
		    <head>
		    	<title>ASTECH - Chiaperini Industrial</title>
		    </head>
		    
		    <body>
		    	<div style="min-height:100%;margin:0;padding:0;width:100%;background-color:#ffffff">
		    		<center>
		    			<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="border-collapse:collapse;height:100%;margin:0;padding:0;width:100%;background-color:#ffffff">
		    				 <tbody><tr>
		    				 	<td align="center" valign="top" style="height:100%;margin:0;padding:10px;width:100%;border-top:0">
		    				 		<table border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse:collapse;border:0;max-width:600px!important;">
		    				 			 <tbody>
		    				 			 <tr>
		                                 	<td valign="top" style="background-color:#fff;border-top:0;border-bottom:0;padding-top:0px;padding-bottom:0">
		                                 		<!-- Inicia o corpo do Email -->
		                                 		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse">
		    				 			 			<tbody>
											            <tr>
											                <td valign="top" style="padding:0px;">
											                    <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="min-width:100%;border-collapse:collapse">
											                        <tbody><tr>
											                            <td valign="top" style="padding-right:0px;padding-left:0px;padding-top:15;padding-bottom:15;text-align:center">
												 							<img align="center" alt="Portal ASTECH" src="http://portalastech.chiaperini.com.br/media/images/astech.png" width="218" style="max-width:218;padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;min-height:auto;outline:none;text-decoration:none">
											                            </td>
											                        </tr>
											                    </tbody></table>
											                </td>
											            </tr>
											    	</tbody>
										    	</table>
										    	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse;">
		    				 			 			<tbody>
											            <tr>
											                <td valign="top" style="padding:0px;">
											                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="min-width:100%;border-collapse:collapse">
											                        <tbody>
											                        	<tr>
												                            <td valign="top" align="left" style="padding-right:0px;padding-left:20px;padding-top:10;padding-bottom:10;text-align:left;">
												                            	<h3 style="font-family:Arial;font-size:16px;font-weight:normal;"><center>Cadastro Assistente Portal Astech Chiaperini Industrial</center></h3><br>
												                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Para confirmar seu cadastro acesse o link abaixo:</p>
												                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">'.sprintf('http://portalastech.chiaperini.com.br/ativar/%s',$url).'<br><br>
																				<p style="font-family:Arial;font-size:12px;font-weight:normal;">*Caso não tenha efetuado o cadastro, entre em contato através do email chiaperini@chiaperini.com.br</p><br><br>
																			</td>
												                        </tr>
												                        <tr>
												                        	<td align="center" valign="top">
											                            		<a href="http://chiaperini.com.br" style="font-family:Arial;font-size:13px;font-weight:normal;">
											                            			<img src="http://portalastech.chiaperini.com.br/media/images/chiaperini-industrial.png"/>
											                            		</a>
												                        	</td>
												                        </tr>
											                        </tbody>
											                    </table>
											                </td>
											             </tr>
											          </tbody>
											     </table>
											     
											     
		    				 			 	</td>
		    				 			 </tr>
		    				 			 </tbody>
		    				 		</table>
		    				 	</td>
		    				 </tr></tbody>
		    			</table>
		    		</center>
		    	</div>
		  
		    </body>
		</html>
		';
	
	    // enviar o email
	    $enviado = $mail->Send();
		if($enviado){
			echo '<script>alert("Email enviado com sucesso!");window.location.href = "http://portalastech.chiaperini.com.br/admin/pages/usuarios.php?acao=gerenciar";</script>'; 
		}
		else {
	    	echo '<script>alert("Erro ao enviar Email");window.history.back();</script>'; 
		}
	}
?>