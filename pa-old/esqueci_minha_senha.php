<?php
include_once('media/core/functions.php');
include('header.php');
?>
	<div class="container">
		<div class="row">
			<div class="col-md-12 titulo_relatorio">
				<h1 class="text-center">Recuperar Senha</h1>
			</div>
		</div>
	</div>
	<div class="container" style="padding:50px 0px 90px 0px;">
		<div class="row">
			<div class="col-xs-12 col-md-4 col-md-offset-4">
				<form class="form-horizontal" role="form" id="" method="post" action="<?php echo $url_atual;?>recuperar_senha/" enctype="multipart/form-data">
				    <div class="form-group">
				        <div class="col-md-12">
				            <div class="form-group row">
				                <label for="emailCadastrado" class="col-md-4 control-label" style="text-align: left;">Email cadastrado</label>
				                <div class="col-md-8">
				                     <input type="text" class="form-control" id="emailCadastrado" name="emailCadastrado">
				                </div>
				            </div>
				         </div>
				         <div class="form-group">
					        <div class="col-md-12 text-center">
					            <div class="form-group row">
					    			<button type="submit" id="btn_enviar" class="btn btn-warning">Enviar</button>
					    		</div>
					    	</div>
					    </div>
				    </div>
				  </form>
			</div>
		</div>
	</div>
					   
	<?php
	include('footer.php');
	?>
