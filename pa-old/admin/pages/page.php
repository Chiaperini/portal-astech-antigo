<?php include('header.php'); 

$pagina = $_GET['pagina'];
$acao = $_GET['acao'];

if(usuarioestalogado()){
	if($pagina == 'usuarios'){
		if($acao == 'adicionar'){
			?>
			<div id="page-wrapper">
				<div class="row">
			        <div class="col-lg-12">
			            <h1 class="page-header"><i class="fa fa-user-plus fa-fw"></i> Usuários</h1>
			        </div>
			        <!-- /.col-lg-12 -->
			    </div>
			    <div class="row">
			        <div class="col-lg-8">
			        	<div class="well well-lg">
				          	<form method="post" action="insert.php?pagina=usuarios">
				          		<div class="form-group">
								    <label for="exampleInputNome">Nome</label>
								    <input type="nome" name="nome" class="form-control" id="exampleInputNome" placeholder="Nome">
								  </div>
								  <div class="form-group">
								    <label for="exampleInputEmail1">Email</label>
								    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
								  </div>
								  <div class="form-group">
								  		<label for="exampleSelectPerfil">Perfil</label>
								  		<select name="perfil" id="exampleSelectPerfil" class="form-control">
										  	<option value="analista">Analista</option>
										  	<option value="administrador">Administrador</option>
										</select>
								  </div>
								  <div class="form-group">
								    <label for="exampleInputPassword1">Senha</label>
								    <input type="password" name="senha" class="form-control" id="exampleInputPassword1" placeholder="Senha">
								  </div>
							  	  <button type="submit" class="btn btn-primary">Adicionar</button>
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
		                        Usuários Cadastrados
		                    </div>
		                    <!-- /.panel-heading -->
		                    <div class="panel-body">
		                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		                            <thead>
		                                <tr>
		                                    <th width="7%">ID</th>
		                                    <th>Nome</th>
		                                    <th>Email </th>
		                                    <th width="10%">Perfil </th>
		                                    <th>Data</th>
		                                    <th width="12%">Ação</th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                            	<?php
										$busca_usuarios_admin = "SELECT * FROM usuarios_admin";
										$result_usuarios_admin = mysqli_query($mysqli, $busca_usuarios_admin);
										
										while($row_usuarios_admin = mysqli_fetch_assoc($result_usuarios_admin)){
		                            	?>
		                                <tr class="even gradeC">
		                                    <td><center><?php echo $row_usuarios_admin['id']; ?></center></td>
		                                    <td><a href="usuarios_admin.php?acao=editar&id=<?php echo $row_usuarios_admin['id']?>" target="_self"><?php echo $row_usuarios_admin['nome']; ?></a></td>
		                                    <td><?php echo $row_usuarios_admin['email']; ?></td>
		                                    <td><center><?php echo $row_usuarios_admin['perfil']; ?></center></td>
		                                    <td class="center"><?php echo $row_usuarios_admin['data_cadastro']; ?></td>
		                                    <td><center><a onclick="return confirm('Tem certeza que deseja excluir esse usuário?')" href="delete.php?pagina=usuarios_admin&id=<?php echo $row_usuarios_admin['id']; ?>" target="_self">Excluir</a></center></td>
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
	}
}
else{
	echo '<script>alert("Nenhum usuário logado no sistema.");window.location.href="http://localhost/site_chiaperini/portal_astech/admin"</script>';
}

?>


<?php include('footer.php'); ?>