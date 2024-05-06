<?php
include_once('media/core/functions.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$perfil = $_SESSION['perfil'];
$tabela = $perfil."s";

if(usuarioestalogado()){	
	include('header.php');
	?>
	<style>
		a.botao_detalhes_formulario{
			background:#337ab7;
			color:#fff;
			font-size:14px;
			font-weight:400;
			padding:5px;
			border-radius:5px;
		}
		a.botao_detalhes_formulario:hover{
			background:#3e8dd1;
			text-decoration:none;
		}
	</style>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#input_cnpj").mask("99.999.999/9999-99");
	});

	function buscar_cidades(){
      var estado = $('#select_estado').val();  //codigo do estado escolhido
      //se encontrou o estado
      if(estado){
        var url = 'ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD
        $.get(url, function(dataReturn) {
          $('#select_cidade').html(dataReturn);  //coloco na div o retorno da requisicao
        });
      }
    }
	</script>
	
	<?php
	if($_REQUEST['id']){
		$id = $_REQUEST['id'];
		$busca_formulario = "SELECT * FROM formularios_rat WHERE id_usuario = '{$_SESSION['id_usuario']}' AND id_rat = '{$id}' ";
		$result_formulario = mysqli_query($mysqli, $busca_formulario);
		if($row_formulario = mysqli_fetch_assoc($result_formulario)){
		?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-8 col-md-offset-2">
					<form class="form-horizontal" role="form" id="formulario_RAT" method="POST" action="<?php echo $url_atual;?>atualizar_rat/" enctype="multipart/form-data">
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputData" class="col-md-1 control-label">Data</label>
					                <div class="col-md-3">
					                    <input type="text" class="form-control text-center" name="inputData" id="inputData" value="<?php echo $row_formulario['data_insercao'];?>" readonly>
					                </div>
					                <label for="inputNumeroFicha" class="col-md-2 col-md-offset-4 control-label">Ficha Nº</label>
					                <div class="col-md-2">
					                    <input type="text" class="form-control" name="inputNumeroFicha" id="inputNumeroFicha" value="<?php echo $row_formulario['numero_ficha']; ?>" readonly>
					                </div>
					            </div>
					        </div>
					    </div>
					   <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputNomeAssistencia" class="col-md-5 control-label" style="text-align: left;">Assistência Técnica Autorizada</label>
					                <div class="col-md-7">
					                     <input type="text" class="form-control" id="inputNomeAssistencia" name="inputNomeAssistencia" value="<?php echo $row_formulario['assistente_solicitante']; ?>" readonly>
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="page-header">
						  <h3><center>Dados do cliente final</center></h3>
						</div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputNomeCliente" class="col-md-1 control-label">Cliente<span style="color:red;">*</span></label>
					                <div class="col-md-6">
					                     <input type="text" class="form-control" id="inputNomeCliente" name="inputNomeCliente" value="<?php echo $row_formulario['cliente'] ?>" readonly>
					                </div>
					                <label for="inputNomeContato" class="col-md-1 control-label">Contato<span style="color:red;">*</span></label>
					                <div class="col-md-4">
					                    <input type="text" class="form-control" id="inputNomeContato" name="inputNomeContato" value="<?php echo $row_formulario['contato'] ?>" readonly>
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputEndereco" class="col-md-2 control-label" style="text-align:left;">Endereço<span style="color:red;">*</span></label>
					                <div class="col-md-5">
					                     <input type="text" class="form-control" name="inputEndereco" id="inputEndereco" value="<?php echo $row_formulario['endereco_cliente'] ?>" readonly>
					                </div>
					                <label for="inputBairro" class="col-md-1 control-label">Bairro<span style="color:red;">*</span></label>
					                <div class="col-md-4">
					                    <input type="text" class="form-control" name="inputBairro" id="inputBairro" value="<?php echo $row_formulario['bairro_cliente'] ?>" readonly>
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					            	<label for="inputEstado" class="col-md-1 control-label">Estado<span style="color:red;">*</span></label>
					                <div class="col-md-2">
					                    <select id="inputEstado" name="inputEstado" class="form-control" readonly>
					                    	<?php
					                    	$sql_estado = "SELECT * FROM estado WHERE id = {$row_formulario['estado']}";
											$result_estado = mysqli_query($mysqli, $sql_estado);
											if($row_estado = mysqli_fetch_assoc($result_estado)){
					                    	?>
											<option value="<?php echo $row_estado['uf']; ?>"><?php echo $row_estado['uf']; ?></option>
											<?php
											}
											?>
										</select>
					                </div>
					                <label for="inputCidade" class="col-md-1 control-label">Cidade<span style="color:red;">*</span></label>
					                <div class="col-md-8">
					                	<select name="inputCidade" id="inputCidade" class="form-control" readonly>
					                		<?php
					                    	$sql_cidade = "SELECT * FROM cidade WHERE cod_ibge = '{$row_formulario['cidade']}'";
											$result_cidade = mysqli_query($mysqli, $sql_cidade);
											if($row_cidade = mysqli_fetch_assoc($result_cidade)){
												?>
												<option value="<?php echo $row_cidade['nome'] ?>"><?php echo $row_cidade['nome'] ?></option>
												<?php
											}
					                    	?>
								        </select>
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="form-group">
					    	<div class="col-md-12">
					    		<div class="form-group row">
					    			<label for="inputCNPJ" class="col-md-2 control-label" style="text-align: left;">CNPJ/CPF<span style="color:red;">*</span></label>
					                <div class="col-md-3">
					                     <input type="text" class="form-control" id="inputCnpj" name="inputCNPJ" value="<?php echo $row_formulario['cnpj_cliente'] ?>" readonly>
					                </div>
					                <label for="inputEmailCliente" class="col-md-3 control-label">Email do Cliente<span style="color:red;">*</span></label>
					                <div class="col-md-4">
					                     <input type="text" class="form-control" id="inputEmailCliente" name="inputEmailCliente" value="<?php echo $row_formulario['email_cliente'] ?>" readonly>
					                </div>
					    		</div>
					    	</div>
					    </div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputTelefone" class="col-md-2 control-label" style="text-align:left;">Tel/Cel<span style="color:red;">*</span></label>
					                <div class="col-md-4">
					                    <input type="tel" class="form-control" name="inputTelefone" id="inputTelefone" value="<?php echo $row_formulario['telefone_cliente'] ?>" readonly>
					                </div>
					                <label for="inputCelular" class="col-md-1 control-label">Tel/Cel</label>
					                <div class="col-md-5">
					                    <input type="text" class="form-control" id="inputCelular" name="inputCelular" value="<?php echo $row_formulario['celular_cliente'] ?>" readonly>
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="page-header">
						  <h3><center>Dados do equipamento</center></h3>
						</div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputEquipamento" class="col-md-2 control-label" style="text-align:left !important;">Equipamento<span style="color:red;">*</span></label>
					                <div class="col-md-6">
					                	<select id="inputEquipamento" name="inputEquipamento" class="form-control" readonly>
											<option value=""><?php echo $row_formulario['equipamento']; ?></option>
										</select>
					                </div>
					                <label for="inputNumeroSerie" class="col-md-2 control-label" style="text-align:left !important;">Nº de Série<span style="color:red;">*</span></label>
					                <div class="col-md-2">
					                    <input type="text" class="form-control" id="inputNumeroSerie" name="inputNumeroSerie" value="<?php echo $row_formulario['numero_serie'] ?>" readonly>
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					            	<label for="inputInformacoes" class="col-md-2 control-label" style="text-align:left !important;">Informações Técnicas<span style="color:red;">*</span></label>
					                <div class="col-md-10">
					                     <textarea class="form-control" rows="4" id="inputInformacoes" name="inputInformacoes" readonly><?php echo $row_formulario['informacoes_tecnicas']; ?></textarea>
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputKM" class="col-md-1 control-label">KM</label>
					                <div class="col-md-3">
					                     <input type="text" class="form-control" id="inputKM" name="inputKM" value="<?php echo $row_formulario['km'] ?>" aria-describedby="helpBlock" readonly>
					                     <span id="helpBlock" class="help-block">Caso atenda o cliente no local</span>
					                </div>
					                <label for="inputEntrada" class="col-md-1 control-label">Entrada</label>
					                <div class="col-md-3">
					                    <input type="text" class="form-control" id="inputEntrada" name="inputEntrada" value="<?php echo $row_formulario['entrada'] ?>" readonly>
					                </div>
					                <label for="inputSaida" class="col-md-1 control-label">Saída</label>
					                <div class="col-md-3">
					                    <input type="text" class="form-control" id="inputSaida" name="inputSaida" value="<?php echo $row_formulario['saida'] ?>" readonly>
					                </div>
					            </div>
					        </div>
					    </div>
						<div class="form-group">
					    	<div class="col-md-12">
					            <div class="form-group row">
								    <label for="InputDataNotaFiscal" class="col-md-3 control-label" style="text-align:left;">Data da Nota Fiscal<span style="color:red;">*</span></label>
								    <div class="col-md-3">
								    	<input type="text" class="form-control" id="InputDataNotaFiscal" name="InputDataNotaFiscal" value="<?php echo $row_formulario['data_nota_fiscal'] ?>" readonly>
								    </div>
								</div>
							</div>
						</div>
						<div class="page-header">
						  <h3><center>Solicitação de Peças</center></h3>
						</div>
					   <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					            	<div class="col-md-12">
						                <table class="table table-bordered" id="grid" cellpadding="0" cellspacing="0">
						                	<tbody>
						                		<tr>
							                		<th style="font-size:13px;font-weight: normal;">Nome da Peça</th>
							                		<th style="font-size:13px;font-weight: normal;text-align: center;">Cód.</th>
							                		<th style="font-size:13px;font-weight: normal;text-align: center;">Qtde</th>
							                	</tr>
							                	<?php
							                		$busca_pecas = "SELECT * FROM pecas_solicitadas WHERE id_rat = '$id'";
													$result_pecas = mysqli_query($mysqli, $busca_pecas);
													$linhas=0;
													while($row_pecas = mysqli_fetch_assoc($result_pecas)){
														$linhas++;
														?>
														<tr>
															<td style="font-size:13px;"><input type="text" name="descricao[]" value="<?php echo $row_pecas['descricao']; ?>" readonly/></td>
															<td style="text-align:center;font-size:13px;"><input type="text" name="codPeca[]" value="<?php echo $row_pecas['cod_peca']; ?>" readonly/></td>
															<td style="text-align:center;font-size:13px;"><input type="text" name="quantidade[]" value="<?php echo $row_pecas['quantidade']; ?>" readonly/></td>
														</tr>
														<?php
													}
							                	?>
						                	</tbody>
						                </table>
					                </div>
					            </div>
					        </div>
					    </div>
					    <?php
					    	if($row_formulario['status'] == 0){
					    		?>
					    		<div class="form-group">
							        <div class="col-md-12 text-center">
							            <div class="form-group row">
							    			<button type="submit" id="btn_enviar" class="btn btn-warning" onclick="return confirm('Ao finalizar a ficha você estará confirmando que a manutenção referente a este pedido de garantia foi realizada. Deseja confirmar esta ficha?');">Finalizar este pedido de garantia</button>
							    		</div>
							    	</div>
							    </div>
					    		<?php
					    	}
					    ?>
					</form>
				</div>
			</div>
		</div>
		<?php
		}
	}
	else{
	?>
	<div class="container" style="padding:20px 0px;">
		<div class="row">
			<div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Formulários de Garantia enviados
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th width="13%" style="font-size:14px;">Nº do Formulário</th>
                                    <th style="font-size:14px;">Nome do Cliente</th>
                                    <th style="font-size:14px;">Data</th>
                                    <th style="font-size:14px;">Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
								$busca_formularios = "SELECT * FROM formularios_rat WHERE id_usuario = '{$_SESSION['id_usuario']}' ORDER BY id_rat ASC ";
								$result_formularios = mysqli_query($mysqli, $busca_formularios);
								while($row_formularios = mysqli_fetch_assoc($result_formularios)){
                            	?>
                                <tr class="even gradeC">
                                    <td style="font-size:14px;"><center><?php echo $row_formularios['id_rat']; ?></center></td>
                                    <td style="font-size:14px;"><?php echo $row_formularios['cliente']; ?></td>
                                    <td class="center" style="font-size:14px;"><?php echo date('d/m/Y', strtotime($row_formularios['data_insercao'])); ?></td>
                                    <td style="font-size:14px;">
                                    	<center>
                                    	<?php if($row_formularios['status'] == 0){ echo 'Recebido'; } else if($row_formularios['status'] == 1){ echo 'Finalizado';} ?>
                                    	</center>
                                    </td>
                                    <td><center><a class="botao_detalhes_formulario" href="<?php echo $url_atual.'meus_formularios/'.$row_formularios['id_rat']; ?>" target="_self">Ver Detalhes</a></center></td>
                                </tr>
                                <?php
								}
                                ?>
                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
		</div>
	</div>
	<?php
	}
	?>
	<!--
	<div class="container">
		<div class="col-lg-6">
        	<div class="panel panel-default">
	            <div class="panel-heading"><h3>Object Store</h3></div>
	            <div class="panel-body">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example" style="border-collapse:collapse;">
				
				    <thead>
				        <tr><th>&nbsp;</th>
				            <th>Job Name</th>
				            <th>Description</th>
				            <th>Provider Name</th>
				            <th>Region</th>
				            <th>Status</th>
				        </tr>
				    </thead>
				
				    <tbody>
				        <tr data-toggle="collapse" data-target="#demo1" class="accordion-toggle">
				                  <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
				            <td>OBS Name</td>
				            <td>OBS Description</td>
				            <td>hpcloud</td>
				            <td>nova</td>
				          <td> created</td>
				
				        </tr>
				        <tr>
				            <td colspan="12" class="hiddenRow"><div class="accordian-body collapse" id="demo1"> 
				              <table class="table table-striped">
				                      <thead>
				                        <tr><td><a href="WorkloadURL">Workload link</a></td><td>Bandwidth: Dandwidth Details</td><td>OBS Endpoint: end point</td></tr>
				                        <tr><th>Access Key</th><th>Secret Key</th><th>Status </th><th> Created</th><th> Expires</th><th>Actions</th></tr>
				                      </thead>
				                      <tbody>
				                        <tr><td>access-key-1</td><td>secretKey-1</td><td>Status</td><td>some date</td><td>some date</td><td><a href="#" class="btn btn-default btn-sm">
				                  <i class="glyphicon glyphicon-cog"></i></a></td></tr>
				                      </tbody>
				               	</table>
				              
				              </div> </td>
				        </tr>
				        <tr data-toggle="collapse" data-target="#demo2" class="accordion-toggle">
				                <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
				                <td>OBS Name</td>
				            <td>OBS Description</td>
				            <td>hpcloud</td>
				            <td>nova</td>
				          <td> created</td>
				        </tr>
				        <tr>
				            <td colspan="6" class="hiddenRow"><div id="demo2" class="accordian-body collapse">Demo2</div></td>
				        </tr>
				        <tr data-toggle="collapse" data-target="#demo3" class="accordion-toggle">
				            <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
				            <td>OBS Name</td>
				            <td>OBS Description</td>
				            <td>hpcloud</td>
				            <td>nova</td>
				          <td> created</td>
				        </tr>
				        <tr>
				            <td colspan="6" class="hiddenRow"><div id="demo3" class="accordian-body collapse">Demo3</div></td>
				        </tr>
				    </tbody>
				</table>
            </div>
        
          </div> 
        
      </div>
	</div>
	-->
	
	<!-- DataTables JavaScript -->
    <script src="admin/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="admin/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="admin/vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>					   
	<?php
	include('footer.php');
}