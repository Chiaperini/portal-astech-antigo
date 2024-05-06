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
    function alterarStatus(id, status){
    	var id_assistente = id;
    	var status = status;
    	if(id_assistente){
    		var url = 'ajax_altera_status.php?id='+id_assistente+'&status='+status;
    		$.get(url, function(dataReturn) {
	        	alert(dataReturn);
	        	window.location.href = "http://portalastech.chiaperini.com.br/admin/pages/assistentes.php?acao=gerenciar";
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
	            <h1 class="page-header"><i class="fa fa-users fa-fw"></i> Assistentes</h1>
	        </div>
	        <!-- /.col-lg-12 -->
	    </div>
	   	<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Assistentes Cadastrados
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
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
								$busca_assistentes = "SELECT * FROM assistentes";
								$result_assistentes = mysqli_query($mysqli, $busca_assistentes);
								
								while($row_assistentes = mysqli_fetch_assoc($result_assistentes)){
                            	?>
                                <tr class="even gradeC">
                                    <td><center><?php echo $row_assistentes['id']; ?></center></td>
                                    <td><a href="assistentes.php?acao=editar&id=<?php echo $row_assistentes['id']?>" target="_self"><?php echo $row_assistentes['nome_empresa']; ?></a></td>
                                    <td><?php echo $row_assistentes['email']; ?></td>
                                    <td><center><?php echo $row_assistentes['status']; ?></center></td>
                                    <td class="center"><?php echo date('d/m/Y', strtotime($row_assistentes['data_insercao'])); ?></td>
                                    <td style="display:flex; justify-content: center; gap: 10px;">

										<center>
											
											<?php if($row_assistentes['status'] == 0 ){ ?><a href="#" onclick=" if(confirm('Tem certeza que deseja alterar o status deste Assistente?') == true) { alterarStatus(<?php echo $row_assistentes['id']; ?>, <?php echo $row_assistentes['status']; ?>) }" title="Ativar"><i class="fa fa-user-plus fa-fw"></i></a><?php } else{ ?><a href="#" onclick="if(confirm('Tem certeza que deseja alterar o status deste Assistente?') == true) { alterarStatus(<?php echo $row_assistentes['id']; ?>,
											
											<?php echo $row_assistentes['status']; ?>) }" title="Desativar"><i class="fa fa-user-times fa-fw"></i></a><?php }?>

										</center>

										<center>
									
										<a href="assistente-delete.php?deleteid=<?= $row_assistentes['id']; ?>">deletar</a>

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
	            <h1 class="page-header"><i class="fa fa-user fa-fw"></i> Editar Assistente</h1>
	        </div>
	        <!-- /.col-lg-12 -->
	    </div>
	     <div class="row">
		        <div class="col-lg-8">
		        	<div class="well well-lg">
		        		<?php
							$busca_assistente = "SELECT * FROM assistentes WHERE id = '$id'";
							$result_assistente = mysqli_query($mysqli, $busca_assistente);
							if($row_assistentes = mysqli_fetch_assoc($result_assistente)){
		        		?>
			          	<form method="post" action="update.php?pagina=assistentes">
			          		<input type="hidden" name="input_id" value="<?php echo $id; ?>">

			<div class="form-group">
							    <label for="input_codigo_assistente">Codigo</label>
							    <input type="text" required class="form-control" id="input_codigo_assistente" name="input_codigo_assistente" value="<?php echo utf8_encode($row_assistentes['codigo']); ?>">
							</div>
			          		<div class="form-group">
							    <label for="input_nome_empresa">Nome da Empresa</label>
							    <input type="text" required class="form-control" id="input_nome_empresa" name="input_nome_empresa" value="<?php echo utf8_encode($row_assistentes['nome_empresa']); ?>">
							</div>
							<div class="form-group">
							    <label for="input_cnpj">CNPJ</label>
							    <input type="text" required class="form-control input_cnpj" id="input_cnpj" name="input_cnpj" value="<?php echo $row_assistentes['CNPJ']; ?>">
							</div>
							<div class="form-group">
							    <label for="input_email">Email</label>
							    <input type="email" required class="form-control" id="input_email" name="input_email" value="<?php echo $row_assistentes['email']; ?>">
							</div>
							<div class="form-group">
							    <label for="input_nome_fantasia">Nome Fantasia</label>
							    <input type="text" required class="form-control" id="input_nome_fantasia" name="input_nome_fantasia" value="<?php echo utf8_encode($row_assistentes['nome_fantasia']); ?>">
							</div>
							<div class="form-group">
							    <label for="input_endereco">Endereço</label>
							    <input type="text"  class="form-control" id="input_endereco" name="input_endereco" value="<?php echo utf8_encode($row_assistentes['endereco']); ?>">
							</div>
							<div class="form-group">
							    <label for="input_complemento">Complemento</label>
							    <input type="text" class="form-control" id="input_complemento" name="input_complemento" value="<?php echo $row_assistentes['complemento']; ?>">
							</div>
							<div class="form-group">
							    <label for="input_bairro">Bairro</label>
							    <input type="text" class="form-control" id="input_bairro" name="input_bairro" value="<?php echo utf8_encode($row_assistentes['bairro']); ?>">
							</div> 
							<div class="form-group">
							    <label for="input_cep">CEP</label>
							    <input type="text"  class="form-control input_cep" id="input_cep" name="input_cep" value="<?php echo $row_assistentes['cep']; ?>">
							</div>
							<div class="form-group">
							    <label for="select_estado">Estado</label>
							     <select class="form-control" id="select_estado" name="select_estado" onchange="buscar_cidades();">
							     	<?php
									$busca_estado = "SELECT * FROM estado WHERE id = '{$row_assistentes['estado']}'";
									$result_estado = mysqli_query($mysqli, $busca_estado);
									if($row_estado = mysqli_fetch_assoc($result_estado)){
					        		?>
	                                <option value="<?php echo $row_estado['id']; ?>"><?php echo utf8_encode($row_estado['nome']); ?></option>
	                                <?php
									}
									$busca_estados = "SELECT * FROM estado WHERE id <> '{$row_assistentes['estado']}' ";
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
							    <label for="select_cidade">Cidade</label>
							    <select id="select_cidade" name="select_cidade" class="form-control" >
							    <?php
									$busca_cidade = "SELECT * FROM cidade WHERE cod_ibge = '{$row_assistentes['cod_cidade']}' AND estado = '{$row_assistentes['estado']}'";
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
								<label for="input_telefone">Telefone</label>
								<div class="col-md-12" style="padding:0px 0px 10px 0px;">
								    <div class="col-md-2" style="padding:0;">
								    	<input type="text" required class="form-control" id="input_ddd" name="input_ddd" value="<?php echo $row_assistentes['ddd']; ?>">
								    </div>
								    <div class="col-md-10 " style="padding:0 0 0 10px;">
								    	<input type="text" required class="form-control input_telefone" id="input_telefone" name="input_telefone"  value="<?php echo $row_assistentes['telefone']; ?>">
									</div>
								</div>
							</div>
							<div class="form-group">
							    <label for="input_inscricao_estadual">Inscrição Estadual</label>
							    <input type="text" class="form-control" id="input_inscricao_estadual" name="input_inscricao_estadual" value="<?php echo $row_assistentes['inscricao_estadual']; ?>">
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
	            <h1 class="page-header"><i class="fa fa-user-plus fa-fw"></i> Adicionar Assistente</h1>
	        </div>
	        <!-- /.col-lg-12 -->
	    </div>
	    <div class="row">
	        <div class="col-lg-8">
	        	<div class="well well-lg">
		          	<form method="post" action="insert.php?pagina=assistentes">
		          		<input type="hidden" name="input_id" value="<?php echo $id; ?>">
<div class="form-group">
							    <label for="input_codigo_assistente">Codigo</label>
							    <input type="text" required class="form-control" id="input_codigo_assistente" name="input_codigo_assistente" value="">
							</div>

		          		<div class="form-group">
						    <label for="input_nome_empresa">Nome da Empresa</label>
						    <input type="text" required class="form-control" id="input_nome_empresa" name="input_nome_empresa" value="">
						</div>
						<div class="form-group">
						    <label for="input_cnpj">CNPJ</label>
						    <input type="text" required class="form-control input_cnpj" id="input_cnpj" name="input_cnpj" value="">
						</div>
						<div class="form-group">
						    <label for="input_email">Email</label>
						    <input type="email" required class="form-control" id="input_email" name="input_email" value="">
						</div>
						<div class="form-group">
						    <label for="input_nome_fantasia">Nome Fantasia</label>
						    <input type="text" required class="form-control" id="input_nome_fantasia" name="input_nome_fantasia" value="">
						</div>
						<div class="form-group">
						    <label for="input_endereco">Endereço</label>
						    <input type="text" class="form-control" id="input_endereco" name="input_endereco" value="">
						</div>
						<div class="form-group">
						    <label for="input_complemento">Complemento</label>
						    <input type="text" class="form-control" id="input_complemento" name="input_complemento" value="">
						</div>
						<div class="form-group">
						    <label for="input_bairro">Bairro</label>
						    <input type="text" class="form-control" id="input_bairro" name="input_bairro" value="">
						</div> 
						<div class="form-group">
						    <label for="input_cep">CEP</label>
						    <input type="text" class="form-control input_cep" id="input_cep" name="input_cep" value="">
						</div>
						<div class="form-group">
						    <label for="select_estado">Estado</label>
						     <select class="form-control" id="select_estado" name="select_estado" onchange="buscar_cidades();">
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
						    <label for="select_cidade">Cidade</label>
						    <select id="select_cidade" name="select_cidade" class="form-control" >
						   		<option value=""></option>
                            </select>
						</div>
						<div class="form-group">
							<label for="input_telefone">Telefone</label>
							<div class="col-md-12" style="padding:0px 0px 10px 0px;">
							    <div class="col-md-2" style="padding:0;">
							    	<input type="text" required class="form-control input_ddd" id="input_ddd" name="input_ddd" value="" placeholder="(xx)">
							    </div>
							    <div class="col-md-10 " style="padding:0 0 0 10px;">
							    	<input type="text" required class="form-control input_telefone" id="input_telefone" name="input_telefone"  value="" placeholder="xxxx xxxx">
								</div>
							</div>
						</div>
						<div class="form-group">
						    <label for="input_inscricao_estadual">Inscrição Estadual</label>
						    <input type="text"  class="form-control" id="input_inscricao_estadual" name="input_inscricao_estadual" value="">
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
	echo '<script>alert("Nenhum usuário logado no sistema.");window.location.href="http://portalastech.chiaperini.com.br/admin"</script>';
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
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

<script>
	function deleteAssistente(id) {
		if (confirm('Tem certeza que deseja deletar este Assistente?')) {
			// You can use AJAX to send the request to the server to delete the Assistente
			// Example using jQuery:
			$.ajax({
				type: 'POST',
				url: 'delete_assistente.php', // Replace with your server-side script for deletion
				data: { id: id },
				success: function (response) {
					// Handle the response from the server, e.g., remove the row from the table
					if (response === 'success') {
						alert('Assistente deletado com sucesso.');
						location.reload(); // Refresh the page
					} else {
						alert('Falha ao deletar o Assistente.');
					}
				}
			});
		}
	}
</script>
