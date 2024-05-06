<?php 
include('header.php'); 
require('phpmailer/PHPMailerAutoload.php');
require('phpmailer/class.phpmailer.php');

// Dados vindos pela url
$id = $_GET['id'];
$emailMd5 = $_GET['email'];
$uidMd5 = $_GET['uid'];
$dataMd5 = $_GET['key'];

//Buscar os dados no banco
$sql = "SELECT * FROM usuarios WHERE id = '{$id}'";
$result = mysqli_query($mysqli, $sql);
if($row = mysqli_fetch_assoc($result)){
	// Comparar os dados que pegamos no banco, com os dados vindos pela url
	$valido = true;
	
	if( $emailMd5 !== md5( $row['email'] ) )
	    $valido = false;
	
	if( $uidMd5 !== md5( $row['uid'] ) )
	    $valido = false;
	
	if( $dataMd5 !== md5( $row['data_cadastro'] ) )
	    $valido = false;
	
	// Os dados estão corretos, hora de ativar o cadastro
	if( $valido === true ) {
		
	    $sql_update = "UPDATE usuarios SET status='1' WHERE id='$id'";
	    $result_update = mysqli_query($mysqli, $sql_update);
		
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
		
		$mail->Body =
		'<html xmlns="http://www.w3.org/1999/xhtml">
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
												                            	<h3 style="font-family:Arial;font-size:16px;font-weight:normal;"><center>Seu cadastro foi confirmado com sucesso!</center></h3><br>
												                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Parabéns, agora você já pode usufruir de toda facilidade do Portal do Assistente.</p><br>
												                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;"><strong>Seu login é</strong>: '.$row['email'].'<br>
												                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;"><strong>Senha</strong>: escolhida no cadastro</p><br><br>
																				<p style="font-family:Arial;font-size:12px;font-weight:normal;">Acesse nosso site: <a href="http://chiaperini.com.br" target="_blank">http://chiaperini.com.br</a></p><br><br>
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

        ?>
		<div class="container">
			<div class="row">
				<div class="col-md-12 titulo_relatorio">
					<h1 class="text-center">Cadastro confirmado com sucesso!</h1>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<h4 class="text-center texto_inicial">
						Agora você já possui seu cadastro no Portal do Assistente Chiaperini.<br>
						Para acessar o portal faça login na sua conta com o email e a senha escolhida no cadastro.
					</h4><br>
				</div>
			</div>
		</div>
		<div class="container" style="padding:30px 0px 60px 0px;">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<h4 class="text-center texto_inicial">
						<a href="<?php echo $url_atual;?>" class="btn btn-warning" target="_self">Logar no Sistema</a>
					</h4><br>
				</div>
			</div>
		</div>
		<?php
	} else {
		?>
		<div class="container container-maior">
			<div class="row">
				<div class="col-md-12 titulo_relatorio">
					<h1 class="text-center">Cadastro não confirmado!</h1>
				</div>
			</div>
		</div>
		<div class="container container-meio">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<h4 class="text-center texto_inicial">
						As informações não condizem com seus dados cadastrados em nossa base.<br>
						Por favor entre em contato com a nossa central de atendimento através do email portalastech@chiaperini.com.br
					</h4><br>
				</div>
			</div>
		</div>
		<?php
	}
}
?>
	<?php include('footer.php'); ?>
	</div>
</div>
</body>
</html>