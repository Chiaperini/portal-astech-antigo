<?php include('header.php'); 

$acao = $_GET['acao'];
?>
<script type="text/javascript">
	function ExecutaAcao(script){
        document.form_up_usuario.action = script;
        document.form_up_usuario.submit();
    }
</script>
<?php
if(usuarioestalogado()){
	if($acao == 'gerenciar'){
	?>
	<div id="page-wrapper">
		<div class="row">
	        <div class="col-lg-12">
	            <h1 class="page-header"><i class="fa fa-users fa-fw"></i> Usuários</h1>
	        </div>
	        <!-- /.col-lg-12 -->
	    </div>
	   	<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Assistentes Usuários Cadastrados
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email </th>
                                    <th>Status </th>
									<th>Ações</th>
                                    <th>Data Último Acesso</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
								$busca_usuarios = "SELECT * FROM usuarios";
								$result_usuarios = mysqli_query($mysqli, $busca_usuarios);
								
								while($row_usuarios = mysqli_fetch_assoc($result_usuarios)){
                            	?>
                                <tr class="even gradeC">
                                    <td><?php echo $row_usuarios['id']; ?></td>
                                    <td><a href="usuarios.php?acao=editar&id=<?php echo $row_usuarios['id']?>" target="_self"><?php echo $row_usuarios['nome']; ?></a></td>
                                    <td><?php echo $row_usuarios['email']; ?></td>
                                    <td class="center"><?php echo $row_usuarios['status']; ?></td>
									<td style="text-align:center;" ><a href="usuario-delete.php?deleteid=<?= $row_usuarios['id']; ?>">deletar</a></td>
                                    <td class="center"><?php echo $row_usuarios['data_ultimo_acesso']; ?></td>
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
	            <h1 class="page-header"><i class="fa fa-user fa-fw"></i> Editar Usuário</h1>
	        </div>
	        <!-- /.col-lg-12 -->
	    </div>
	     <div class="row">
		        <div class="col-lg-8">
		        	<div>
					  <!-- Nav tabs -->
					  <ul class="nav nav-tabs" role="tablist">
					    <li role="presentation" class="active"><a href="#cadastro" aria-controls="cadastro" role="tab" data-toggle="tab">Dados</a></li>
					    <li role="presentation"><a href="#senha" aria-controls="senha" role="tab" data-toggle="tab">Trocar Senha</a></li>
					  </ul>
					
					  <!-- Tab panes -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="cadastro">
					    	<div class="well well-lg">
				        		<?php
									$busca_usuario = "SELECT * FROM usuarios WHERE id = '$id'";
									$result_usuario = mysqli_query($mysqli, $busca_usuario);
									if($row_usuario = mysqli_fetch_assoc($result_usuario)){
				        		?>
					          	<form method="post" name="form_up_usuario" action="">
					          		<input type="hidden" name="input_id" value="<?php echo $id; ?>">
					          		<div class="form-group">
									    <label for="input_nome">Nome</label>
									    <input type="text" class="form-control" id="input_nome" name="input_nome" value="<?php echo utf8_encode($row_usuario['nome']); ?>">
									</div>
									<div class="form-group">
									    <label for="input_cnpj">CNPJ</label>
									    <input type="text" class="form-control" id="input_cnpj" name="input_cnpj" value="<?php echo $row_usuario['cnpj']; ?>" readonly>
									</div>
									<div class="form-group">
									    <label for="input_email">Email</label>
									    <input type="email" class="form-control" id="input_email" name="input_email" value="<?php echo $row_usuario['email']; ?>">
									</div>
									<div class="form-group">
									    <label for="select_status">Status</label>
									    <select class="form-control" id="select_status" name="select_status">
									    	<?php if($row_usuario['status'] == '0'){ $status = 'Inativo'; }else{ $status = 'Ativo'; } ?>
									    	<option value="<?php echo $row_usuario['status']; ?>"><?php echo $status; ?></option>
									    	<?php
									    	if($row_usuario['status'] == '0'){
									    		?>
									    		<option value="1">Ativo</option>
									    		<?php
									    	}
											else{
												?>
									    		<option value="0">Inativo</option>
									    		<?php
											}
									    	?>
		                                </select>
									</div>
								  	<button type="submit" class="btn btn-primary" onClick="if(confirm('Tem certeza que deseja enviar este email?')){ ExecutaAcao('enviar_email.php');}">Enviar Email</button>
									<button type="submit" class="btn btn-primary" onClick="ExecutaAcao('update.php?pagina=usuarios&local=cadastro');">Atualizar</button>
		
								</form>
								<?php
								}
								?>
							</div>	
					    </div>
					    <div role="tabpanel" class="tab-pane" id="senha">
					    	<div class="well well-lg">
					    		<form method="post" name="form_troca_senha" action="update.php?pagina=usuarios&local=senha">
					          		<input type="hidden" name="input_id" value="<?php echo $id; ?>">
					          		<div class="form-group">
									    <label for="input_nova_senha">Nova Senha</label>
									    <input type="password" class="form-control" id="input_nova_senha" name="input_nova_senha" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="A senha deve ter no mínimo 6 caracteres e conter números e letras maiúsculas e minúsculas">
									</div>
									<div class="form-group">
									    <label for="input_confirma_senha">Repita Nova Senha</label>
									    <input type="password" class="form-control" id="input_confirma_senha" name="input_confirma_senha" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="A senha deve ter no mínimo 6 caracteres e conter números e letras maiúsculas e minúsculas">
									</div>
									<input type="submit" class="btn btn-primary" value="Atualizar">
								</form>
					    	</div>
					    </div>
					    
					  </div>
					
					</div>
		        </div>
		        <div class="col-lg-4">
		        	<div class="panel panel-primary">
		                <div class="panel-heading">
		                    Atenção
		                </div>
		                <div class="panel-body">
		                    <p>Caso queira alterar o CNPJ, entre na área de edição do Assistente e altere por lá.</p>
		                </div>
		                <div class="panel-footer">
		                    &nbsp;
		                </div>
		            </div>
		        </div>
		    </div>
	</div>
	<?php
	}
}
else{
	echo '<script>alert("Nenhum usuário logado no sistema.");window.location.href="http://localhost/site_chiaperini/portal_astech/admin"</script>';
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