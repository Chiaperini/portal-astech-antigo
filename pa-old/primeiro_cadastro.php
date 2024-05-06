<?php 

include_once('media/core/functions.php');
include('header.php'); 
require('phpmailer/PHPMailerAutoload.php');
require('phpmailer/class.phpmailer.php');


$cnpj = preg_replace("/\D+/", "", $_POST['inputCNPJ']);
$perfil = $_POST['selectPerfil'];

//Verifica se já possui login
$busca = "SELECT * FROM usuarios WHERE CNPJ = '{$cnpj}' AND perfil = '{$perfil}'";
$result_busca = mysqli_query($mysqli, $busca);

if($row_busca = mysqli_fetch_assoc($result_busca)){
	print"<script>alert('O perfil $perfil associado a este CNPJ já está cadastrado em outra conta! Para acessar faça login.');window.location.href = 'home';</script>";
}
else{
	//procura o assistente no banco de dados para retornar seus dados
	$tabela = $perfil."s";
	$sql = "SELECT * FROM $tabela WHERE CNPJ = '{$cnpj}'";
	$result = mysqli_query($mysqli, $sql);
	if($row = mysqli_fetch_assoc($result)){
		$nome = $row['nome_empresa'];
		$email = $row['email'];
		
		$buscaEmail = "SELECT * FROM usuarios WHERE email = '{$email}'";
		$result_email = mysqli_query($mysqli, $buscaEmail); 
		if($row_email = mysqli_fetch_assoc($result_email)){
			print"<script>alert('O email $email já está cadastrado em outra conta! Para acessar faça login.');window.location.href = 'index.php';</script>";
		}
		else{
						
			if( isset( $_POST['enviar'] ) ) {
				
				$senha = md5( $_POST['senha'] );
				$ativo = 0;
				$uid = uniqid( rand( ), true );
				
				$sql_i = "INSERT into usuarios (nome, cnpj, email, senha, status, data_cadastro, uid, perfil, data_ultimo_acesso) VALUES ('$nome','$cnpj','$email','$senha','$ativo','$date_insert','$uid','$perfil','$date_insert')";
				if ($mysqli->query($sql_i) === TRUE) {
						
					$id = mysqli_insert_id($mysqli);
					
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
					
					$url = sprintf( $id.'/'.md5($email).'/'.md5($uid).'/'.md5($date_insert));
					
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
																							<p style="font-family:Arial;font-size:12px;font-weight:normal;">*Caso n&atilde;o tenha efetuado o cadastro, entre em contato atrav&eacute;s do email chiaperini@chiaperini.com.br</p><br><br>
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
						echo '<script>alert("Cadastro efetuado com sucesso!");</script>'; 
					}
				} else {
				    echo $mail_destinatario->ErrorInfo; 
				}
			}
		}
	}
	?>
	<div class="geral" style="height:100%;">
			<div class="container">
				<div class="row">
					<div class="col-md-12 titulo_relatorio">
						<h1 class="text-center">Cadastro do <?php echo ucfirst($perfil); ?></h1>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<h4 class="text-center texto_inicial">
							Para confirmar seu cadastro, clique no link enviado para o email <?php echo $email; ?><br>
							Verifique tamb&eacute; na sua caixa de spam.
						</h4><br>
					</div>
				</div>
			</div>
		</div>
		<?php
}
?>
	
	<?php include('footer.php'); ?>
	</div>
</body>
</html>