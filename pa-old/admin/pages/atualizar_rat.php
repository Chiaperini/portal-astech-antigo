<?php 
include('header.php'); 
	
require('../media/phpmailer/PHPMailerAutoload.php');
require('../media/phpmailer/class.phpmailer.php');
/* Carrega a classe DOMPdf */
require_once('../media/core/dompdf/dompdf_config.inc.php');
def("DOMPDF_ENABLE_REMOTE", true);


$assistencia = $_POST['inputNomeAssistencia'];

$sql_busca = "SELECT * FROM assistentes WHERE nome_fantasia = '{$assistencia}'";
$result_busca = mysqli_query($mysqli, $sql_busca);	
if($row_busca = mysqli_fetch_assoc($result_busca)){
	$cnpj_assistente = $row_busca['CNPJ'];
}
$id = $_POST['inputNumeroFicha'];
$id_usuario = $_POST['inputIDUsuario'];
$data = $_POST['inputData'];
$numero_ficha = $_POST['inputNumeroFicha'];
$nome_cliente = htmlentities($_POST['inputNomeCliente'], ENT_QUOTES,'UTF-8');
$nome_contato = htmlentities($_POST['inputNomeContato'], ENT_QUOTES,'UTF-8');
$endereco_cliente = htmlentities($_POST['inputEndereco'], ENT_QUOTES,'UTF-8');
$bairro_cliente = htmlentities($_POST['inputBairro'], ENT_QUOTES,'UTF-8');
$cidade_cliente = $_POST['select_cidade'];
$estado_cliente = $_POST['select_estado'];
$cnpj_cliente = preg_replace("/\D+/", "", $_POST['inputCNPJ']);
$email_cliente = $_POST['inputEmailCliente'];
$telefone_cliente = $_POST['inputTelefone'];
$celular_cliente = $_POST['inputCelular'];
$equipamento = $_POST['inputEquipamento'];
$numero_serie = $_POST['inputNumeroSerie'];
$informacoes = $_POST['inputInformacoes'];
$km = $_POST['inputKM'];
$entrada = $_POST['inputEntrada'];
$saida = $_POST['inputSaida'];	
$data_nota = $_POST['InputDataNotaFiscal'];

$registros = $_POST['totalRegistros'];
$total_registros = ($_POST['totalRegistros']) - 1;

$sql_cidade = "SELECT * FROM cidade WHERE id = '{$cidade_cliente}'";
$result_busca_cidade = mysqli_query($mysqli, $sql_cidade);	
if($row_busca_cidade = mysqli_fetch_assoc($result_busca_cidade)){
	$nome_cidade_cliente = $row_busca_cidade['nome'];
}
$sql_estado = "SELECT uf FROM estado WHERE id = '{$estado_cliente}'";
$result_busca_estado = mysqli_query($mysqli, $sql_estado);	
if($row_busca_estado = mysqli_fetch_assoc($result_busca_estado)){
	$nome_estado_cliente = $row_busca_estado['uf'];
}
$sql_equipamento = "SELECT * FROM equipamentos WHERE codigo = '{$equipamento}'";
	$result_busca_equipamento = mysqli_query($mysqli, $sql_equipamento);	
	if($row_busca_equipamento = mysqli_fetch_assoc($result_busca_equipamento)){
		$nome_equipamento = $row_busca_equipamento['nome'];
	}
	
