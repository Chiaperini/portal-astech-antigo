<?php
include_once('media/core/functions.php');

$perfil = $_SESSION['perfil'];
$tabela = $perfil."s";

if(usuarioestalogado()){	
	include('header.php');
	?>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#input_cnpj").mask("99.999.999/9999-99");
	});

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
	</script>
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 titulo_relatorio">
				<h1 class="text-center">Meu cadastro</h1>
				<h5 class="text-center" style="line-height:20px;">É importante manter o seu cadastro atualizado.<br>Caso tenha alterado algum dos campos abaixo, corrija-os e atualize.</h5>
			</div>
		</div>
	</div>
	<div class="container" style="padding:20px 0px;">
		<div class="row">
			<div class="col-xs-12 col-md-6 col-md-offset-3">
				<div class="row">
		        	<div class="well well-lg">
		        		<?php
							$busca_usuario = "SELECT * FROM $tabela WHERE email = '{$_SESSION['usuario_logado']}'";
							$result_usuario = mysqli_query($mysqli, $busca_usuario);
							if($row_usuario = mysqli_fetch_assoc($result_usuario)){
		        		?>
			          	<form method="post" action="update.php?pagina=<?php echo $tabela; ?>">
			          		<input type="hidden" name="input_codigo_assistente" value="<?php echo utf8_encode($row_usuario['codigo']); ?>">
			          		<div class="form-group">
							    <label for="input_nome_empresa">Nome da Empresa</label>
							    <input type="text" class="form-control" id="input_nome_empresa" name="input_nome_empresa" value="<?php echo utf8_encode($row_usuario['nome_empresa']); ?>">
							</div>
							<div class="form-group">
							    <label for="input_cnpj">CNPJ</label>
							    <input type="text" class="form-control input_cnpj" id="input_cnpj" name="input_cnpj" value="<?php echo utf8_encode($row_usuario['CNPJ']); ?>">
							</div>
							<div class="form-group">
							    <label for="input_email">Email</label>
							    <input type="email" class="form-control" id="input_email" name="input_email" value="<?php echo utf8_encode($row_usuario['email']); ?>">
							</div>
							<div class="form-group">
							    <label for="input_nome_fantasia">Nome Fantasia</label>
							    <input type="text" class="form-control" id="input_nome_fantasia" name="input_nome_fantasia" value="<?php echo utf8_encode($row_usuario['nome_fantasia']); ?>">
							</div>
							<div class="form-group">
							    <label for="input_endereco">Endereço</label>
							    <input type="text" class="form-control" id="input_endereco" name="input_endereco" value="<?php echo utf8_encode($row_usuario['endereco']); ?>">
							</div>
							<div class="form-group">
							    <label for="input_complemento">Complemento</label>
							    <input type="text" class="form-control" id="input_complemento" name="input_complemento" value="<?php echo utf8_encode($row_usuario['complemento']); ?>">
							</div>
							<div class="form-group">
							    <label for="input_bairro">Bairro</label>
							    <input type="text" class="form-control" id="input_bairro" name="input_bairro" value="<?php echo utf8_encode($row_usuario['bairro']); ?>">
							</div> 
							<div class="form-group">
							    <label for="input_cep">CEP</label>
							    <input type="text" class="form-control input_cep" id="input_cep" name="input_cep" value="<?php echo utf8_encode($row_usuario['cep']); ?>">
							</div>
							<div class="form-group">
							    <label for="select_estado">Estado</label>
							    <select class="form-control" id="select_estado" name="select_estado" onchange="buscar_cidades();">
	                            	<?php
									$busca_estado = "SELECT * FROM estado WHERE id = '{$row_usuario['estado']}'";
									$result_estado = mysqli_query($mysqli, $busca_estado);
									if($row_estado = mysqli_fetch_assoc($result_estado)){
					        		?>
	                                <option value="<?php echo $row_estado['id']; ?>"><?php echo utf8_encode($row_estado['nome']); ?></option>
	                                <?php
									}
									$busca_estados = "SELECT * FROM estado WHERE id <> '{$row_usuario['estado']}' ";
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
									$busca_cidade = "SELECT * FROM cidade WHERE cod_ibge = '{$row_usuario['cod_cidade']}' AND estado = '{$row_usuario['estado']}'";
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
								    	<input type="text" class="form-control" id="input_ddd" name="input_ddd" value="<?php echo utf8_encode($row_usuario['ddd']); ?>">
								    </div>
								    <div class="col-md-10 " style="padding:0 0 0 10px;">
								    	<input type="text" class="form-control input_telefone" id="input_telefone" name="input_telefone"  value="<?php echo utf8_encode($row_usuario['telefone']); ?>">
									</div>
								</div>
							</div>
							<div class="form-group">
							    <label for="input_inscricao_estadual">Inscrição Estadual</label>
							    <input type="text" class="form-control" id="input_inscricao_estadual" name="input_inscricao_estadual" value="<?php echo utf8_encode($row_usuario['inscricao_estadual']); ?>">
							</div>
						  	<button type="submit" class="btn btn-primary">Atualizar</button>
						</form>
						<?php
						}
						?>
					</div>
						
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
	</div>
					   
	<?php
	include('footer.php');
}