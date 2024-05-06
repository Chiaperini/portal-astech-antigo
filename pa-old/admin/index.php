<?php
/**
 * Painel do Assistente Tecnico
 * @author Amanda Almeida
 * @author Chiaperini Industrial
 */
	date_default_timezone_set('America/Sao_Paulo');
	$date = date('d/m/Y');
	$date_insert = date('Y-m-d');	
	include_once('media/core/functions.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="media/images/favicon.png" />
	<title>Gerenciador Portal Astech</title>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

<style type="text/css">
	@import url(https://fonts.googleapis.com/css?family=Roboto:300);

	.login-page {
	  width: 360px;
	  padding: 18% 0 0;
	  margin: auto;
	}
	.form {
	  position: relative;
	  z-index: 1;
	  background: #FFFFFF;
	  max-width: 360px;
	  margin: 0 auto 100px;
	  padding: 45px;
	  text-align: center;
	  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
	}
	.form input {
	  font-family: "Roboto", sans-serif;
	  outline: 0;
	  background: #f2f2f2;
	  width: 100%;
	  border: 0;
	  margin: 0 0 15px;
	  padding: 15px;
	  box-sizing: border-box;
	  font-size: 14px;
	}
	.form button {
	  font-family: "Roboto", sans-serif;
	  text-transform: uppercase;
	  outline: 0;
	  background: #337ab7;
	  width: 100%;
	  border: 0;
	  padding: 15px;
	  color: #FFFFFF;
	  font-size: 14px;
	  -webkit-transition: all 0.3 ease;
	  transition: all 0.3 ease;
	  cursor: pointer;
	}
	.form button:hover,.form button:active,.form button:focus {
	  background: #2a699f;
	}
	.form .message {
	  margin: 15px 0 0;
	  color: #b3b3b3;
	  font-size: 12px;
	}
	.form .message a {
	  color: #4CAF50;
	  text-decoration: none;
	}
	.form .register-form {
	  display: none;
	}
	.container {
	  position: relative;
	  z-index: 1;
	  max-width: 300px;
	  margin: 0 auto;
	}
	.container:before, .container:after {
	  content: "";
	  display: block;
	  clear: both;
	}
	.container .info {
	  margin: 50px auto;
	  text-align: center;
	}
	.container .info h1 {
	  margin: 0 0 15px;
	  padding: 0;
	  font-size: 36px;
	  font-weight: 300;
	  color: #1a1a1a;
	}
	.container .info span {
	  color: #4d4d4d;
	  font-size: 12px;
	}
	.container .info span a {
	  color: #000000;
	  text-decoration: none;
	}
	.container .info span .fa {
	  color: #EF3B3A;
	}
	body {
	  background: #f8f8f8; /* fallback for old browsers */
	  background: -webkit-linear-gradient(right, #f8f8f8, #eeeeee);
	  background: -moz-linear-gradient(right, #f8f8f8, #eeeeee);
	  background: -o-linear-gradient(right, #f8f8f8, #eeeeee);
	  background: linear-gradient(to left, #f8f8f8, #eeeeee);
	  font-family: "Roboto", sans-serif;
	  -webkit-font-smoothing: antialiased;
	  -moz-osx-font-smoothing: grayscale;      
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('#errolog').hide(); //Esconde o elemento com id errolog
	
	$('#form_login_admin').submit(function(){ 	//Ao submeter formulário
		var login = $('#input_login').val();	//Pega valor do campo email
		var senha = $('#input_senha').val();	//Pega valor do campo senha
		
		$.ajax({			//Função AJAX
			url:"login.php",			//Arquivo php
			type:"post",				//Método de envio
			data: "login="+login+"&senha="+senha,	//Dados
			beforeSend: function()
			{	
				$("#btn-login").html('Validando ...');
			},
   			success: function (result){			//Sucesso no AJAX
        		if(result == 1){	
        			$("#btn-login").html('Login');
        			$('#errolog').hide();					
        			location.href='pages/index.php'	//Redireciona
        		}
        		else{
        			$("#btn-login").html('Login');
        			$('#errolog').show();		//Informa o erro
        		}
    		}
		})
		return false;	//Evita que a página seja atualizada
		
	});
});
</script>

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-xs-10">
				<div class="login-page">
					<center><img src="../media/images/logo-astech.png" width="200" /></center>
				  <div class="form">
				    <form class="login-form" id="form_login_admin" method="post" action="">
				      <input type="text" name="email" id="input_login" placeholder="email"/>
				      <input type="password" name="senha" id="input_senha" placeholder="senha"/>
				      <button type="submit" id="btn-login">login</button>
				      <div id="errolog" class="text-danger" style="padding-bottom:20px;font-weight:bold;"><center>Usuário ou senha errados!</center></div>
					</form>
				  </div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
