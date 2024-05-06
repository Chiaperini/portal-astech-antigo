<?php 
include('header.php'); 
$acao = $_GET['acao'];
$id = $_GET['id'];

if(usuarioestalogado()){
	if($acao == 'editar'){
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
	        	<div class="well well-lg">
	        		<?php
						$busca_usuario = "SELECT * FROM usuarios_admin WHERE id = '$id'";
						$result_usuario = mysqli_query($mysqli, $busca_usuario);
						if($row_usuario = mysqli_fetch_assoc($result_usuario)){
	        		?>
		          	<form method="post" action="update.php?pagina=usuarios_admin">
		          		<input type="hidden" name="input_id" value="<?php echo $id; ?>">
		          		<div class="form-group">
						    <label for="input_nome_empresa">Nome</label>
						    <input type="text" class="form-control" id="input_nome" name="input_nome" value="<?php echo utf8_encode($row_usuario['nome']); ?>">
						</div>
						<div class="form-group">
						    <label for="input_email">Email</label>
						    <input type="email" class="form-control" id="input_email" name="input_email" value="<?php echo $row_usuario['email']; ?>">
						</div>
						 <div class="form-group">
					  		<label for="perfil">Perfil</label>
					  		<select name="perfil" id="perfil" class="form-control">
					  			<?php
					  				if($row_usuario['perfil'] == 'admin'){
					  					?>
					  					<option value="admin">Administrador</option>
					  					<option value="analista">Analista</option>
					  					<?php
					  				}
									else{
										?>
										<option value="analista">Analista</option>
										<option value="admin">Administrador</option>
										<?php
									}
					  			?>
							</select>
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
}
?>