<?php
include_once('media/core/functions.php');

if(usuarioestalogado()){	
	include('header.php');
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-12 titulo_relatorio">
				<h1 class="text-center">Alterar Senha</h1>
			</div>
		</div>
	</div>
	<div class="container" style="padding:20px 0px;">
		<div class="row">
			<div class="col-xs-12 col-md-4 col-md-offset-4">
				<form class="form-horizontal" role="form" id="" method="post" action="<?php echo $url_atual;?>trocar_senha/" enctype="multipart/form-data">
				    <div class="form-group">
				        <div class="col-md-12">
				            <div class="form-group row">
				                <label for="inputSenhaAtual" class="col-md-4 control-label" style="text-align: left;">Senha Atual</label>
				                <div class="col-md-8">
				                     <input type="password" class="form-control" id="inputSenhaAtual" name="inputSenhaAtual">
				                </div>
				            </div>
				        </div>
				        <div class="col-md-12">
				            <div class="form-group row">
				                <label for="inputNovaSenha" class="col-md-4 control-label" style="text-align: left;">Nova Senha</label>
				                <div class="col-md-8">
				                     <input type="password" class="form-control" id="inputNovaSenha" name="inputNovaSenha" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="A senha deve ter no mínimo 6 caracteres e conter números e letras maiúsculas e minúsculas">
				                </div>
				            </div>
				        </div>
				        <div class="col-md-12">
				            <div class="form-group row">
				                <label for="inputConfirmaSenha" class="col-md-4 control-label" style="text-align: left;">Repita a Senha</label>
				                <div class="col-md-8">
				                     <input type="password" class="form-control" id="inputConfirmaSenha" name="inputConfirmaSenha">
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
}