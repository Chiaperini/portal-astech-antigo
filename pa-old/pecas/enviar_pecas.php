<?php 
include('../media/core/functions.php');
include('../header.php'); 
require('../phpmailer/PHPMailerAutoload.php');
require('../phpmailer/class.phpmailer.php');
/* Carrega a classe DOMPdf */
require_once('../media/core/dompdf/dompdf_config.inc.php');
def("DOMPDF_ENABLE_REMOTE", true);

$date_hora = date('Y-m-d H:m:s');
$perfil = $_SESSION['perfil'];
//pesquisa o usuario
$usuario = $_POST['inputNomeAssistencia'];
$tabela = $perfil."s";
$sql_busca = "SELECT * FROM $tabela WHERE email = '{$_SESSION['usuario_logado']}'";
$result_busca = mysqli_query($mysqli, $sql_busca);	
if($row_busca = mysqli_fetch_assoc($result_busca)){

	$data = $_POST['inputData'];
	$numero_ficha = $_POST['inputNumeroFichaPeca'];
	$cnpj_assistente = $row_busca['CNPJ'];
	
	$sql_cidade_assistente = "SELECT nome FROM cidade WHERE cod_ibge = '{$row_busca['cod_cidade']}' AND estado = '{$row_busca['estado']}'";
	$result_busca_cidade_assistente = mysqli_query($mysqli, $sql_cidade_assistente);	
	if($row_busca_cidade_assistente = mysqli_fetch_assoc($result_busca_cidade_assistente)){
		$cidade_assistente = $row_busca_cidade_assistente['nome'];
	}
	
	$sql_estado_assistente = "SELECT nome FROM estado WHERE id = '{$row_busca['estado']}'";
	$result_busca_estado_assistente = mysqli_query($mysqli, $sql_estado_assistente);	
	if($row_busca_estado_assistente = mysqli_fetch_assoc($result_busca_estado_assistente)){
		$estado_assistente = $row_busca_estado_assistente['nome'];
	}

 	$sql_ficha = "SELECT id_peca from formulario_pecas ORDER by id_peca DESC";
	$result_ficha = mysqli_query($mysqli, $sql_ficha);
	if($row_ficha = mysqli_fetch_assoc($result_ficha)){
    	$numero_ficha = $row_ficha['id_peca'] + 1;
	}
	
	//cadastra no banco as informacoes da RAT
	$sql_i = "INSERT into formulario_pecas 
	(data_insercao, numero_ficha, id_usuario, status) 
	VALUES ('{$date_hora}', '{$numero_ficha}', '{$_SESSION['id_usuario']}','0')";
	if ($mysqli->query($sql_i) === TRUE) { //inserido no banco com sucesso
		
		$id_peca = mysqli_insert_id($mysqli);
					
		$values = Array();
		for($j=0; $j<count( $_POST['descricao'] ); $j++ )
		{
			$sql_pecas = "INSERT into pecas_solicitadas_vendas ( id_usuario, numero_fica, id_peca, cod_equipamento, cod_peca, descricao, quantidade, data ) VALUES ('{$_SESSION['id_usuario']}', '{$numero_ficha}', '{$id_peca}', '{$_POST['codEquipamento'][$j]}', '{$_POST['codPeca'][$j]}', '{$_POST['descricao'][$j]}', '{$_POST['quantidade'][$j]}', '{$data}')";
			if(mysqli_query($mysqli, $sql_pecas)){
				$upload_ok = true;
			}
		}
		
		$dompdf_peca = new DOMPDF();
		$html = '<center><img src="../media/images/astech.png" width="248" height="100"></center><br>
		<font face="Arial"><h3><center>SOLICITA&Ccedil;&Atilde;O DE PE&Ccedil;AS</center></h3>'.'<br>
		<strong>Data:</strong>&nbsp;'.$data.'<br>
		<strong>N&uacute;mero da Ficha:</strong>&nbsp;'.$id_peca.'<br>
		<strong>'.ucfirst($perfil).' Solicitante:</strong>&nbsp;'.$usuario.'<br>
		<strong>Codigo do '.$perfil.':</strong>&nbsp;'.$row_busca['codigo'].'<br>
		<strong>CNPJ do '.$perfil.':</strong>&nbsp;'.$cnpj_assistente.'<br>
		<strong>Email do '.$perfil.':</strong>&nbsp;'.$row_busca['email'].'<br>
		<strong>Telefone do '.$perfil.':</strong>&nbsp;'.$row_busca['ddd'].'-'.$row_busca['telefone'].'<br>
		<strong>Cidade do '.$perfil.'</strong>&nbsp;'.$cidade_assistente.'<br></font>
		<br>
		<table width="100%" style="border: 1px solid black;border-collapse: collapse;">
        	<tbody>
        		<tr style="border: 1px solid #bcbcbc;font-family:Arial;">
            		<th style="border: 1px solid black;font-size:15px;padding:6px 0;"><font face="Arial">DESCRIÇÃO DA PEÇA</font></th>
            		<th style="border: 1px solid black;font-size:15px;padding:6px 0;"><font face="Arial">EQUIPAMENTO</font></th>
            		<th style="border: 1px solid black;font-size:15px;padding:6px 0;"><font face="Arial">CÓDIGO</font></th>
            		<th style="border: 1px solid black;font-size:15px;padding:6px 0;"><font face="Arial">QUANTIDADE</font></th>
            	</tr>
        		';
		
		for( $i=0; $i<count( $_POST['descricao'] ); $i++ ){
			$html .= '
				<tr style="font-family:Arial; border: 1px solid #bcbcbc;padding:6px 0;">
					<td style="font-size:13px;border: 1px solid #bcbcbc;padding:6px 0 6px 6px;">'.$_POST['descricao'][$i].'</td>
					<td style="text-align:center;font-size:13px;border: 1px solid #bcbcbc;padding:6px 0 6px 6px;">'.$_POST['codEquipamento'][$i].'</td>
					<td style="text-align:center;font-size:13px;border: 1px solid #bcbcbc;padding:6px 0;">'.$_POST['codPeca'][$i].'</td>
					<td style="text-align:center;font-size:13px;border: 1px solid #bcbcbc;padding:6px 0;">'.$_POST['quantidade'][$i].'</td>
				</tr>
			';
		}
		$html .='	
	        	</tbody>
	        </table>
	        <br><br>
	        <center><img src="../media/images/chiaperini-industrial.png"></center>
		</font>';
        $dompdf_peca->load_html($html);
		$dompdf_peca->set_paper('A4','portrait');
		$dompdf_peca->render();
		$output = $dompdf_peca->output();
		$arquivopecas_pdf = 'ficha_pecas'.$id_peca.'.pdf';
		file_put_contents("../media/uploads/".$arquivopecas_pdf, $output);
		
	     
	    // Inicia a classe PHPMailer
		$mail = new PHPMailer();
		
		// Define os dados do servidor e tipo de conexão
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->IsSMTP(); // Define que a mensagem será SMTP
		$mail->Host = "162.241.155.7"; 
		$mail->SMTPAuth = true; 
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465; //  Usar 465 porta SMTP
		$mail->Username = 'pecas@portalastech.chiaperini.com.br'; 
		$mail->Password = 'R@chi2018'; 
		
		// Define o remetente
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->SetFrom('pecas@portalastech.chiaperini.com.br', 'Chiaperini - Pedido de Pecas'); //Seu e-mail
	    //$mail->AddReplyTo('amanda@chiaperini.com.br', 'Chiaperini Industrial'); //Seu e-mail
	    $mail->Subject = 'Ficha de Pedido de Pecas '.$id_peca.'';//Assunto do e-mail
		
		// Define os destinatário(s)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$email = 'cido@chiaperini.com.br'; //mudar depois para astecnica
		$mail->AddAddress($email, 'Chiaperini - Pedido de Pecas');
		$mail->AddCC('caroline@chiaperini.com.br', 'Caroline Ribeiro'); // Copia
		$mail->AddCC('jeancarlos@chiaperini.com.br', 'Jean Carlos'); // Copia
		$mail->AddCC('vendas.pecas01@chiaperini.com.br', 'Carolina Pereira'); // Copia
		$mail->AddCC('alinem@chiaperini.com.br', 'Alinne Moreira'); // Copia
		$mail->AddBCC('pedro@chiaperini.com.br', 'Pedro'); // Cópia Oculta
		
		// Define os dados técnicos da Mensagem
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
		$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

		// Define a mensagem (Texto e Assunto)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->Body = '<font face="Arial"><h3><center>Ficha de Pedido de Pe&ccedil;as Chiaperini Industrial</center></h3>'.'<br>
		<strong>Data:</strong>&nbsp;'.$data.'<br>
		<strong>N&uacute;mero da Ficha:</strong>&nbsp;'.$id_peca.'<br>
		<strong>'.ucfirst($perfil).' Solicitante:</strong>&nbsp;'.$usuario.'<br>
		<strong>Codigo do '.$perfil.':</strong>&nbsp;'.$row_busca['codigo'].'<br>
		<strong>CNPJ do '.$perfil.':</strong>&nbsp;'.$cnpj_assistente.'<br>
		<strong>Email do '.$perfil.':</strong>&nbsp;'.$row_busca['email'].'<br>
		<strong>Telefone do '.$perfil.':</strong>&nbsp;'.$row_busca['ddd'].'-'.$row_busca['telefone'].'<br>
		<strong>Cidade do '.$perfil.'</strong>&nbsp;'.$cidade_assistente.'<br>
		<strong>Estado do '.$perfil.'</strong>&nbsp;'.$estado_assistente.'<br></font>';
		
		$mail->AddAttachment($path_file); //adiciona o anexo
		$mail->AddAttachment("../media/uploads/".$arquivopecas_pdf); //adiciona anexo de peças
		// Define os anexos (opcional)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		//$mail->AddAttachment('http://localhost/site_chiaperini/portalastech/'.$dir_nota, 'nota_fiscal.pdf');  // Insere um anexo
		// Envia o e-mail
		$enviado = $mail->Send();
		
		// Limpa os destinatários e os anexos
		//$mail->ClearAllRecipients();
		//$mail->ClearAttachments();
		
		// Exibe uma mensagem de resultado
		if ($enviado) {
			
			$email_usuario = $_SESSION['usuario_logado'];
			$mail_destinatario = new PHPMailer();
			$mail_destinatario->IsSMTP(); 
			$mail_destinatario->Host = "162.241.155.7"; 
			$mail_destinatario->SMTPAuth = true; 
			$mail_destinatario->SMTPSecure = 'ssl';
			$mail_destinatario->Port = 465; //  Usar 465 porta SMTP
			$mail_destinatario->Username = 'pecas@portalastech.chiaperini.com.br'; 
			$mail_destinatario->Password = 'R@chi2018'; 
			$mail_destinatario->SetFrom('pecas@portalastech.chiaperini.com.br', 'Chiaperini'); 
		    $mail_destinatario->Subject = 'Relatorio de Assistencia Tecnica';
			$mail_destinatario->AddAddress($email_usuario,  $_SESSION['nome_usuario']);
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
														                            	<h3 style="font-family:Arial;font-size:16px;font-weight:normal;"><center>Ficha de Pedido de Pe&ccedil;as Chiaperini Industrial</center></h3><br>
														                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Prezado Assistente '.$assistencia.',</p>
														                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Seu pedido de pe&ccedil;as n&uacute;mero <strong>'.$id_peca.'</strong> foi enviado com sucesso!<br>
																						Aguarde o contato da Chiaperini Industrial neste email.</p><br>
														                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Agradecemos a prefer&ecirc;ncia.</p><br>
																					</td>
														                        </tr>
														                        <tr>
														                        	<td align="center" valign="top">
													                            		<a href="https://chiaperini.com.br" style="font-family:Arial;font-size:13px;font-weight:normal;">
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
			$mail_destinatario->AddAttachment("../media/uploads/".$arquivo_pdf); //adiciona o anexo
			$mail_destinatario->AddAttachment("../media/uploads/".$arquivopecas_pdf); //adiciona anexo de peças
			$mail_destinatario->Send();
			
			
			echo '<script>alert("Pedido de Peças enviado com sucesso!");window.location.href="https://portalastech.chiaperini.com.br/pecas/sucesso/"</script>'; 
		}
		else{
			$sql_delete = "DELETE FROM formularios_rat WHERE id_rat = '{$id_rat}'";
			$result_ficha = mysqli_query($mysqli, $sql_delete);
			
			echo '<script>alert("Ocorreu um erro no envio da Ficha, por favor entre em contato através do email chiaperini@chiaperini.com.br!");window.history.go(-1);</script>'; 
			echo $mail_destinatario->ErrorInfo; 
		}
		
	}
	else{
		echo '<script>alert("Ocorreu um erro ao tentar enviar a ficha. Por favor tente mais tarde.");window.history.go(-1);</script>';
	}
}
else{
	echo '<script>alert("Assistente não cadastrado na nossa base de dados.");window.history.go(-1);</script>';
}


?>