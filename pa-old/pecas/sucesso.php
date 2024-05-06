<?php 
	include_once('../media/core/functions.php');
	include('../header.php'); 
?>
		<div class="geral" style="height:100%;">
			<div class="container">
				<div class="row">
					<div class="col-md-12 titulo_relatorio">
						<h1 class="text-center">Pedido enviado com Sucesso!</h1>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<h4 class="text-center texto_inicial">
							O seu pedido de orçamento de peças foi encaminhado e a empresa pode responder em até 3 dias úteis.<br>
							Lembre-se, o pedido de orçamento é apenas para obtenção dos valores e não garante a efetivação do pedido.<br>
							Seu pedido só será efetivado após o contato da empresa.<br>
							Acompanhe o status da sua solicitação através do email <?php echo $_SESSION['usuario_logado']; ?>
						</h4><br>
					</div>
				</div>
			</div>
			<div class="container" style="padding:30px 0px 60px 0px;">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<h4 class="text-center texto_inicial">
							<a href="<?php echo $url_atual; ?>painel.php" class="btn btn-warning" target="_self">Voltar ao Menu Principal</a>
						</h4><br>
					</div>
				</div>
			</div>
		</div>
	<?php include('../footer.php'); ?>
	</div>
</body>
</html>