if(($nome_cliente != '') && ($nome_contato != '') && ($endereco_cliente != '') && ($bairro_cliente != '') && ($cidade_cliente != '') && ($estado_cliente != '') && ($cnpj_cliente != '') && ($telefone_cliente != '') && ($equipamento != '') && ($numero_serie != '') && ($informacoes != '') ){
		
	$busca_equipamento = "SELECT * FROM equipamentos WHERE codigo = '{$equipamento}'";
	$result_equipamento = mysqli_query($mysqli, $busca_equipamento);	
	if($row_equipamento = mysqli_fetch_assoc($result_equipamento)){
		$nome_equipamento = $row_equipamento['nome'];
	}
	else{
		echo '<script>alert("Equipamento não encontrado.")</script>;window.history.go(-1);';
	}
	
	$sql_update = "UPDATE formularios_rat SET
	cliente = '{$nome_cliente}', contato = '{$nome_contato}', endereco_cliente = '{$endereco_cliente}', bairro_cliente = '{$bairro_cliente}', 
	cidade = '{$cidade_cliente}', estado = '{$estado_cliente}', cnpj_cliente = '{$cnpj_cliente}', email_cliente = '{$email_cliente}', telefone_cliente = '{$telefone_cliente}',
	celular_cliente = '{$celular_cliente}', equipamento = '{$nome_equipamento}', cod_equipamento = '{$equipamento}', numero_serie = '{$numero_serie}',
	informacoes_tecnicas = '{$informacoes}', km = '{$km}', entrada = '{$entrada}', saida = '{$saida}', data_nota_fiscal = {$data_nota} WHERE id_rat ='{$id}'";
	
	if($result_update = mysqli_query($mysqli, $sql_update)){
		if($registros == ''){
			//se nao alterar a ficha de peças
			//Cria pdf da nova ficha
			$dompdf_peca = new DOMPDF();
			$html = '<center><img src="media/images/astech.png" width="248" height="100"></center><br>
			<font face="Arial"><h3><center>SOLICITA&Ccedil;&Atilde;O DE PE&Ccedil;AS</center></h3>'.'<br>
			<strong>Data:</strong>&nbsp;'.$data.'<br>
			<strong>N&uacute;mero da Ficha:</strong>&nbsp;'.$id.'<br>
			<strong>Assistente Solicitante:</strong>&nbsp;'.$assistencia.'<br>
			<strong>CNPJ Assistente</strong>&nbsp;'.$cnpj_assistente.'<br>
			<strong>Email do assistente:</strong>&nbsp;'.$row_busca['email'].'<br>
			<strong>Cliente:</strong>&nbsp;'.$nome_cliente.'<br>
			<strong>Email do cliente:</strong>&nbsp;'.$email_cliente.'<br>
			<strong>Equipamento:</strong>&nbsp;'.$nome_equipamento.' Cod:'.$equipamento.'<br>
			<br>
			<table width="100%" style="border: 1px solid black;border-collapse: collapse;">
	        	<tbody>
	        		<tr style="border: 1px solid black;">
	            		<th style="border: 1px solid black;font-size:15px;padding:6px 0;"><font face="Arial">DESCRIÇÃO DA PEÇA</font></th>
	            		<th style="border: 1px solid black;font-size:15px;padding:6px 0;"><font face="Arial">CÓDIGO</font></th>
	            		<th style="border: 1px solid black;font-size:15px;padding:6px 0;"><font face="Arial">QUANTIDADE</font></th>
	            	</tr>
	        		';
			
			for( $i=0; $i < count($_POST['descricao']); $i++ ){
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
			$arquivopecas_pdf = 'ficha_pecas'.$id.'.pdf';
			file_put_contents("../../media/uploads/".$arquivopecas_pdf, $output);
			
			//Gera formulário RAT
			$dompdf = new DOMPDF();
			$dompdf->load_html('<center><img src="media/images/astech.png" width="248" height="100"></center><br>
			<font face="Arial"><h3><center>Relat&oacute;rio de Assist&ecirc;ncia T&eacute;cnica Chiaperini Industrial</center></h3>'.'<br>
			<strong>Data:</strong>&nbsp;'.$data.'<br>
			<strong>N&uacute;mero da Ficha:</strong>&nbsp;'.$id.'<br>
			<strong>Assistente Solicitante:</strong>&nbsp;'.$assistencia.'<br>
			<strong>CNPJ do assistente:</strong>&nbsp;'.$cnpj_assistente.'<br>
			<strong>Email do assistente:</strong>&nbsp;'.$row_busca['email'].'<br>
			<strong>Cliente:</strong>&nbsp;'.$nome_cliente.'<br>
			<strong>Contato:</strong>&nbsp;'.$nome_contato.'<br>
			<strong>Endere&ccedil;o:</strong>&nbsp;'.$endereco_cliente.'<br>
			<strong>Bairro:</strong>&nbsp;'.$bairro_cliente.'<br>
			<strong>Cidade:</strong>&nbsp;'.$nome_cidade_cliente.'<br>
			<strong>Estado:</strong>&nbsp;'.$nome_estado_cliente.'<br>
			<strong>CNPJ/CPF do cliente:</strong>&nbsp;'.$cnpj_cliente.'<br>
			<strong>Email do cliente:</strong>&nbsp;'.$email_cliente.'<br>
			<strong>Telefone:</strong>&nbsp;'.$telefone_cliente.'<br>
			<strong>Celular:</strong>&nbsp;'.$celular_cliente.'<br>
			<strong>Equipamento:</strong>&nbsp;'.$nome_equipamento.' Cod:'.$equipamento.'<br>
			<strong>N&uacute;mero de S&eacute;rie:</strong>&nbsp;'.$numero_serie.'<br>
			<strong>Informa&ccedil;&otilde;es T&eacute;cnicas:</strong>&nbsp;'.utf8_decode($informacoes).'<br>
			<strong>Km:</strong>&nbsp;'.$km.'<br>
			<strong>Entrada:</strong>&nbsp;'.$entrada.'<br>
			<strong>Sa&iacute;da:</strong>&nbsp;'.$saida.'<br>
			<strong>Data Nota Fiscal:</strong>&nbsp;'.$data_nota.'<br></font>
			<br><br>
			<center><img src="media/images/chiaperini-industrial.png"></center>');
			$dompdf->render();
			$output = $dompdf->output();
			$arquivo_pdf = 'ficha'.$id.'.pdf';

			file_put_contents("../../media/uploads/".$arquivo_pdf, $output);
			
			$insert_admin = "INSERT into log_informacoes(id_user, nome, email, acao, local, data) VALUES('{$_SESSION['id_admin']}', '{$_SESSION['nome_admin']}', '{$_SESSION['usuario_admin']}', 'atualizacao' , 'Formulario RAT {$id}' ,'{$_SESSION['ultimoAcesso_admin']}')  ";
    		if ($mysqli->query($insert_admin) === TRUE){
    			?><script>alert('Formulário atualizado com sucesso');</script><?php
    		}		
			?>
			<div id="page-wrapper">
				<div class="row">
			        <div class="col-lg-12">
			            <h1 class="page-header"><i class="fa fa-wpforms fa-fw"></i> Formulários</h1>
			        </div>
			        <!-- /.col-lg-12 -->
			    </div>
			   	<div class="row">
			        <div class="col-lg-12">
			            <div class="panel panel-default">
			                <div class="panel-heading">
			                    Arquivos para Download
			                </div>
			                <!-- /.panel-heading -->
			                <div class="panel-body">
			                	<a class="btn btn-primary" href="<?php echo $url.'media/uploads/'.$arquivo_pdf; ?>" target="blank" download>Novo Formulário</a>
			                	<a class="btn btn-primary" href="<?php echo $url.'media/uploads/'.$arquivopecas_pdf; ?>" target="blank" download>Nova Ficha Peças</a>
			                </div>
			            </div>
			        </div>
			  </div>
			</div>
			<?php
		}
		else{
			//Deletar pecas antigas
			$sql_delete = "DELETE FROM pecas_solicitadas WHERE id_rat = '{$id}'";
			$result_delete = mysqli_query($mysqli, $sql_delete);	
			if($result_delete){
				//Atualizar ficha peças
				for( $i=0; $i < $total_registros; $i++ )
				{
					$sql_pecas = "INSERT into pecas_solicitadas ( id_usuario, id_rat, cod_equipamento, cod_peca, descricao, quantidade, data ) VALUES ('{$id_usuario}', '{$id}', '{$equipamento}', '{$_POST['codPeca'][$i]}', '{$_POST['descricao'][$i]}', '{$_POST['quantidade'][$i]}', '{$data}')";
					if(mysqli_query($mysqli, $sql_pecas)){
						$upload_ok = true;
					}	
				}
				if($upload_ok === TRUE){
					
					//Cria pdf da nova ficha
					$dompdf_peca = new DOMPDF();
					$html = '<center><img src="media/images/astech.png" width="248" height="100"></center><br>
					<font face="Arial"><h3><center>SOLICITA&Ccedil;&Atilde;O DE PE&Ccedil;AS</center></h3>'.'<br>
					<strong>Data:</strong>&nbsp;'.$data.'<br>
					<strong>N&uacute;mero da Ficha:</strong>&nbsp;'.$id.'<br>
					<strong>Assistente Solicitante:</strong>&nbsp;'.$assistencia.'<br>
					<strong>CNPJ Assistente</strong>&nbsp;'.$cnpj_assistente.'<br>
					<strong>Email do assistente:</strong>&nbsp;'.$row_busca['email'].'<br>
					<strong>Cliente:</strong>&nbsp;'.$nome_cliente.'<br>
					<strong>Email do cliente:</strong>&nbsp;'.$email_cliente.'<br>
					<strong>Equipamento:</strong>&nbsp;'.$equipamento.'<br>
					<br>
					<table width="100%" style="border: 1px solid black;border-collapse: collapse;">
			        	<tbody>
			        		<tr style="border: 1px solid black;">
			            		<th style="border: 1px solid black;font-size:15px;padding:6px 0;"><font face="Arial">DESCRIÇÃO DA PEÇA</font></th>
			            		<th style="border: 1px solid black;font-size:15px;padding:6px 0;"><font face="Arial">CÓDIGO</font></th>
			            		<th style="border: 1px solid black;font-size:15px;padding:6px 0;"><font face="Arial">QUANTIDADE</font></th>
			            	</tr>
			        		';
					
					for( $i=0; $i < $total_registros; $i++ ){
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
					$arquivopecas_pdf = 'ficha_pecas'.$id.'.pdf';
					file_put_contents("../../media/uploads/".$arquivopecas_pdf, $output);
					
					//Gera formulário RAT
					$dompdf = new DOMPDF();
					$dompdf->load_html('<center><img src="media/images/astech.png" width="248" height="100"></center><br>
					<font face="Arial"><h3><center>Relat&oacute;rio de Assist&ecirc;ncia T&eacute;cnica Chiaperini Industrial</center></h3>'.'<br>
					<strong>Data:</strong>&nbsp;'.$data.'<br>
					<strong>N&uacute;mero da Ficha:</strong>&nbsp;'.$id.'<br>
					<strong>Assistente Solicitante:</strong>&nbsp;'.$assistencia.'<br>
					<strong>CNPJ do assistente:</strong>&nbsp;'.$cnpj_assistente.'<br>
					<strong>Email do assistente:</strong>&nbsp;'.$row_busca['email'].'<br>
					<strong>Cliente:</strong>&nbsp;'.$nome_cliente.'<br>
					<strong>Contato:</strong>&nbsp;'.$nome_contato.'<br>
					<strong>Endere&ccedil;o:</strong>&nbsp;'.$endereco_cliente.'<br>
					<strong>Bairro:</strong>&nbsp;'.$bairro_cliente.'<br>
					<strong>Cidade:</strong>&nbsp;'.$nome_cidade_cliente.'<br>
					<strong>Estado:</strong>&nbsp;'.$nome_estado_cliente.'<br>
					<strong>CNPJ/CPF do cliente:</strong>&nbsp;'.$cnpj_cliente.'<br>
					<strong>Email do cliente:</strong>&nbsp;'.$email_cliente.'<br>
					<strong>Telefone:</strong>&nbsp;'.$telefone_cliente.'<br>
					<strong>Celular:</strong>&nbsp;'.$celular_cliente.'<br>
					<strong>Equipamento:</strong>&nbsp;'.$equipamento.'<br>
					<strong>N&uacute;mero de S&eacute;rie:</strong>&nbsp;'.$numero_serie.'<br>
					<strong>Informa&ccedil;&otilde;es T&eacute;cnicas:</strong>&nbsp;'.utf8_decode($informacoes).'<br>
					<strong>Km:</strong>&nbsp;'.$km.'<br>
					<strong>Entrada:</strong>&nbsp;'.$entrada.'<br>
					<strong>Sa&iacute;da:</strong>&nbsp;'.$saida.'<br>
					<strong>Data Nota Fiscal:</strong>&nbsp;'.$data_nota.'<br></font>
					<br><br>
					<center><img src="media/images/chiaperini-industrial.png"></center>');
					$dompdf->render();
					$output = $dompdf->output();
					$arquivo_pdf = 'ficha'.$id.'.pdf';
	
					file_put_contents("../../media/uploads/".$arquivo_pdf, $output);
								
					?>
					<div id="page-wrapper">
						<div class="row">
					        <div class="col-lg-12">
					            <h1 class="page-header"><i class="fa fa-wpforms fa-fw"></i> Formulários</h1>
					        </div>
					        <!-- /.col-lg-12 -->
					    </div>
					   	<div class="row">
					        <div class="col-lg-12">
					            <div class="panel panel-default">
					                <div class="panel-heading">
					                    Arquivos para Download
					                </div>
					                <!-- /.panel-heading -->
					                <div class="panel-body">
					                	<a class="btn btn-primary" href="<?php echo $url.'media/uploads/'.$arquivo_pdf; ?>" target="blank" download>Novo Formulário</a>
					                	<a class="btn btn-primary" href="<?php echo $url.'media/uploads/'.$arquivopecas_pdf; ?>" target="blank" download>Nova Ficha Peças</a>
					                </div>
					            </div>
					        </div>
					  </div>
					</div>
					<?php
				}
				else{
					echo '<script>alert("Houve um erro na atualização da ficha de peças.");window.history.go(-1);</script>';
				}
			}
			else{
				echo '<script>alert("Houve um erro ao atualizar a ficha de peças, por favor verifique os itens e tente atualizar novamente.");window.history.go(-1);</script>';
			}
		}
	}	
	else{
		echo '<script>alert("Erro ao atualizar formulário.");window.history.go(-1);</script>';	
	}
}
else{
	echo '<script>alert("Item obrigatório não enviado");</script>';
}
?>