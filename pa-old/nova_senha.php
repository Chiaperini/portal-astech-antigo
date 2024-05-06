<?php 
include('header.php'); 

// Dados vindos pela url
$id = $_GET['id'];
$emailMd5 = $_GET['email'];
$uidMd5 = $_GET['uid'];
$dataMd5 = $_GET['key'];

//Buscar os dados no banco
$sql = "SELECT * FROM usuarios WHERE id = '{$id}'";
$result = mysqli_query($mysqli, $sql);
if($row = mysqli_fetch_assoc($result)){
	// Comparar os dados que pegamos no banco, com os dados vindos pela url
	$valido = true;
	
	if( $emailMd5 !== md5( $row['email'] ) )
	    $valido = false;
	
	if( $uidMd5 !== md5( $row['uid'] ) )
	    $valido = false;
	
	if( $dataMd5 !== md5( $row['data_cadastro'] ) )
	    $valido = false;
	
	// Os dados estão corretos, hora de ativar o cadastro
	if( $valido === true ) {
		
		$_SESSION['id_usuario'] = $id;
	   //Inserir Nova senha 
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
					<form class="form-horizontal" role="form" id="" method="post" action="<?php echo $url_atual;?>ativar_nova_senha/" enctype="multipart/form-data">
					    <div class="form-group">
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
					                     <input type="password" class="form-control" id="inputConfirmaSenha" name="inputConfirmaSenha" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="A senha deve ter no mínimo 6 caracteres e conter números e letras maiúsculas e minúsculas">
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
	
	} else {
		?>
		<div class="container container-maior">
			<div class="row">
				<div class="col-md-12 titulo_relatorio">
					<h1 class="text-center">Recuperação de Senha não autorizada!</h1>
				</div>
			</div>
		</div>
		<div class="container container-meio">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<h4 class="text-center texto_inicial">
						As informações não condizem com seus dados cadastrados em nossa base.<br>
						Por favor entre em contato com a nossa central de atendimento através do email portalastech@chiaperini.com.br
					</h4><br>
				</div>
			</div>
		</div>
		<?php
	}
}
?>
	<?php include('footer.php'); ?>
	</div>
</div>
</body>
</html>