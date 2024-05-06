<?php 
include_once('media/core/functions.php');
?>
<style type="text/css">
	.large_container{
		margin-top:70px;
	}
	a.botao{
		-webkit-border-radius:5px;
		-moz-border-radius:5px;
	    border-radius: 5px;
	    padding: 20px 30px;
	    color: #fff;
	    font-weight:700;
	    text-decoration: none;
	    background: #f8a410;	
	}
	a.botao:hover{
		background:#f5b74a;
		color:#fff;
		text-decoration:none;
	}
	.row_footer{
		position:absolute;
		bottom:0;
		width:100%;
	}
</style>

<?php

if(usuarioestalogado()){	
	include('header.php');
	include_once('time_logout.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
<!--
				<h1 class="text-center">
				<center>Estamos em manutenção.<br>
				Por favor acesse o portal mais tarde para envio de suas fichas.
				</center></h1>
				</div>
-->
				
				<div class="col-md-12 titulo_relatorio">
					<h1 class="text-center">O que deseja fazer?</h1>
					<h5 class="text-center">Clique em um dos botões abaixo para ser redirecionado a página de escolha</h5>
				</div>
			</div>
		</div>

		<div class="container large_container">
			<div class="row">
				<div class="col-xs-12 col-md-3 col-md-offset-3" align="center">
					<?php 
					if($_SESSION['perfil'] == 'lojista'){
						?>
						<button type="submit" id="btn_ficha_garantia" class="btn btn-warning" disabled title="Funcionalidade disponível apenas para Assistentes">Ficha de Garantia</button>
						<?php
					}
					else{
						?><a class="botao" href="dashboard" title="Ficha de Garantia">Ficha de Garantia</a><?php
					}
					?>
				</div>
				<div class="col-xs-12 col-md-3" align="center">
					<a class="botao" href="<?php echo $url_atual;?>pecas/pedidos.php" title="Pedido de Peças">Or&ccedil;amento de Peças</a>
				</div>
			</div>
		</div>
		<div class="container" style="padding:60px 0px;">
			<div class="col-xs-12 col-md-6 col-md-offset-3" align="center" style="padding:20px;border:solid 1px #bcbcbc; border-radius:5px;">
				A funcionalidade de orçamento peças ainda está na versão Beta.
				Qualquer eventualidade que ocorra ao tentar enviar o pedido por favor envie um e-mail para chiaperini@chiaperini.com.br.
			</div>
		</div>
		
		<div class="clear"></div>
		<?php
		include('footer.php');
}
else{
	include('header.php');
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-12 titulo_relatorio">
				<h1 class="text-center">Ops..</h1>
				<h5 class="text-center">Esta página só pode ser acessada através de login e senha.</h5>
			</div>
		</div>
	</div>
	<?php
	exit();
}
