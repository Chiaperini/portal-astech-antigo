<?php 
include('media/core/functions.php');
include('header.php'); 
require('phpmailer/PHPMailerAutoload.php');
require('phpmailer/class.phpmailer.php');
/* Carrega a classe DOMPdf */
require_once('media/core/dompdf/dompdf_config.inc.php');
def("DOMPDF_ENABLE_REMOTE", true);
 
$date_hora = date('Y-m-d H:m:s');

//pesquisa o usuario
$assistencia = $_POST['inputNomeAssistencia'];
$sql_busca = "SELECT * FROM assistentes WHERE email = '{$_SESSION['usuario_logado']}'";
$result_busca = mysqli_query($mysqli, $sql_busca);	
if($row_busca = mysqli_fetch_assoc($result_busca)){

	$data = $_POST['inputData'];
	$numero_ficha = $_POST['inputNumeroFicha'];
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

	$nome_cliente = htmlentities($_POST['inputNomeCliente'], ENT_QUOTES,'UTF-8');
	$nome_contato = htmlentities($_POST['inputNomeContato'], ENT_QUOTES,'UTF-8');
	$endereco_cliente = htmlentities($_POST['inputEndereco'], ENT_QUOTES,'UTF-8');
	$bairro_cliente = htmlentities($_POST['inputBairro'], ENT_QUOTES,'UTF-8');
	$cidade_cliente = $_POST['inputCidade']; //cod_ibge
	$estado_cliente = $_POST['inputEstado'];
	$cnpj_cliente = preg_replace("/\D+/", "", $_POST['inputCNPJ']);
	$email_cliente = $_POST['inputEmailCliente'];
	$telefone_cliente = $_POST['inputTelefone'];
	$celular_cliente = $_POST['inputCelular'];
	$equipamento = $_POST['inputEquipamento'];
	$defeito_primario = $_POST['inputdefeitoprimario'];
	$numero_serie = $_POST['inputNumeroSerie'];
	$informacoes = htmlentities($_POST['inputInformacoes'], ENT_QUOTES,'UTF-8');
	$km = $_POST['inputKM'];
	$entrada = $_POST['inputEntrada'];
	$saida = $_POST['inputSaida'];	
	$arquivo = $_FILES['InputNotaFiscal'];
	$data_nota = $_POST['InputDataNotaFiscal'];
	
	$sql_cidade = "SELECT * FROM cidade WHERE cod_ibge = '{$cidade_cliente}' AND estado = '{$estado_cliente}'";
	$result_busca_cidade = mysqli_query($mysqli, $sql_cidade);	
	if($row_busca_cidade = mysqli_fetch_assoc($result_busca_cidade)){
		$cidade_cliente_nome = $row_busca_cidade['nome'];
	}
	$sql_estado = "SELECT uf FROM estado WHERE id = '{$estado_cliente}'";
	$result_busca_estado = mysqli_query($mysqli, $sql_estado);	
	if($row_busca_estado = mysqli_fetch_assoc($result_busca_estado)){
		$estado_cliente_uf = $row_busca_estado['uf'];
	}
	$sql_equipamento = "SELECT * FROM equipamentos WHERE codigo = '{$equipamento}'";
	$result_busca_equipamento = mysqli_query($mysqli, $sql_equipamento);	
	if($row_busca_equipamento = mysqli_fetch_assoc($result_busca_equipamento)){
		$equipamento_nome = $row_busca_equipamento['nome'];
	}

	if(($nome_cliente != '') && ($nome_contato != '') && ($endereco_cliente != '') && ($bairro_cliente != '') && ($cidade_cliente != '') && ($estado_cliente != '') && ($cnpj_cliente != '') && ($telefone_cliente != '') && ($equipamento != '') && ($numero_serie != '') && ($informacoes != '') ){
		
		if(isset($_FILES['InputNotaFiscal'])){
		    $new_name = $_FILES['InputNotaFiscal']['name']; //Definindo um novo nome para o arquivo
		    $dir = getcwd().DIRECTORY_SEPARATOR.'/media/uploads/'; //Diretório para uploads
		 	
		 	$path_file = $dir.$new_name;
		 	
		    if(move_uploaded_file($_FILES['InputNotaFiscal']['tmp_name'], $dir.$new_name)){
		    	$dir_nota = $dir.$new_name;
		    	
        	 	$sql_ficha = "SELECT id_rat from formularios_rat ORDER by id_rat DESC";
				$result_ficha = mysqli_query($mysqli, $sql_ficha);
				if($row_ficha = mysqli_fetch_assoc($result_ficha)){
                	$numero_ficha = $row_ficha['id_rat'] + 1;
				}
				
				//cadastra no banco as informacoes da RAT
				$sql_i = "INSERT into formularios_rat 
				(data_insercao, numero_ficha, id_usuario, assistente_solicitante, 
				cnpj_assistente_solicitante, email_assistente, cliente, contato, endereco_cliente, bairro_cliente, cidade, estado, cnpj_cliente, email_cliente, telefone_cliente, celular_cliente, equipamento, cod_equipamento, numero_serie, informacoes_tecnicas, km, entrada, saida, nota_fiscal, data_nota_fiscal, status) 
				VALUES ('{$date_hora}', '{$numero_ficha}', '{$_SESSION['id_usuario']}', '{$assistencia}', 
				'{$row_busca['CNPJ']}', '{$row_busca['email']}', '{$nome_cliente}', '{$nome_contato}', '{$endereco_cliente}', '{$bairro_cliente}', '{$cidade_cliente}', '{$estado_cliente}', '{$cnpj_cliente}', '{$email_cliente}', '{$telefone_cliente}', '{$celular_cliente}', '{$equipamento_nome}', '{$equipamento}', '{$numero_serie}',  '{$informacoes}',  '{$km}',  '{$entrada}',  '{$saida}', '{$dir_nota}', '{$data_nota}', '0')";
				if ($mysqli->query($sql_i) === TRUE) { //inserido no banco com sucesso
					
					$id_rat = mysqli_insert_id($mysqli);
					
					$values = Array();
					for( $i=0; $i<count( $_POST['descricao'] ); $i++ )
					{
						$sql_pecas = "INSERT into pecas_solicitadas ( id_usuario, id_rat, cod_equipamento, cod_peca, descricao, quantidade, data ) VALUES ('{$_SESSION['id_usuario']}', '{$id_rat}', '{$equipamento}', '{$_POST['codPeca'][$i]}', '{$_POST['descricao'][$i]}', '{$_POST['quantidade'][$i]}', '{$data}')";
						if(mysqli_query($mysqli, $sql_pecas)){
							$upload_ok = true;
						}
					}
					
					$dompdf_peca = new DOMPDF();
					$html = '<center><img src="media/images/astech.png" width="248" height="100"></center><br>
					<font face="Arial"><h3><center>SOLICITA&Ccedil;&Atilde;O DE PE&Ccedil;AS</center></h3>'.'<br>
					<strong>Data:</strong>&nbsp;'.$data.'<br>
					<strong>N&uacute;mero da Ficha:</strong>&nbsp;'.$id_rat.'<br>
					<strong>Assistente Solicitante:</strong>&nbsp;'.$assistencia.'<br>
					<strong>CNPJ do assistente:</strong>&nbsp;'.$cnpj_assistente.'<br>
					<strong>Cliente:</strong>&nbsp;'.$nome_cliente.'<br>
					<strong>Equipamento:</strong>&nbsp;'.$equipamento_nome.'<br>
					<br>
					<table width="100%" style="border: 1px solid black;border-collapse: collapse;">
			        	<tbody>
			        		<tr style="border: 1px solid black;">
			            		<th style="border: 1px solid black;font-size:15px;padding:6px 0;"><font face="Arial">DESCRIÇÃO DA PEÇA</font></th>
			            		<th style="border: 1px solid black;font-size:15px;padding:6px 0;"><font face="Arial">CÓDIGO</font></th>
			            		<th style="border: 1px solid black;font-size:15px;padding:6px 0;"><font face="Arial">QUANTIDADE</font></th>
			            	</tr>
			        		';
					
					for( $i=0; $i<count( $_POST['descricao'] ); $i++ ){
						$html .= '
							<tr style="border: 1px solid black;padding:6px 0;">
								<td style="font-size:13px;border: 1px solid black;padding:6px 0 6px 6px;">'.$_POST['descricao'][$i].'</td>
								<td style="text-align:center;font-size:13px;border: 1px solid black;padding:6px 0;">'.$_POST['codPeca'][$i].'</td>
								<td style="text-align:center;font-size:13px;border: 1px solid black;padding:6px 0;">'.$_POST['quantidade'][$i].'</td>
							</tr>
						';
					}
					$html .='	
				        	</tbody>
				        </table>
				        <br><br>
				        <center><img src="media/images/chiaperini-industrial.png"></center>
					</font>';
			        $dompdf_peca->load_html($html);
					$dompdf_peca->set_paper('A4','portrait');
					$dompdf_peca->render();
					$output = $dompdf_peca->output();
					$arquivopecas_pdf = 'ficha_pecas'.$id_rat.'.pdf';
					file_put_contents("media/uploads/".$arquivopecas_pdf, $output);
					file_put_contents("media/uploads/".$arquivo_pdf, $output);
					
					//Faz Upload das Fotos do Produto
					if(isset($_FILES['InputFotosProduto'])){
						
						require ('media/core/WideImage/WideImage.php'); //Inclui classe WideImage à página
						$name 	= $_FILES['InputFotosProduto']['name']; //Atribui uma array com os nomes dos arquivos à variável
					    $tmp_name = $_FILES['InputFotosProduto']['tmp_name']; //Atribui uma array com os nomes temporários dos arquivos à variável
					    $allowedExts = array("gif", "jpg", "jpeg", "png"); //Extensões permitidas
					     
					    // Inicia a classe PHPMailer
						$mail = new PHPMailer();
						$upload_ok = 0;	
					     for($i = 0; $i < count($tmp_name); $i++){ //passa por todos os arquivos
					     
							$ext = pathinfo($name[$i], PATHINFO_EXTENSION);
							$ext = strtolower($ext);
							 
						 	if(in_array($ext, $allowedExts)){ //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas
								$dir4 = '../media/uploads/';
								$datetime = date("Y.m.d-H.i.s");
								$newtime = preg_replace('/[ :-]+/' , '' , $timedate);
							   $new_name2 = $newtime ."-". $i . $ext;
					   
							   if(move_uploaded_file($new_name2, $dir4));
							   //$image = WideImage::load($tmp_name[$i]);
							  // $image->saveToFile($dir.$new_name);
					            $sql_foto = "INSERT into fotos_produto (id_rat, foto) VALUES ('{$id_rat}', '{$dir_foto}') ";
								if ($mysqli->query($sql_foto) === TRUE){
									$upload_ok++;
								}
								else{
									$upload_ok--;
								}
								$mail->AddAttachment($dir_foto);
							} 
							else{
								$sql_delete = "DELETE FROM formularios_rat WHERE id_rat = '{$id_rat}'";
								$result_ficha = mysqli_query($mysqli, $sql_delete);
								echo '<script>alert("As fotos devem estar nos formatos gif, jpg ou png");window.history.go(-1);</script>';
							}
						} 
						if(($upload_ok/count($tmp_name)) == 1){
							
							
							// Define os dados do servidor e tipo de conexão
							// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
							$mail->IsSMTP(); // Define que a mensagem será SMTP
							$mail->Host = "162.241.155.7"; // Endereço do servidor SMTP
							$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
							$mail->SMTPSecure = 'ssl';
							$mail->Port = 465; //  Usar 465 porta SMTP
							$mail->Username = 'rat@portalastech.chiaperini.com.br'; // Usuário do servidor SMTP
							$mail->Password = 'R@chi2018'; // Senha do servidor SMTP
							//$mail->SMTPDebug = 2; //Exibe script de envio
							//$mail->Debugoutput = 'html'; //Exibe script de envio em HTMP
							
							// Define o remetente
							// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
							$mail->SetFrom('rat@portalastech.chiaperini.com.br', 'Chiaperini '); //Seu e-mail
						    //$mail->AddReplyTo('amanda@chiaperini.com.br', 'Chiaperini Industrial'); //Seu e-mail
						    $mail->Subject = 'Relatorio de Assistencia Tecnica Ficha'.$id_rat.'';//Assunto do e-mail
							
							// Define os destinatário(s)
							// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
							$email = 'astecnica@chiaperini.com.br'; //mudar depois para astecnica
							$mail->AddAddress($email, 'Chiaperini');
							//$mail->AddCC('ciclano@site.net', 'Ciclano'); //				
							// Define os dados técnicos da Mensagem
							// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
							$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
							$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

							// Define a mensagem (Texto e Assunto)
							// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
							//$mail->Subject  = "Relatório de Assistência Técnica"; // Assunto da mensagem
							$mail->Body = '<font face="Arial"><h3><center>Relat&oacute;rio de Assist&ecirc;ncia T&eacute;cnica Chiaperini Industrial</center></h3>'.'<br>
							<strong>Data:</strong>&nbsp;'.$data.'<br>
							<strong>N&uacute;mero da Ficha:</strong>&nbsp;'.$id_rat.'<br>
							<strong>C&oacute;digo do Assistente:</strong>&nbsp;'.$row_busca['codigo'].'<br>
							<strong>Assistente Solicitante:</strong>&nbsp;'.$assistencia.'<br>
							<strong>CNPJ do assistente:</strong>&nbsp;'.$cnpj_assistente.'<br>
							<strong>Email do Assistente:</strong>&nbsp;'.$row_busca['email'].'<br>
							<strong>Cidade do Assistente</strong>&nbsp;'.$cidade_assistente.'<br>
							<strong>Estado do Assistente</strong>&nbsp;'.$estado_assistente.'<br>
							<strong>Cliente:</strong>&nbsp;'.$nome_cliente.'<br>
							<strong>Contato:</strong>&nbsp;'.$nome_contato.'<br>
							<strong>Endere&ccedil;o:</strong>&nbsp;'.$endereco_cliente.'<br>
							<strong>Bairro:</strong>&nbsp;'.$bairro_cliente.'<br>
							<strong>Cidade:</strong>&nbsp;'.$cidade_cliente_nome.'<br>
							<strong>Estado:</strong>&nbsp;'.$estado_cliente_uf.'<br>
							<strong>CNPJ/CPF do cliente:</strong>&nbsp;'.$cnpj_cliente.'<br>
							<strong>Email do cliente:</strong>&nbsp;'.$email_cliente.'<br>
							<strong>Telefone:</strong>&nbsp;'.$telefone_cliente.'<br>
							<strong>Celular:</strong>&nbsp;'.$celular_cliente.'<br>
							<strong>Equipamento:</strong>&nbsp;'.$equipamento_nome.' Cód.'.$equipamento.'<br>
							<strong>Defeito Primario:</strong>&nbsp;'.$defeito_primario.'<br>
							<strong>N&uacute;mero de S&eacute;rie:</strong>&nbsp;'.$numero_serie.'<br>
							<strong>Informa&ccedil;&otilde;es T&eacute;cnicas:</strong>&nbsp;'.$informacoes.'<br>
							<strong>Km:</strong>&nbsp;'.$km.'<br>
							<strong>Entrada:</strong>&nbsp;'.$entrada.'<br>
							<strong>Sa&iacute;da:</strong>&nbsp;'.$saida.'<br>
							<strong>Data Nota Fiscal:</strong>&nbsp;'.$data_nota.'<br>
							<strong>Nota Fiscal:</strong>&nbsp; https://portalastech.chiaperini.com.br/'.$dir_nota.'<br></font>';
							
							$dompdf = new DOMPDF();
							$dompdf->load_html('<center><img src="media/images/astech.png" width="248" height="100"></center><br>
							<font face="Arial"><h3><center>Relat&oacute;rio de Assist&ecirc;ncia T&eacute;cnica Chiaperini Industrial</center></h3>'.'<br>
							<strong>Data:</strong>&nbsp;'.$data.'<br>
							<strong>N&uacute;mero da Ficha:</strong>&nbsp;'.$id_rat.'<br>
							<strong>C&oacute;digo do Assistente:</strong>&nbsp;'.$row_busca['codigo'].'<br>
							<strong>Assistente Solicitante:</strong>&nbsp;'.$assistencia.'<br>
							<strong>CNPJ do assistente:</strong>&nbsp;'.$cnpj_assistente.'<br>
							<strong>Email do assistente:</strong>&nbsp;'.$row_busca['email'].'<br>
							<strong>Cidade do Assistente</strong>&nbsp;'.$cidade_assistente.'<br>
							<strong>Cliente:</strong>&nbsp;'.$nome_cliente.'<br>
							<strong>Contato:</strong>&nbsp;'.$nome_contato.'<br>
							<strong>Endere&ccedil;o:</strong>&nbsp;'.$endereco_cliente.'<br>
							<strong>Bairro:</strong>&nbsp;'.$bairro_cliente.'<br>
							<strong>Cidade:</strong>&nbsp;'.$cidade_cliente_nome.'<br>
							<strong>Estado:</strong>&nbsp;'.$estado_cliente_uf.'<br>
							<strong>CNPJ/CPF do cliente:</strong>&nbsp;'.$cnpj_cliente.'<br>
							<strong>Email do cliente:</strong>&nbsp;'.$email_cliente.'<br>
							<strong>Telefone:</strong>&nbsp;'.$telefone_cliente.'<br>
							<strong>Celular:</strong>&nbsp;'.$celular_cliente.'<br>
							<strong>Equipamento:</strong>&nbsp;'.$equipamento_nome.' Cód.'.$equipamento.'<br>
							<strong>Defeito Primario:</strong>&nbsp;'.$defeito_primario.'<br>
							<strong>N&uacute;mero de S&eacute;rie:</strong>&nbsp;'.$numero_serie.'<br>
							<strong>Informa&ccedil;&otilde;es T&eacute;cnicas:</strong>&nbsp;'.utf8_decode($informacoes).'<br>
							<strong>Km:</strong>&nbsp;'.$km.'<br>
							<strong>Entrada:</strong>&nbsp;'.$entrada.'<br>
							<strong>Sa&iacute;da:</strong>&nbsp;'.$saida.'<br>
							<strong>Data Nota Fiscal:</strong>&nbsp;'.$data_nota.'<br>
							<strong>Nota Fiscal:</strong>&nbsp; https://portalastech.chiaperini.com.br/'.$dir_nota.'<br></font>
							<br><br>
							<center><img src="media/images/chiaperini-industrial.png"></center>');
							$dompdf->render();
							$output = $dompdf->output();
							$arquivo_pdf = 'ficha'.$id_rat.'.pdf';

							file_put_contents("media/uploads/".$arquivo_pdf, $output);
							
							$mail->AddAttachment($path_file); //adiciona o anexo
							$mail->AddAttachment("media/uploads/".$arquivo_pdf); //adiciona o anexo
							$mail->AddAttachment("media/uploads/".$arquivopecas_pdf); //adiciona anexo de peças
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
								
								if($email_cliente){
									$mail_cliente = new PHPMailer();
									$mail_cliente->IsSMTP(); 
									$mail_cliente->Host = "162.241.155.7"; 
									$mail_cliente->SMTPAuth = true; 
									$mail_cliente->SMTPSecure = 'ssl';
									$mail_cliente->Port = 465; //  Usar 465 porta SMTP
									$mail_cliente->Username = 'rat@portalastech.chiaperini.com.br'; 
									$mail_cliente->Password = 'R@chi2018'; 
									$mail_cliente->SetFrom('chiaperini@chiaperini.com.br', 'Chiaperini'); 
								    $mail_cliente->Subject = 'Relatorio de Assistencia Tecnica';
									$mail_cliente->AddAddress($email_cliente,  $nome_contato);
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
																			                            	<h3 style="font-family:Arial;font-size:16px;font-weight:normal;"><center>Relat&oacute;rio de Assist&ecirc;ncia T&eacute;cnica Chiaperini Industrial</center></h3><br>
																			                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Prezado Cliente '.$nome_contato.',</p>
																			                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Recebemos do Assistente T&eacute;cnico <b> '.$assistencia.' </b> o Relat&oacute;rio de Assist&ecirc;ncia T&eacute;cnica <b>'.$id_rat.'</b> referente ao seu produto '.$equipamento_nome.'<br>
																			                            	Estamos analisando o pedido e em breve o Assistente entrar&aacute; em contato.</p><br>
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
								$email_usuario = $_SESSION['usuario_logado'];
								$mail_destinatario = new PHPMailer();
								$mail_destinatario->IsSMTP();
								$mail_destinatario->Host = "162.241.155.7"; 
								$mail_destinatario->SMTPAuth = true; 
								$mail_destinatario->SMTPSecure = 'ssl';
								$mail_destinatario->Port = 465; //  Usar 465 porta SMTP
								$mail_destinatario->Username = 'rat@portalastech.chiaperini.com.br'; 
								$mail_destinatario->Password = 'R@chi2018'; 
								$mail_destinatario->SetFrom('chiaperini@chiaperini.com.br', 'Chiaperini'); 
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
																			                            	<h3 style="font-family:Arial;font-size:16px;font-weight:normal;"><center>Relat&oacute;rio de Assist&ecirc;ncia T&eacute;cnica Chiaperini Industrial</center></h3><br>
																			                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Prezado Assistente '.$assistencia.',</p>
																			                            	<p style="font-family:Arial;font-size:13px;font-weight:normal;">Seu relat&oacute;rio n&uacute;mero <strong>'.$id_rat.'</strong> para o cliente <strong>'.utf8_decode($nome_cliente).'</strong> foi enviado com sucesso!<br>
																											Aguarde o contato da Chiaperini Industrial neste email.</p><br>
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
								$mail_destinatario->AddAttachment("media/uploads/".$arquivo_pdf); //adiciona o anexo
								$mail_destinatario->AddAttachment("media/uploads/".$arquivopecas_pdf); //adiciona anexo de peças
								$mail_destinatario->Send();
								
								
								echo '<script>alert("Relatório enviado com sucesso!");window.location.href="https://portalastech.chiaperini.com.br/sucesso/"</script>'; 
							}
							else{
								$sql_delete = "DELETE FROM formularios_rat WHERE id_rat = '{$id_rat}'";
								$result_ficha = mysqli_query($mysqli, $sql_delete);
								
								echo '<script>alert("Ocorreu um erro no envio do Relatório, por favor entre em contato através do email chiaperini@chiaperini.com.br!");window.history.go(-1);</script>';
								echo $mail_destinatario->ErrorInfo; 
							}
							/*
							//envia email
							//ini_set("SMTP","mail.gmail.com");
	
							// Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
							//ini_set("smtp_port","587");
							$email = 'amandathaisalmeida@gmail.com';
							
							// Please specify the return address to use
							ini_set('sendmail_from', 'amanda@chiaperini.com.br');
							
							$headers =  'MIME-Version: 1.0' . "\r\n"; 
							$headers .= 'From: Amanda <amandathaisalmeida@gmail.com>' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
							$mensagem = '<h3><center>Relatório de Assistência Técnica Chiaperini Industrial</center></h3>'."<br>";
							$mensagem .= '<strong>Data:</strong>&nbsp;'.$data.'<br>';
							$mensagem .= '<strong>Número da Ficha:</strong>&nbsp;'.$numero_ficha.'<br>';
							$mensagem .= '<strong>C&oacute;digo do Assistente:</strong>&nbsp;'.$row_busca['codigo'].'<br>;
							$mensagem .= '<strong>Assistente Solicitante:</strong>&nbsp;'.$assistencia.'<br>';
							$mensagem .= '<strong>CNPJ do assistente:</strong>&nbsp;'.$row_busca['cnpj'].'<br>';
							$mensagem .= '<strong>Cliente:</strong>&nbsp;'.$nome_cliente.'<br>';
							$mensagem .= '<strong>Contato:</strong>&nbsp;'.$nome_contato.'<br>';
							$mensagem .= '<strong>Endereço:</strong>&nbsp;'.$endereco_cliente.'<br>';
							$mensagem .= '<strong>Bairro:</strong>&nbsp;'.$bairro_cliente.'<br>';
							$mensagem .= '<strong>Cidade:</strong>&nbsp;'.$row_busca_cidade['nome'].'<br>';
							$mensagem .= '<strong>Estado:</strong>&nbsp;'.$row_busca_estado['uf'].'<br>';
							$mensagem .= '<strong>CNPJ do cliente:</strong>&nbsp;'.$cnpj_cliente.'<br>';
							$mensagem .= '<strong>Telefone:</strong>&nbsp;'.$telefone_cliente.'<br>';
							$mensagem .= '<strong>Celular:</strong>&nbsp;'.$celular_cliente.'<br>';
							$mensagem .= '<strong>Equipamento:</strong>&nbsp;'.$equipamento.'<br>';
							$mensagem .= '<strong>Número de Série:</strong>&nbsp;'.$numero_serie.'<br>';
							$mensagem .= '<strong>Informações Técnicas:</strong>&nbsp;'.$informacoes.'<br>';
							$mensagem .= '<strong>Km:</strong>&nbsp;'.$km.'<br>';
							$mensagem .= '<strong>Entrada:</strong>&nbsp;'.$entrada.'<br>';
							$mensagem .= '<strong>Saída:</strong>&nbsp;'.$saida.'<br>';
							$mensagem .= '<strong>Nota Fiscal:</strong>&nbsp; http://localhost/site_chiaperini/portalastech/'.$dir_nota.'<br>';
							
					        // enviar o email
					        $emailsender = 'amanda@chiaperini.com.br';
					        $envia =  mail( $email, 'Relatório de Assistência Técnica', $mensagem, $headers, "-f".$emailsender);
							if($envia){
								echo '<script>alert("Relatório enviado com sucesso!");</script>'; 
								header("Location:sucesso.php"); 
							}
							else{
								echo '<script>alert("Relatório não foi enviado!");window.history.go(-1);</script>'; 
							}	
							*/
						}
						else{
							$sql_delete = "DELETE FROM formularios_rat WHERE id_rat = '{$id_rat}'";
							$result_ficha = mysqli_query($mysqli, $sql_delete);
							echo '<script>alert("Erro ao fazer upload da Foto do produto");window.history.go(-1);</script>';
						}
					}
					else{ //erro ao subir aquivo de nota fiscal
						echo '<script>alert("É obrigatório o envio das fotos do produto");window.history.go(-1);</script>';
					}
				}
				else{
					echo '<script>alert("Erro ao fazer upload da Foto do produto. Por favor seguir as instruções. Caso o erro persista envie um e-mail com os arquivos para chiaperini@chiaperini.com.br");window.history.go(-1);</script>';
				}
		    } 
			else{ //erro ao subir aquivo de nota fiscal
				echo '<script>alert("Erro ao fazer upload da Nota Fiscal");window.history.go(-1);</script>';
			}
		}
		else{
			echo '<script>alert("É obrigatório o envio da Nota Fiscal");window.history.go(-1);</script>';
		}
	}
	else{
		echo '<script>alert("Item obrigatório não enviado");window.history.go(-1);</script>';
	}
}
else{
	echo '<script>alert("Assistente não cadastrado na nossa base de dados.");window.history.go(-1);</script>';
}


?>