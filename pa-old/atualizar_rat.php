<?php
include_once('media/core/functions.php');
require('phpmailer/PHPMailerAutoload.php');
require('phpmailer/class.phpmailer.php');
date_default_timezone_set('America/Sao_Paulo');

$date_hora = date('d/m/Y H:i:s', time());
$numero_ficha = $_REQUEST['inputNumeroFicha'];

$cidade_cliente = $_POST['inputCidade'];
$estado_cliente = $_POST['inputEstado'];

if(usuarioestalogado()){	
	include('header.php');
	
	$sql_update = "UPDATE formularios_rat SET status = '1', data_conclusao = '{$date_hora}' WHERE numero_ficha ='{$numero_ficha}' ";
	if($result_update = mysqli_query($mysqli, $sql_update)){
		
		$busca_form = "SELECT * FROM formularios_rat WHERE numero_ficha = '{$numero_ficha}'";
		$result_form = mysqli_query($mysqli, $busca_form);
		if($row_form = mysqli_fetch_assoc($result_form)){
	        
			$email_assistente = $row_form['email_assistente'];
			$email_cliente = $row_form['email_cliente'];	
				
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
		    $mail->Subject = 'Fechamento Ficha de Garantia Portal Astech '.$numero_ficha.'';//Assunto do e-mail
			
			// Define os destinatário(s)
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$email = 'amanda@chiaperini.com.br'; //mudar depois para email da Claudia
			$mail->AddAddress($email, 'Chiaperini Industrial');
			//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
			$mail->AddBCC('amanda@chiaperini.com.br', 'Chiaperini Industrial'); // Cópia Oculta
			
			// Define os dados técnicos da Mensagem
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
			$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
	
			// Define a mensagem (Texto e Assunto)
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			//$mail->Subject  = "Relatório de Assistência Técnica"; // Assunto da mensagem
			$mail->Body = '<font face="Arial"><h3><center>Finaliza&ccedil;&atilde;o Ficha de Garantia Portal Astech</center></h3>'.'<br>
			<strong>Data da ficha:</strong>&nbsp;'.$row_form['data_insercao'].'<br>
			<strong>N&uacute;mero da Ficha:</strong>&nbsp;'.$numero_ficha.'<br>
			<strong>Assistente Solicitante:</strong>&nbsp;'.$row_form['assistente_solicitante'].'<br>
			<strong>CNPJ do assistente:</strong>&nbsp;'.$row_form['cnpj_assistente_solicitante'].'<br>
			<strong>Email do Assistente:</strong>&nbsp;'.$row_form['email_assistente'].'<br>
			<strong>Cliente:</strong>&nbsp;'.$row_form['cliente'].'<br>
			<strong>Contato:</strong>&nbsp;'.$row_form['contato'].'<br>
			<strong>Endere&ccedil;o:</strong>&nbsp;'.$row_form['endereco_cliente'].'<br>
			<strong>Bairro:</strong>&nbsp;'.$row_form['bairro_cliente'].'<br>
			<strong>Cidade:</strong>&nbsp;'.$cidade_cliente.'<br>
			<strong>Estado:</strong>&nbsp;'.$estado_cliente.'<br>
			<strong>CNPJ/CPF do cliente:</strong>&nbsp;'.$row_form['cnpj_cliente'].'<br>
			<strong>Email do cliente:</strong>&nbsp;'.$row_form['email_cliente'].'<br>
			<strong>Telefone:</strong>&nbsp;'.$row_form['telefone_cliente'].'<br>
			<strong>Celular:</strong>&nbsp;'.$row_form['celular_cliente'].'<br>
			<strong>Equipamento:</strong>&nbsp;'.$row_form['equipamento'].'<br>
			<strong>N&uacute;mero de S&eacute;rie:</strong>&nbsp;'.$row_form['numero_serie'].'<br>
			<strong>Informa&ccedil;&otilde;es T&eacute;cnicas:</strong>&nbsp;'.$row_form['informacoes_tecnicas'].'<br>
			<strong>Km:</strong>&nbsp;'.$row_form['km'].'<br>
			<strong>Entrada:</strong>&nbsp;'.$row_form['entrada'].'<br>
			<strong>Sa&iacute;da:</strong>&nbsp;'.$row_form['saida'].'<br>
			<strong>Data Nota Fiscal:</strong>&nbsp;'.$row_form['data_nota_fiscal'].'<br>
			<strong>Data Finaliza&ccedil;&atilde;o da Ficha:</strong>&nbsp;'.$row_form['data_conclusao'].'<br></font>';
			
			$enviado = $mail->Send();
			
			if($enviado){
				
				if($email_cliente){
					$mail_cliente = new PHPMailer();
					$mail_cliente->IsSMTP(); 
					$mail_cliente->Host = "162.241.155.7"; 
					$mail_cliente->SMTPAuth = true; 
					$mail_cliente->SMTPSecure = 'ssl';
					$mail_cliente->Port = 465; //  Usar 465 porta SMTP
					$mail_cliente->Username = 'chiaperini@chiaperini.com.br'; 
					$mail_cliente->Password = 'Ch!@#IoM'; 
					$mail_cliente->SetFrom('chiaperini@chiaperini.com.br', 'Chiaperini Industrial'); 
				    $mail_cliente->Subject = 'Fechamento Ficha de Garantia Portal Astech';
					$mail_cliente->AddAddress($email_cliente,  $row_form['cliente']);
					$mail_cliente->IsHTML(true); // Define que o e-mail será enviado como HTML
					$mail_cliente->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
					$mail_cliente->Body = '
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
															 							<img align="center" alt="Portal ASTECH" src="https://portalastech.chiaperini.com.br/media/images/astech.png" width="218" style="max-width:218;padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;min-height:auto;outline:none;text-decoration:none">
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
															                            	<h3 style="font-family:Arial;font-size:16px;font-weight:normal;"><center>Finaliza&ccedil;&atilde;o de Ficha Assist&ecirc;ncia T&eacute;cnica Chiaperini Industrial</center></h3><br>
															                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Prezado Cliente '.$nome_contato.',</p>
															                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Recebemos do Assistente T&eacute;cnico '.$assistencia.' a Finaliza&ccedil;&atilde;o do Relat&oacute;rio de Assist&ecirc;ncia T&eacute;cnica referente ao seu produto '.$row_form['equipamento'].'<br>
															                            	Caso tenha alguma d&uacute;vida ou alguma inconformidade por favor entre em contato conosco atrav&eacute;s do e-mail astecnica@chiaperini.com.br ou através do telefone (16) 3954 9400.</p><br>
															                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Agradecemos a prefer&ecirc;ncia.</p><br>
															                            </td>
															                        </tr>
															                        <tr>
															                        	<td align="center" valign="top">
														                            		<a href="http://chiaperini.com.br" style="font-family:Arial;font-size:13px;font-weight:normal;">
														                            			<img src="https://portalastech.chiaperini.com.br/media/images/chiaperini-industrial.png"/>
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
					$mail_cliente->Send();
				}
				$mail_destinatario = new PHPMailer();
				$mail_destinatario->IsSMTP(); 
				$mail_destinatario->Host = "162.241.155.7"; 
				$mail_destinatario->SMTPAuth = true; 
				$mail_destinatario->SMTPSecure = 'ssl';
				$mail_destinatario->Port = 465; //  Usar 465 porta SMTP
				$mail_destinatario->Username = 'chiaperini@chiaperini.com.br'; 
				$mail_destinatario->Password = 'Ch!@#IoM'; 
				$mail_destinatario->SetFrom('chiaperini@chiaperini.com.br', 'Chiaperini Industrial'); 
			    $mail_destinatario->Subject = 'Fechamento Ficha de Garantia Portal Astech';
				$mail_destinatario->AddAddress($email_assistente,  $row_form['assistente_solicitante']);
				$mail_destinatario->IsHTML(true); // Define que o e-mail será enviado como HTML
				$mail_destinatario->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
				$mail_destinatario->Body = '
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
															 							<img align="center" alt="Portal ASTECH" src="https://portalastech.chiaperini.com.br/media/images/astech.png" width="218" style="max-width:218;padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;min-height:auto;outline:none;text-decoration:none">
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
															                            	<h3 style="font-family:Arial;font-size:16px;font-weight:normal;"><center>FInaliza&ccedil;&atilde;o Ficha Assist&ecirc;ncia T&eacute;cnica Chiaperini Industrial</center></h3><br>
															                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Prezado Assistente '.$assistencia.',</p>
															                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Seu relat&oacute;rio n&uacute;mero <strong>'.$numero_ficha.'</strong> para o cliente <strong>'.utf8_decode($row_form['cliente']).'</strong> foi finalizado com sucesso!<br>
															                            	<br>
																							Caso tenha alguma d&uacute;vida ou alguma inconformidade por favor entre em contato conosco atrav&eacute;s do e-mail astecnica@chiaperini.com.br ou através do telefone (16) 3954 9400.</p><br>
															                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Agradecemos a prefer&ecirc;ncia.</p><br>
																						</td>
															                        </tr>
															                        <tr>
															                        	<td align="center" valign="top">
														                            		<a href="http://chiaperini.com.br" style="font-family:Arial;font-size:13px;font-weight:normal;">
														                            			<img src="https://portalastech.chiaperini.com.br/media/images/chiaperini-industrial.png"/>
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
				$mail_destinatario->Send();
				echo '<script>alert("Finalização de ficha recebida com sucesso!");window.location.href="https://portalastech.chiaperini.com.br/meus_formularios/"</script>';	
			}
			else{
				echo '<script>alert("Sua ficha foi finalizada mas ocorreu um erro ao tentar enviar o e-mail de confirmação de finalização. Qualquer dúvida entre em contato conosco através do e-mail chiaperini@chiaperini.com.br");window.location.href="https://portalastech.chiaperini.com.br/meus_formularios/";</script>' ;
			}
		}
	}
	else{
		echo '<script>alert("Ocorreu um erro ao tentar enviar a ficha. Por favor tente mais tarde.");window.location.href="https://portalastech.chiaperini.com.br/meus_formularios/</script>';
	}
}
?>
