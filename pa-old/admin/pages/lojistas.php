<?php include('header.php'); 

$acao = $_GET['acao'];

?>
<script type="text/javascript">
	function buscar_cidades(){
      var estado = $('#select_estado_lojista').val();  //codigo do estado escolhido
      //se encontrou o estado
      if(estado){
        var url = 'ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD
        $.get(url, function(dataReturn) {
          $('#select_cidade_lojista').html(dataReturn);  //coloco na div o retorno da requisicao
        });
      }
    }
    function alterarStatus(id, status){
    	var id_lojista = id;
    	var status = status;
    	if(id_lojista){
    		var url = 'ajax_altera_status_lojista.php?id='+id_lojista+'&status='+status;
    		$.get(url, function(dataReturn){
	        	alert(dataReturn);
	        	window.location.href = "/portal-astech/public_html/admin/pages/lojistas.php?acao=gerenciar";
	        });
    	}
    }
</script>

<?php
if(usuarioestalogado()){
	if($acao == 'gerenciar'){
	?>
	<div id="page-wrapper">
		<div class="row">
	        <div class="col-lg-12">
	            <h1 class="page-header"><i class="fa fa-users fa-fw"></i> Lojistas</h1>
	        </div>
	        <!-- /.col-lg-12 -->
	    </div>
	   	<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Lojistas Cadastrados
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example2">
                            <thead>
                                <tr>
                                    <th width="7%">ID</th>
                                    <th>Nome da Empresa</th>
                                    <th>Email </th>
                                    <th width="10%">Status </th>
                                    <th>Data</th>
                                    <th width="12%">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
								$busca_lojistas = "SELECT * FROM lojistas";
								$result_lojistas = mysqli_query($mysqli, $busca_lojistas);
								
								while($row_lojistas = mysqli_fetch_assoc($result_lojistas)){
                            	?>
                                <tr class="even gradeC">
                                    <td><center><?php echo $row_lojistas['id']; ?></center></td>
                                    <td><a href="lojistas.php?acao=editar&id=<?php echo $row_lojistas['id']?>" target="_self"><?php echo $row_lojistas['nome_empresa']; ?></a></td>
                                    <td><?php echo $row_lojistas['email']; ?></td>
                                    <td><center><?php echo $row_lojistas['status']; ?></center></td>
                                    <td class="center"><?php echo date('d/m/Y', strtotime($row_lojistas['data_insercao'])); ?></td>
                                    <td style="display:flex; justify-content: center; gap: 10px;">
										<center><?php if($row_lojistas['status'] == 0 ){ ?><a href="#" onclick=" if(confirm('Tem certeza que deseja alterar o status deste Lojista?') == true) { alterarStatus(<?php echo $row_lojistas['id']; ?>, <?php echo $row_lojistas['status']; ?>) }" title="Ativar"><i class="fa fa-user-plus fa-fw"></i></a><?php } else{ ?><a href="#" onclick="if(confirm('Tem certeza que deseja alterar o status deste Lojista?') == true) { alterarStatus(<?php echo $row_lojistas['id']; ?>,<?php echo $row_lojistas['status']; ?>) }" title="Desativar"><i class="fa fa-user-times fa-fw"></i></a><?php }?>
										</center>

										<center>
									
											<a href="lojista-delete.php?deleteid=<?= $row_lojistas['id']; ?>">deletar</a>

										</center>
									</td>
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
	            <h1 class="page-header"><i class="fa fa-user fa-fw"></i> Editar Lojista</h1>
	        </div>
	        <!-- /.col-lg-12 -->
	    </div>
	     <div class="row">
		        <div class="col-lg-8">
		        	<div class="well well-lg">
		        		<?php
							$busca_lojista = "SELECT * FROM lojistas WHERE id = '$id'";
							$result_lojista = mysqli_query($mysqli, $busca_lojista);
							if($row_lojista = mysqli_fetch_assoc($result_lojista)){
		        		?>
			          	<form method="post" action="update.php?pagina=lojistas">
			          		<input type="hidden" name="input_id_lojista" value="<?php echo $id; ?>">

							<div class="form-group">
							    <label for="input_codigo_lojista">Codigo</label>
							    <input type="text" required class="form-control" id="input_codigo_lojista" name="input_codigo_lojista" value="<?php echo utf8_encode($row_lojista['codigo']); ?>">
							</div>
			          		<div class="form-group">
							    <label for="input_nome_empresa_lojista">Nome da Empresa</label>
							    <input type="text" required class="form-control" id="input_nome_empresa_lojista" name="input_nome_empresa_lojista" value="<?php echo utf8_encode($row_lojista['nome_empresa']); ?>">
							</div>
							<div class="form-group">
							    <label for="input_cnpj_lojista">CNPJ</label>
							    <input type="text" required class="form-control" id="input_cnpj_lojista" name="input_cnpj_lojista" value="<?php echo $row_lojista['CNPJ']; ?>">
							</div>
							<div class="form-group">
							    <label for="input_email_lojista">Email</label>
							    <input type="email" required class="form-control" id="input_email_lojista" name="input_email_lojista" value="<?php echo $row_lojista['email']; ?>">
							</div>
							<div class="form-group">
							    <label for="input_nome_fantasia_lojista">Nome Fantasia</label>
							    <input type="text" required class="form-control" id="input_nome_fantasia_lojista" name="input_nome_fantasia_lojista" value="<?php echo utf8_encode($row_lojista['nome_fantasia']); ?>">
							</div>
							<div class="form-group">
							    <label for="input_endereco_lojista">Endereço</label>
							    <input type="text" class="form-control" id="input_endereco_lojista" name="input_endereco_lojista" value="<?php echo utf8_encode($row_lojista['endereco']); ?>">
							</div>
							<div class="form-group">
							    <label for="input_complemento_lojista">Complemento</label>
							    <input type="text" class="form-control" id="input_complemento_lojista" name="input_complemento_lojista" value="<?php echo $row_lojista['complemento']; ?>">
							</div>
							<div class="form-group">
							    <label for="input_bairro_lojista">Bairro</label>
							    <input type="text" class="form-control" id="input_bairro_lojista" name="input_bairro_lojista" value="<?php echo utf8_encode($row_lojista['bairro']); ?>">
							</div> 
							<div class="form-group">
							    <label for="input_cep_lojista">CEP</label>
							    <input type="text" class="form-control input_cep" id="input_cep_lojista" name="input_cep_lojista" value="<?php echo $row_lojista['cep']; ?>">
							</div>
							<div class="form-group">
							    <label for="select_estado_lojista">Estado</label>
							     <select class="form-control" id="select_estado_lojista" name="select_estado_lojista" onchange="buscar_cidades();">
							     	<?php
									$busca_estado = "SELECT * FROM estado WHERE id = '{$row_lojista['estado']}'";
									$result_estado = mysqli_query($mysqli, $busca_estado);
									if($row_estado = mysqli_fetch_assoc($result_estado)){
					        		?>
	                                <option value="<?php echo $row_estado['id']; ?>"><?php echo utf8_encode($row_estado['nome']); ?></option>
	                                <?php
									}
									$busca_estados = "SELECT * FROM estado WHERE id <> '{$row_lojista['estado']}' ";
									$result_estados = mysqli_query($mysqli, $busca_estados);
									while($row_estados = mysqli_fetch_assoc($result_estados)){
	                                ?>
	                                <option value="<?php echo $row_estados['id']; ?>"><?php echo utf8_encode($row_estados['nome']); ?></option>
	                                <?php
									}
	                                ?>
	                            </select>
							</div>
							<div class="form-group">
							    <label for="select_cidade_lojista">Cidade</label>
							    <select id="select_cidade_lojista" name="select_cidade_lojista" class="form-control" >
							    <?php
									$busca_cidade = "SELECT * FROM cidade WHERE cod_ibge = '{$row_lojista['cod_cidade']}' AND estado = '{$row_lojista['estado']}'";
									$result_cidade = mysqli_query($mysqli, $busca_cidade);
									if($row_cidade = mysqli_fetch_assoc($result_cidade)){
					        		?>
	                                <option value="<?php echo $row_cidade['cod_ibge'];?>"><?php echo utf8_encode($row_cidade['nome']); ?></option>
	                                <?php
									}
	                            ?>
	                        	</select>
							</div>
							<div class="form-group">
								<label for="input_telefone_lojista">Telefone</label>
								<div class="col-md-12" style="padding:0px 0px 10px 0px;">
								    <div class="col-md-2" style="padding:0;">
								    	<input type="text" class="form-control" id="input_ddd_lojista" name="input_ddd_lojista" value="<?php echo $row_lojista['ddd']; ?>">
								    </div>
								    <div class="col-md-10 " style="padding:0 0 0 10px;">
								    	<input type="text" class="form-control input_telefone_lojista" id="input_telefone_lojista" name="input_telefone_lojista"  value="<?php echo $row_lojista['telefone']; ?>">
									</div>
								</div>
							</div>
							<div class="form-group">
							    <label for="input_inscricao_estadual_lojista">Inscrição Estadual</label>
							    <input type="text" class="form-control" id="input_inscricao_estadual_lojista" name="input_inscricao_estadual_lojista" value="<?php echo $row_lojista['inscricao_estadual']; ?>">
							</div>
						  	<button type="submit" class="btn btn-primary">Atualizar</button>
						</form>
						<?php
						}
						?>
					</div>
		        </div>
		        <div class="col-lg-4">
		        	<div class="panel panel-primary">
		                <div class="panel-heading">
		                    Atenção
		                </div>
		                <div class="panel-body">
		                    <p>Lembre-se de revisar os dados antes de salvar, pois as informações anteriores serão perdidas após clicar em atualizar.</p>
		                </div>
		            </div>
		        </div>
		    </div>
	</div>
	<?php
	}
	if($acao == 'adicionar'){
	?>
	<div id="page-wrapper">
		<div class="row">
	        <div class="col-lg-12">
	            <h1 class="page-header"><i class="fa fa-user-plus fa-fw"></i> Adicionar Lojista</h1>
	        </div>
	        <!-- /.col-lg-12 -->
	    </div>
	    <div class="row">
	        <div class="col-lg-8">
	        	<div class="well well-lg">
		          	<form method="post" action="insert.php?pagina=lojistas">
		          		<input type="hidden" name="input_id_lojista" value="<?php echo $id; ?>">
<div class="form-group">
							    <label for="input_codigo_lojista">Codigo</label>
							    <input type="text" required class="form-control" id="input_codigo_lojista" name="input_codigo_lojista" value="">
							</div>

		          		<div class="form-group">
						    <label for="input_nome_empresa_lojista">Nome da Empresa</label>
						    <input type="text" required class="form-control" id="input_nome_empresa_lojista" name="input_nome_empresa_lojista" value="">
						</div>
						<div class="form-group">
						    <label for="input_cnpj_lojista">CNPJ</label>
						    <input type="text" required class="form-control input_cnpj" id="input_cnpj_lojista" name="input_cnpj_lojista" value="">
						</div>
						<div class="form-group">
						    <label for="input_email_lojista">Email</label>
						    <input type="email" required class="form-control" id="input_email_lojista" name="input_email_lojista" value="">
						</div>
						<div class="form-group">
						    <label for="input_nome_fantasia_lojista">Nome Fantasia</label>
						    <input type="text" required class="form-control" id="input_nome_fantasia_lojista" name="input_nome_fantasia_lojista" value="">
						</div>
						<div class="form-group">
						    <label for="input_endereco_lojista">Endereço</label>
						    <input type="text" class="form-control" id="input_endereco_lojista" name="input_endereco_lojista" value="">
						</div>
						<div class="form-group">
						    <label for="input_complemento_lojista">Complemento</label>
						    <input type="text" class="form-control" id="input_complemento_lojista" name="input_complemento_lojista" value="">
						</div>
						<div class="form-group">
						    <label for="input_bairro_lojista">Bairro</label>
						    <input type="text" class="form-control" id="input_bairro_lojista" name="input_bairro_lojista" value="">
						</div> 
						<div class="form-group">
						    <label for="input_cep_lojista">CEP</label>
						    <input type="text" class="form-control input_cep" id="input_cep_lojista" name="input_cep_lojista" value="">
						</div>
						<div class="form-group">
						    <label for="select_estado_lojista">Estado</label>
						     <select class="form-control" id="select_estado_lojista" name="select_estado_lojista" onchange="buscar_cidades();">
						     	<option value="">Selecione um estado</option>
								<?php
								$busca_estados = "SELECT * FROM estado ";
								$result_estados = mysqli_query($mysqli, $busca_estados);
								while($row_estados = mysqli_fetch_assoc($result_estados)){
                                ?>
                                <option value="<?php echo $row_estados['id']; ?>"><?php echo utf8_encode($row_estados['nome']); ?></option>
                                <?php
								}
                                ?>	
                            </select>
						</div>
						<div class="form-group">
						    <label for="select_cidade_lojista">Cidade</label>
						    <select id="select_cidade_lojista" name="select_cidade_lojista" class="form-control" >
						   		<option value=""></option>
                            </select>
						</div>
						<div class="form-group">
							<label for="input_telefone_lojista">Telefone</label>
							<div class="col-md-12" style="padding:0px 0px 10px 0px;">
							    <div class="col-md-2" style="padding:0;">
							    	<input type="text" class="form-control input_ddd" id="input_ddd_lojista" name="input_ddd_lojista" value="" placeholder="(xx)">
							    </div>
							    <div class="col-md-10 " style="padding:0 0 0 10px;">
							    	<input type="text" class="form-control input_telefone" id="input_telefone_lojista" name="input_telefone_lojista"  value="" placeholder="xxxx xxxx">
								</div>
							</div>
						</div>
						<div class="form-group">
						    <label for="input_inscricao_estadual_lojista">Inscrição Estadual</label>
						    <input type="text" class="form-control" id="input_inscricao_estadual_lojista" name="input_inscricao_estadual_lojista" value="">
						</div>
					  	<button type="submit" class="btn btn-primary">Inserir</button>
					</form>
				</div>
	        </div>
	        <div class="col-lg-4">
	        	<div class="panel panel-primary">
	                <div class="panel-heading">
	                    Primary Panel
	                </div>
	                <div class="panel-body">
	                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
	                </div>
	                <div class="panel-footer">
	                    Panel Footer
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<?php
	}
}
else{
	echo '<script>alert("Nenhum usuário logado no sistema.");window.location.href="/portal-astech/public_html/admin"</script>';
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

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example2').DataTable({
            responsive: true
        });
    });
    </script>