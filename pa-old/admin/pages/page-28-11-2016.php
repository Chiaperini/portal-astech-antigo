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
								    <input type="email" class="form-control" id="exampleInputNome" placeholder="Nome">
								  </div>
								  <div class="form-group">
								    <label for="exampleInputEmail1">Email</label>
								    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
								  </div>
								  <div class="form-group">
								  		<label for="exampleSelectPerfil">Perfil</label>
								  		<select id="exampleSelectPerfil" class="form-control">
										  	<option>Analista</option>
										  	<option>Administrador</option>
										</select>
								  </div>
								  <div class="form-group">
								    <label for="exampleInputPassword1">Senha</label>
								    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha">
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
	}
}
else{
	echo '<script>alert("Nenhum usuário logado no sistema.");window.location.href="http://portalastech.chiaperini.com.br/admin"</script>';
}

?>


<?php include('footer.php'); ?>