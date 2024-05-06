<?php 
include('media/core/functions.php');
include('header.php'); 
require('phpmailer/PHPMailerAutoload.php');
require('phpmailer/class.phpmailer.php');
	
$email = $_POST['emailCadastrado'];
$sql_busca = "SELECT * FROM usuarios WHERE email = '{$email}' AND status = '1'";
$result_busca = mysqli_query($mysqli, $sql_busca);	
if($row_busca = mysqli_fetch_assoc($result_busca)){
	$mail = new PHPMailer();
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
    $mail->Subject = 'Recuperar Senha Astech';//Assunto do e-mail
	
	// Define os destinatário(s)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->AddAddress($email, 'Chiaperini Industrial');
	//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
	//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta
	
	// Define os dados técnicos da Mensagem
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
	$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
	
	$url = sprintf( $row_busca['id'].'/'.md5($email).'/'.md5($row_busca['uid']).'/'.md5($row_busca['data_cadastro']));
	
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
											                            	<h3 style="font-family:Arial;font-size:16px;font-weight:normal;"><center>Recupera&ccedil;&atilde;o de Senha Portal Astech Chiaperini Industrial</center></h3><br>
											                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Para fazer uma nova senha clique no link abaixo:</p>
											                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">'.sprintf('http://portalastech.chiaperini.com.br/nova_senha/%s',$url).'<br>
																			
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
		?>
		<div class="geral" style="height:80%;">
			<div class="container">
				<div class="row">
					<div class="col-md-12 titulo_relatorio">
						<h1 class="text-center">Recuperação de Senha</h1>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<h4 class="text-center texto_inicial">
							Um link de renovação de senha foi enviado para o email cadastrado.
						</h4><br>
					</div>
				</div>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>
	<?php
	}
}
else{
	?><script>alert('Email não cadastrado.');window.location.href = "http://portalastech.chiaperini.com.br";</script><?php
}
?>