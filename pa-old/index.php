<?php include_once('media/core/functions.php'); ?>
<?php 
	if(usuarioestalogado()){
		header("Location:http://portalastech.chiaperini.com.br/dashboard/"); 
	}
	include('header.php'); 
 
?>
<script>
$(document).ready(function(){
	$("#inputCNPJ").mask("99.999.999/9999-99");
	$('#group_senha').hide();
	$('#group_senha_login').hide();
	
	$('#errolog').hide(); //Esconde o elemento com id errolog
	$('#form_primeiro_login').submit(function(){ 	//Ao submeter formulário
		var login=$('#input_login').val();	//Pega valor do campo email
		var senha=$('#input_senha_login').val();	//Pega valor do campo senha
		$.ajax({			//Função AJAX
			url:"logarUsuario.php",			//Arquivo php
			type:"post",				//Método de envio
			data: "login="+login+"&senha="+senha,	//Dados
			beforeSend: function()
			{	
				$("#btn-login").html('Validando ...');
			},
   			success: function (result){			//Sucesso no AJAX
        		if(result==1){	
        			$("#btn-login").html('Entrar');
        			$('#errolog').hide();					
        			location.href='painel.php'	//Redireciona
        		}else{
        			$("#btn-login").html('Entrar');
        			$('#errolog').show();		//Informa o erro
        		}
    		}
		})
		return false;	//Evita que a página seja atualizada
	});
});	
</script>
	<div class="container">
		<div class="row">
			<div class="col-md-12 titulo_relatorio">
				<h1 class="text-center">Portal do Assistente</h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<!--
			<div class="col-md-10 col-md-offset-1">
				<h4 class="text-center texto_inicial">
					Estamos fazendo alguns ajustes para melhorar o sua experiência de uso com a ferramenta.<br>
					Em breve você poderá enviar novamente seus relatórios de maneira simples e rápida.
				</h4><br><br><br><br><br><br><br><br><br>
			</div>
		-->
			<div class="col-md-10 col-md-offset-1">
				<h4 class="text-center texto_inicial">
					Você assistente técnico Chiaperini conta agora com uma ferramenta online para facilitar os seus pedidos!<br>
					Com o portal do assistente você pode enviar seus relatórios de maneira rápida e eficiente.
				</h4><br>
				<div class="col-md-5 col-md-offset-1 panel panel-default" style="background:#fcfcfc;">
					<div class="panel-body text-center">
						<h4>É sua primeira vez aqui?<br></h4>
						<p>Então entre com seu CNPJ e uma senha inicial (você que escolhe) para ativar a sua conta.<br>Acesso restrito à autorizados Chiaperini.</p><br>
						<form class="form-horizontal" role="form" id="form_primeiro_cadastro" action="primeiro_cadastro" method="POST">
						    <div class="form-group">
						        <div class="col-md-10 col-md-offset-1">
						        	<div class="form-group row">
						        		<label for="selectPerfil" class="col-md-2 control-label">Perfil</label>
						        		<div class="col-md-9">
							        		<select name="selectPerfil" id="selectPerfil" class="form-control text-left">
							        			<option value="assistente">Assistente T&eacute;cnico</option>
							        			<option value="lojista">Lojista</option>
							        		</select>
						        		</div>
						        	</div>
						            <div class="form-group row">
						                <label for="inputCNPJ" class="col-md-2 control-label">CNPJ</label>
						                <div class="col-md-9">
						                    <input type="text" class="form-control text-left" id="inputCNPJ" name="inputCNPJ" value="">
						                </div>
						                <div class="col-md-1" style="padding: 0;margin:0;">
						                	 <div id="resultado_busca_cnpj"></div>
						                </div>
						            </div>
						            <div class="form-group row">
						            	<label for="input_senha" class="col-md-2 control-label">Senha</label>
						                <div class="col-md-9">
						                    <input type="password" name="senha" class="form-control text-left" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" id="input_senha" title="A senha deve ter no mínimo 6 caracteres e conter números e letras maiúsculas e minúsculas" value="">
						                </div>
						            </div>
						            <div class="form-group" id="group_senha">
								        <div class="col-md-12 text-center">
								            <div class="form-group row">
								    			<button type="submit" name="enviar" id="btn_enviar_cadastro" class="btn btn-warning">Enviar</button>
								    		</div>
								    	</div>
								    </div>
						         </div>
						    </div>
						</form>
					</div>
				</div>
				
				<div class="col-md-5 col-md-offset-1 panel panel-default" style="background:#fcfcfc;">
					<div class="panel-body">
						<h4 class="text-center">Já possui cadastro?</h4>
						<p class="text-center">então faça seu login</p><br><br>
						<form class="form-horizontal" role="form" id="form_primeiro_login" method="POST" action="dashboard">
						    <div class="form-group">
						        <div class="col-md-10 col-md-offset-1">
						            <div class="form-group row">
						                <label for="input_login" class="col-md-2 control-label">Email</label>
						                <div class="col-md-9">
						                    <input type="text" class="form-control text-left" id="input_login" name="input_login" value="">
						                </div>
						                <div class="col-md-1" style="padding: 0;margin:0;">
						                	 <div id="resultado_busca_login"></div>
						                </div>
						            </div>
						            <div class="form-group row">
						                <label for="input_senha" class="col-md-2 control-label">Senha</label>
						                <div class="col-md-9">
						                    <input type="password" name="input_senha_login" class="form-control text-left" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" id="input_senha_login" title="A senha deve ter no mínimo 6 caracteres e conter números e letras maiúsculas e minúsculas" value="">
						                </div>
						            </div>
						            <div class="form-group" id="group_senha_login" style="margin-bottom:0px;">
								        <div class="col-md-12 text-center">
								            <div class="form-group row">
								    			<button type="submit" id="btn-login" class="btn btn-warning">Entrar</button>
								    		</div>
								    	</div>
								    </div>
						         </div>
						    </div>
						    <div id="errolog" class="text-danger" style="padding-bottom:20px;font-weight:bold;"><center>Usuário ou senha errados!</center></div>
						</form>
						<a href="esqueci_minha_senha.php" target="_self">Esqueci minha senha</a>
					</div>
				</div>
			</div>
		
		</div>
	</div>
	<script type="text/javascript">
	$("input[name='inputCNPJ']").on('blur', function(){
	  var cnpj = $(this).val();
	  var perfil = $("#selectPerfil").val();
	  $.get(perfil+'.php?cnpj=' + cnpj,function(data){
	    $('#resultado_busca_cnpj').html(data);
	  });
	});
	
	$("input[name='input_login']").on('blur', function(){
	  var login = $(this).val();
	  $.get('usuario.php?login=' + login,function(data){
	    $('#resultado_busca_login').html(data);
	  });
	});
	</script>
	<?php include('footer.php'); ?>
</body>
</html>