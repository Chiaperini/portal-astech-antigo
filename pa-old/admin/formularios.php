<?php include('header.php'); 

$acao = $_GET['acao'];

?>
<script type="text/javascript">
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
	function ExecutaAcao(script){
        document.form_ficha_rat.action = script;
        document.form_ficha_rat.submit();
    }
</script>

<?php
if($acao == 'gerenciar'){
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
                        Formulários Cadastrados
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID </th>
                                    <th>Nome Assistente </th>
                                    <th>Nome do Cliente </th>
                                    <th>Status </th>
                                    <th>Data Envio </th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
								$busca_form = "SELECT * FROM formularios_rat ORDER BY data_insercao DESC";
								$result_form = mysqli_query($mysqli, $busca_form);
								
								while($row_form = mysqli_fetch_assoc($result_form)){
                            	?>
                                <tr class="even gradeC">
                                    <td><?php echo $row_form['id_rat']; ?></td>
                                    <td><a href="formularios.php?acao=editar&id=<?php echo $row_form['id_rat']?>" target="_self"><?php echo $row_form['assistente_solicitante']; ?></a></td>
                                    <td><?php echo $row_form['cliente']; ?></td>
                                    <td style="text-align: center;"><?php echo $row_form['status']; ?></td>
                                    <td style="text-align: center;"><?php echo date('d/m/Y H:i:s',strtotime($row_form['data_insercao'])); ?></td>
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
            <!-- /.col-lg-12 -->
        </div>
	</div>
	<?php
}
if($acao == 'editar'){
	$id = $_GET['id'];
	?>
	<div id="page-wrapper">
		<div class="row">
	        <div class="col-lg-12">
	            <h1 class="page-header"><i class="fa fa-user fa-fw"></i> Editar Formulário</h1>
	        </div>
	        <!-- /.col-lg-12 -->
	    </div>
	     <div class="row">
	        <div class="col-lg-8">
	        	<div class="well well-lg">
        		 <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" class="active"><a href="#ficha" aria-controls="ficha" role="tab" data-toggle="tab">Ficha</a></li>
				    <li role="presentation"><a href="#ficha_pecas" aria-controls="ficha_pecas" role="tab" data-toggle="tab">Ficha de Peças</a></li>
				    <li role="presentation"><a href="#uploads" aria-controls="uploads" role="tab" data-toggle="tab">Arquivos Enviados</a></li>
				    <li role="presentation"><a href="#arquivos_gerados" aria-controls="arquivos_gerados" role="tab" data-toggle="tab">Arquivos Gerados</a></li>
				  </ul>
				  	<?php
						$busca_form = "SELECT * FROM formularios_rat WHERE id_rat = '$id'";
						$result_form = mysqli_query($mysqli, $busca_form);
						if($row_form = mysqli_fetch_assoc($result_form)){
	        		?>
	        		<form class="form-horizontal" role="form" id="form_ficha_rat" name="form_ficha_rat" method="post" action="atualizar_rat.php" enctype="multipart/form-data" style="padding-top:20px;">
					  	<div class="tab-content">
					  	<div role="tabpanel" class="tab-pane fade in active" id="ficha">
					  	   <input type="hidden" name="input_id" value="<?php echo $id; ?>">
					  	   <input type="hidden" name="inputIDUsuario" value="<?php echo $row_form['id_usuario']; ?>">
						   <div class="form-group">
						        <div class="col-md-12">
						            <div class="form-group row">
						                <label for="inputData" class="col-md-1 control-label">Data</label>
						                <div class="col-md-3">
						                    <input type="text" class="form-control text-center" name="inputData" id="inputData" value="<?php echo date('d/m/Y H:i:s',strtotime($row_form['data_insercao']));?>">
						                </div>
						                <label for="inputNumeroFicha" class="col-md-2 col-md-offset-4 control-label">Ficha Nº</label>
						                <div class="col-md-2">
						                    <input type="text" class="form-control" name="inputNumeroFicha" id="inputNumeroFicha" value="<?php echo $row_form['id_rat']; ?>">
						                </div>
						            </div>
						        </div>
						    </div>
						   <div class="form-group">
						        <div class="col-md-12">
						            <div class="form-group row">
						                <label for="inputNomeAssistencia" class="col-md-5 control-label" style="text-align: left;">Assistência Técnica Autorizada</label>
						                <div class="col-md-7">
						                     <input type="text" class="form-control" id="inputNomeAssistencia" name="inputNomeAssistencia" placeholder="" value="<?php echo $row_form['assistente_solicitante']; ?>" readonly>
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
						                     <input type="text" class="form-control" id="inputNomeCliente" name="inputNomeCliente" value="<?php echo $row_form['cliente']; ?>" >
						                </div>
						                <label for="inputNomeContato" class="col-md-1 control-label">Contato<span style="color:red;">*</span></label>
						                <div class="col-md-4">
						                    <input type="text" class="form-control" id="inputNomeContato" name="inputNomeContato" value="<?php echo $row_form['contato']; ?>">
						                </div>
						            </div>
						        </div>
						    </div>
						    <div class="form-group">
						        <div class="col-md-12">
						            <div class="form-group row">
						                <label for="inputEndereco" class="col-md-2 control-label" style="text-align:left;">Endereço<span style="color:red;">*</span></label>
						                <div class="col-md-5">
						                     <input type="text" class="form-control" name="inputEndereco" id="inputEndereco" value="<?php echo $row_form['endereco_cliente']; ?>">
						                </div>
						                <label for="inputBairro" class="col-md-1 control-label">Bairro<span style="color:red;">*</span></label>
						                <div class="col-md-4">
						                    <input type="text" class="form-control" name="inputBairro" id="inputBairro" value="<?php echo $row_form['bairro_cliente']; ?>">
						                </div>
						            </div>
						        </div>
						    </div>
						    <div class="form-group">
						        <div class="col-md-12">
						            <div class="form-group row">
						            	<label for="select_estado" class="col-md-1 control-label">Estado<span style="color:red;">*</span></label>
						                <div class="col-md-2">
						                    <select id="select_estado" name="select_estado" onchange="buscar_cidades()" class="form-control">
						                    	<?php
												$busca_estado = "SELECT * FROM estado WHERE id = '{$row_form['estado']}'";
												$result_estado = mysqli_query($mysqli, $busca_estado);
												if($row_estado = mysqli_fetch_assoc($result_estado)){
								        		?>
				                                <option value="<?php echo $row_estado['id']; ?>"><?php echo utf8_encode($row_estado['uf']); ?></option>
				                                <?php
												}
												$busca_estados = "SELECT * FROM estado WHERE id <> '{$row_form['estado']}' ";
												$result_estados = mysqli_query($mysqli, $busca_estados);
												while($row_estados = mysqli_fetch_assoc($result_estados)){
				                                ?>
				                                <option value="<?php echo $row_estados['id']; ?>"><?php echo utf8_encode($row_estados['uf']); ?></option>
				                                <?php
												}
				                                ?>
											</select>
						                </div>
						                <label for="select_cidade" class="col-md-1 control-label">Cidade<span style="color:red;">*</span></label>
						                <div class="col-md-8">
						                	<select name="select_cidade" id="select_cidade" class="form-control">
									         	<?php
												$busca_cidade = "SELECT * FROM cidade WHERE cod_ibge = '{$row_form['cidade']}' ";
												$result_cidade = mysqli_query($mysqli, $busca_cidade);
												if($row_cidade = mysqli_fetch_assoc($result_cidade)){
								        		?>
				                                <option value="<?php echo $row_cidade['cod_ibge']; ?>"><?php echo utf8_encode($row_cidade['nome']); ?></option>
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
						                     <input type="text" class="form-control" id="inputCnpj" name="inputCNPJ" onkeypress='mascaraMutuario(this,cpfCnpj)' onblur='clearTimeout()' value="<?php echo $row_form['cnpj_cliente']; ?>">
						                </div>
						                <label for="inputEmailCliente" class="col-md-3 control-label">Email do Cliente<span style="color:red;">*</span></label>
						                <div class="col-md-4">
						                     <input type="text" class="form-control" id="inputEmailCliente" name="inputEmailCliente" value="<?php echo $row_form['email_cliente']; ?>">
						                </div>
						    		</div>
						    	</div>
						    </div>
						    <div class="form-group">
						        <div class="col-md-12">
						            <div class="form-group row">
						                <label for="inputTelefone" class="col-md-2 control-label" style="text-align:left;">Tel/Cel<span style="color:red;">*</span></label>
						                <div class="col-md-4">
						                    <input type="tel" class="form-control" name="inputTelefone" id="inputTelefone" value="<?php echo $row_form['telefone_cliente']; ?>" >
						                </div>
						                <label for="inputCelular" class="col-md-1 control-label">Tel/Cel</label>
						                <div class="col-md-5">
						                    <input type="text" class="form-control" id="inputCelular" name="inputCelular" value="<?php echo $row_form['celular_cliente']; ?>">
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
						                	<select id="inputEquipamento" name="inputEquipamento" class="form-control">
						                		<?php
												$busca_equipamento = "SELECT * FROM equipamentos WHERE codigo = '{$row_form['cod_equipamento']}'";
												$result_equipamento = mysqli_query($mysqli, $busca_equipamento);
												if($row_equipamento = mysqli_fetch_assoc($result_equipamento)){
								        		?>
				                                <option value="<?php echo $row_equipamento['codigo']; ?>"><?php echo utf8_encode($row_equipamento['nome']); ?></option>
				                                <?php
												}
												$busca_equipamentos = "SELECT * FROM equipamentos WHERE codigo <> '{$row_form['cod_equipamento']}' ";
												$result_equipamentos = mysqli_query($mysqli, $busca_equipamentos);
												while($row_equipamentos = mysqli_fetch_assoc($result_equipamentos)){
				                                ?>
				                                <option value="<?php echo $row_equipamentos['codigo']; ?>"><?php echo utf8_encode($row_equipamentos['nome']); ?></option>
				                                <?php
												}
				                                ?>
											</select>
						                </div>
						                <label for="inputNumeroSerie" class="col-md-2 control-label" style="text-align:left !important;">Nº de Série<span style="color:red;">*</span></label>
						                <div class="col-md-2">
						                    <input type="text" class="form-control" id="inputNumeroSerie" name="inputNumeroSerie" value="<?php echo $row_form['numero_serie']; ?>">
						                </div>
						            </div>
						        </div>
						    </div>
						    <div class="form-group">
						        <div class="col-md-12">
						            <div class="form-group row">
						            	<label for="inputInformacoes" class="col-md-2 control-label" style="text-align:left !important;">Informações Técnicas<span style="color:red;">*</span></label>
						                <div class="col-md-10">
						                     <textarea class="form-control" rows="4" id="inputInformacoes" name="inputInformacoes"><?php echo $row_form['informacoes_tecnicas']; ?></textarea>
						                </div>
						            </div>
						        </div>
						    </div>
						    <div class="form-group">
						        <div class="col-md-12">
						            <div class="form-group row">
						                <label for="inputKM" class="col-md-1 control-label">KM</label>
						                <div class="col-md-3">
						                     <input type="text" class="form-control" id="inputKM" name="inputKM" value="<?php echo $row_form['km']; ?>" aria-describedby="helpBlock">
						                     <span id="helpBlock" class="help-block">Caso atenda o cliente no local</span>
						                </div>
						                <label for="inputEntrada" class="col-md-1 control-label">Entrada</label>
						                <div class="col-md-3">
						                    <input type="text" class="form-control" id="inputEntrada" name="inputEntrada" value="<?php echo $row_form['entrada']; ?>">
						                </div>
						                <label for="inputSaida" class="col-md-1 control-label">Saída</label>
						                <div class="col-md-3">
						                    <input type="text" class="form-control" id="inputSaida" name="inputSaida" value="<?php echo $row_form['saida']; ?>">
						                </div>
						            </div>
						        </div>
						    </div>
				  		</div>
				  		<div role="tabpanel" class="tab-pane fade" id="ficha_pecas">
				  			<div class="form-group">
						        <div class="col-md-12">
						            <div class="form-group row">
						                <label for="inputCodPeca" class="col-md-3 control-label">Código Peça</label>
						                <div class="col-md-2">
						                     <input type="text" class="form-control" id="inputCodPeca" name="inputCodPeca" placeholder="" aria-describedby="helpBlock">
						                     <span id="helpBlock" class="help-block"></span>
						                </div>
						                <label for="inputQuantidade" class="col-md-2 control-label">Quantidade</label>
						                <div class="col-md-2">
						                    <input type="text" class="form-control" id="inputQuantidade" name="inputQuantidade" placeholder="">
						                </div>
						                <div class="col-md-3" align="right">
						                    <a id="btn_adicionar_peca" target="_blank" style="text-align: right;cursor:pointer;text-decoration:none;"><span class="glyphicon glyphicon-plus btn-lg" aria-hidden="true" style="margin-top:-6px;"></span>Adicionar</a>
						                </div>
						            </div>
						        </div>
						  	</div>
						  	<div class="form-group" style="padding:0px 15px;">
						        <div class="col-md-12">
						            <div class="form-group row">
						    			<fieldset style="display:hidden;">
						    				<input type="hidden" name="totalRegistros" id="totalRegistros" value="" />
						    			</fieldset>
						    		</div>
						    	</div>
						    </div>
						   	<div class="form-group">
						        <div class="col-md-12">
						            <div class="form-group row">
						            	<div class="col-md-12">
							                <table class="table table-bordered" id="grid" cellpadding="0" cellspacing="0">
							                	<tbody>
							                		<tr>
								                		<th style="font-size:13px;font-weight: bold;">Nome da Peça</th>
								                		<th style="font-size:13px;font-weight: bold;text-align: center;">Cód.</th>
								                		<th style="font-size:13px;font-weight: bold;text-align: center;">Qtde</th>
								                		<th style="font-size:13px;font-weight: bold;text-align: center;">Ação</th>
								                	</tr>
								                	<?php
								                		$busca_pecas = "SELECT * FROM pecas_solicitadas WHERE id_rat = '$id'";
														$result_pecas = mysqli_query($mysqli, $busca_pecas);
														$linhas=0;
														while($row_pecas = mysqli_fetch_assoc($result_pecas)){
															$linhas++;
															?>
															<tr>
																<td style="font-size:13px;"><input type="text" name="descricao[]" value="<?php echo $row_pecas['descricao']; ?>" /></td>
																<td style="text-align:center;font-size:13px;"><input type="text" name="codPeca[]" value="<?php echo $row_pecas['cod_peca']; ?>" /></td>
																<td style="text-align:center;font-size:13px;"><input type="text" name="quantidade[]" value="<?php echo $row_pecas['quantidade']; ?>" /></td>
																<td style="text-align:center;font-size:13px;"><a class="remover" style="cursor:pointer;text-decoration:none" title="Excluir este produto">Remover</a></td>
															</tr>
															<?php
														}
								                	?>
							                	</tbody>
							                </table>
							                <a class="btn btn-primary" onclick="confirmaPedido();">Confirmar Pedido</a>
						                </div>
						            </div>
						        </div>
						    </div>
				  		</div>
				  		<div role="tabpanel" class="tab-pane fade" id="uploads">
				  			 <div class="form-group">
						    	<div class="col-md-12">
						    		<div class="form-group row">
						    			<label class="col-md-2 control-label" style="text-align: left;">Nota Fiscal</label>
						    			<input type="hidden" name="nota_fiscal" value="<?php echo $row_form['nota_fiscal'];?>">
						    			<a href="<?php echo $url.$row_form['nota_fiscal'];?>" target="_blank"><i class="fa fa-file fa-2x"></i></a>
						    		</div>
						    		<div class="form-group row">
						    			<label class="col-md-3 control-label" style="text-align: left;">Data Nota Fiscal</label>
						    			<div class="col-md-3">
						    				<input type="text" class="form-control" id="InputDataNotaFiscal" name="InputDataNotaFiscal" value="<?php echo $row_form['data_nota_fiscal'];?>">
						            	</div>
						            </div>
						        </div>
						     </div>
						     <div class="form-group">
						    	<div class="col-md-12">
						    		<div class="form-group row">
						    			<label class="col-md-5 control-label" style="text-align: left;">Fotos do Equipamento</label>
						    		</div>
						    		<div class="form-group row">
						    			<?php
						    			$qtde_imagens = 1;
						    			$busca_fotos = "SELECT * FROM fotos_produto WHERE id_rat = '$id'";
										$result_fotos_produto = mysqli_query($mysqli, $busca_fotos);
										while($row_fotos_produto = mysqli_fetch_assoc($result_fotos_produto)){
											?>
											<label style="padding-left:15px;font-weight:normal;">Imagem <?php echo $qtde_imagens; ?></label><br>
											<center><img src="<?php echo $url.$row_fotos_produto['foto']; ?>" width="95%"></center><br><br>
											<?php
											$qtde_imagens++;
										}
										?>
						    		</div>
						    		</div>
						    </div>
					  	</div>
				  		<div role="tabpanel" class="tab-pane fade" id="arquivos_gerados">
				  			 <div class="form-group">
						    	<div class="col-md-12">
						    		<div class="form-group row">
						    			<label class="col-md-2 control-label" style="text-align: left;">Ficha <?php echo $id; ?></label>
						    			<a href="<?php echo $url.'media/uploads/ficha'.$id.'.pdf' ?>" target="_blank"><i class="fa fa-file fa-2x"></i></a>
						            </div>
						            <div class="form-group row">
						    			<label class="col-md-3 control-label" style="text-align: left;">Ficha Peças <?php echo $id; ?></label>
						    			<a href="<?php echo $url.'media/uploads/ficha_pecas'.$id.'.pdf' ?>" target="_blank"><i class="fa fa-file fa-2x"></i></a>
						            </div>
						        </div>
						    </div>
				  		</div>
				  		<br>
				  		<center><button type="submit" class="btn btn-primary">Atualizar</button></center><br>
					   </div>
					  </form>
					  <?php
						}
					  ?>
				  </div>
	        </div>
	        <div class="col-lg-4">
	        	<div class="panel panel-primary">
	                <div class="panel-heading">
	                    <center><strong>Cuidado ao Alterar a Ficha</strong></center>
	                </div>
	                <div class="panel-body">
	                    <p>Os itens alterados nesta ficha serão reescritos no banco de dados e as informações anteriores não poderão ser mais recuperados.<br>Revise os dados antes de salvar.</p>
	                </div>
	            </div>
	        </div>
		</div>
	</div>
	<?php
}
?>
<!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    
    <script src="../js/script.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        
        $('#myTabs a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		})
    });
    
    $('#btn_adicionar_peca').click(function(){
	  var cod_peca = $("input[name='inputCodPeca']").val();
	  var retorno;
	  $.get('ajax_busca_peca.php?cod_peca=' + cod_peca,function(data){
	   	retorno = data;
	   	adicionarPeca(retorno);
	  });
	});
	
	var cont = 1;
	function adicionarPeca(retorno){
		if(($("input[name='inputQuantidade']").val())> 0){
			var tr = '<tr>'+
			'<td style="font-size:13px;"><input type="text" name="descricao[]" value="'+retorno+'" /></td>'+
			'<td style="text-align:center;font-size:13px;"><input type="text" name="codPeca[]" value="'+$("input[name='inputCodPeca']").val()+'" /></td>'+
			'<td style="text-align:center;font-size:13px;"><input type="text" name="quantidade[]" value="'+$("input[name='inputQuantidade']").val()+'" /></td>'+
			'<td style="text-align:center;font-size:13px;"><a class="remover" style="cursor:pointer;text-decoration:none" title="Excluir este produto">Remover</a></td>'+
			'</tr>'
			$('#grid').find('tbody').append( tr );
			
			cont++;
			return false;
		}
		else{
			alert('Quantidade deve ser maior que 0');
		}
	}
	
	function confirmaPedido(){
		var tamanho = $("#grid tbody tr").length;
		alert('Pedido Confirmado!');
		$('#totalRegistros').val(tamanho);
	}
		
	$("#grid").on("click", ".remover", function(e){
	    $(this).closest('tr').remove(); 
	    // Find and remove item from an array
	});

	function enviarDados(){
	  // converter o resultado pra json
	  $json = $("#grid").tableToJSON();
	  
	  // mostrar o resultado
	}
		
    (function($) {

	  RemoveTableRow = function(handler) {
	    var tr = $(handler).closest('tr');
	
	    tr.fadeOut(400, function(){ 
	      tr.remove(); 
	    }); 
	
	    return false;
	  };
	})(jQuery);
    
    </script>