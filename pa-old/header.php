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
<html xmlns="http://www.w3.org/1999/xhtml" >
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<link rel="shortcut icon" href="https://portalastech.chiaperini.com.br/admin/media/images/favicon.png" />
        <title>Painel Astech</title>
        
        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo $url_atual;?>media/css/style.css" type="text/css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    	<!-- JavaScript -->
    	<!-- <script src="https://code.jquery.com/jquery-1.11.3.js"></script> -->
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-migrate-1.2.1.js"></script>
    	<script src="<?php echo $url_atual;?>media/js/jquery.maskedinput.js"></script>
    	<script src="<?php echo $url_atual;?>media/js/jquery.validate.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    	
    	<script type="text/javascript">
    		$(function(){   
				var nav = $('.cabecalho');   
				$(window).scroll(function () { 
					if ($(this).scrollTop() > 150) { 
						nav.addClass("menu-fixo"); 
					} else { 
						nav.removeClass("menu-fixo"); 
					} 
				});  
			});

			function MostraBotao(){  
				if(document.getElementById('check_ok').checked == true){ 	 
					document.getElementById('btn_enviar').disabled = ""  }  
				if(document.getElementById('check_ok').checked == false){ 	 
					document.getElementById('btn_enviar').disabled = "disabled"  
				}	
			}
		</script>
			
    </head>

<body>
<script>
    (function(w,d,t,u,n,a,m){w['MauticTrackingObject']=n;
        w[n]=w[n]||function(){(w[n].q=w[n].q||[]).push(arguments)},a=d.createElement(t),
        m=d.getElementsByTagName(t)[0];a.async=1;a.src=u;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://mkt.astechbrasil.com.br/mtc.js','mt');

    mt('send', 'pageview');
</script>
<?php include_once("analytics.php") ?>
	<div class="container-fluid cabecalho">
		<div class="row barra_topo">
			<div class="container">
				<div class="col-xs-12 col-md-6">
					<?php
					if(usuarioestalogado()){
					?>
					<p class="text-left"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;Olá <?php echo $_SESSION['nome_usuario'];?>! Seja bem vindo ao Painel do Assistente</p>
					<?php
					}
					else{
					?>
					<p class="text-left">Seja bem vindo ao Painel do Assistente</p>
					<?php
					}
					?>
				</div>
				<div class="col-xs-12 col-md-6">
					<?php
					if(usuarioestalogado() && ($_SESSION['usuario_logado'] != 'amandathaisalmeida@gmail.com')){
						?>
						<div class="col-xs-6 col-md-9">
							<p class="text-right"><a href="<?php echo $url_atual;?>alterar_senha/" target="_self"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>&nbsp;Alterar Senha</a></p>
						</div>
						<div class="col-xs-6 col-md-3">
							<p class="text-right"><a onclick="return confirm('Tem certeza que deseja sair?');" href="<?php echo $url_atual;?>doLogout/" target="_self"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Sair</a></p>
						</div>
						<?php
					}
					if(usuarioestalogado() && ($_SESSION['usuario_logado'] == 'amandathaisalmeida@gmail.com')){
						?>
						<div class="col-xs-6 col-md-12" align="right">
							<div class="btn-group">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top:3px;background:#434752;color:#ffffff;">
							    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;Minha conta
							  </button>
							  <ul class="dropdown-menu">
							    <li><a href="<?php echo $url_atual;?>meu_cadastro/">Meu Cadastro</a></li>
							    <li><a href="<?php echo $url_atual;?>alterar_senha/">Alterar Senha</a></li>
							    <li><a href="<?php echo $url_atual;?>meus_formularios">Meus Formulários</a></li>
							    <li><a href="#">Meus Orçamentos</a></li>
							    <li><a href="#">Ajuda</a></li>
							    <li role="separator" class="divider"></li>
							    <li><a onclick="return confirm('Tem certeza que deseja sair?');" href="<?php echo $url_atual;?>doLogout/">Sair</a></li>
							  </ul>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="row logos_topo">
			<div class="container">
				<div class="col-xs-12">
					<div class="row">
						 <div class="col-md-6">
						 	<a href="<?php echo $url_atual;?>painel.php" target="_self">
					        	<img src="<?php echo $url_atual;?>media/images/astech.png" height="80" alt="ASTECH - Portal do Assistênte Técnico Chiaperini" />
					        </a>
					      </div>
					      <div class="col-md-6 text-right" style="padding-top:10px;">
					        <a href="http://chiaperini.com.br" target="_blank">
					        	<img src="<?php echo $url_atual;?>media/images/chiaperini-industrial.png"  alt="Chiaperini Indstrial" />
					        </a>
					      </div>
					</div>
				</div>
			</div>
		</div>
	</div>