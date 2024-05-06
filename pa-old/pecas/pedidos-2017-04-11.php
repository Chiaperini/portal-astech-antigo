<?php 
include_once('../media/core/functions.php');
?>
<style type="text/css">
	#formulario_pecas {
	    position: relative;
	    padding: 15px 30px;
	    margin-bottom: 40px;
	    border: solid 1px #ddd;
	    -webkit-border-radius: 4px;
	    -moz-border-radius: 4px;
	    border-radius: 4px;
	    -webkit-box-shadow: none;
	    box-shadow: none;
   }
</style>
<script type="text/javascript">
    
    function buscar_vista_explodida(){
      var equipamento = $('#inputEquipamento').val();  //codigo do estado escolhido
      //se encontrou o estado
      if(equipamento){
        var url = '../ajax_buscar_vista_explodida.php?equipamento='+equipamento;  //caminho do arquivo php que irá buscar as cidades no BD
        $.get(url, function(dataReturn) {
        	if(dataReturn != ""){
	        	$('a#inputVistaExplodida').show();
	          	$('a#inputVistaExplodida').attr("href",dataReturn);  //coloco na div o retorno da requisicao
	          	$('#inputNumeroSerie').attr("value",''); 
	          	$('#inputNumeroSerie').attr("readonly",false);  
        	}
        	else{
        		$('#inputNumeroSerie').attr("value",'000'); 
	          	$('#inputNumeroSerie').attr("readonly",true); 
        		$('a#inputVistaExplodida').hide();
        	}
        });
      }
    }
</script>

<?php
if(usuarioestalogado()){	
	include('../header.php');
	include_once('../time_logout.php');
		?>
		<script type="text/javascript">
		jQuery(function($)
			$('a#inputVistaExplodida').hide();
	 	});
		</script>
		<div class="container">
			<div class="row">
				<div class="col-md-12 titulo_relatorio">
					<h1 class="text-center">Solicita&ccedil;&atilde;o de Or&ccedil;amento de Peças</h1>
					<h5 class="text-center" style="line-height:21px;">Para solicitar as peças, escolha primeiramente o equipamento e verifique o código da peça na sua vista explodida.<br>Insira este código no campo <strong>Código Peça</strong> e clique em adicionar.</h5>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-8 col-md-offset-2">
					<form class="form-horizontal" role="form" id="formulario_pecas" method="POST" action="<?php echo $url_atual;?>pecas/enviar_pecas.php" enctype="multipart/form-data">
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputData" class="col-md-1 control-label">Data</label>
					                <div class="col-md-3">
					                    <input type="text" class="form-control text-center" name="inputData" id="inputData" value="<?php echo $date;?>" readonly>
					                </div>
					                <label for="inputNumeroFicha" class="col-md-2 col-md-offset-4 control-label">Ficha Nº</label>
					                <div class="col-md-2">
					                	<?php
					                	 	$sql_ficha = "SELECT id_peca from formulario_pecas ORDER by id_peca DESC";
											$result_ficha = mysqli_query($mysqli, $sql_ficha);
											if($row_ficha = mysqli_fetch_assoc($result_ficha)){
						                    	$ficha = $row_ficha['id_peca'] + 1;
											}
					                    ?>
					                    <input type="text" class="form-control" name="inputNumeroFichaPeca" id="inputNumeroFichaPeca" value="<?php echo $ficha; ?>" readonly>
					                </div>
					            </div>
					        </div>
					    </div>
					   <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputNomeAssistencia" class="col-md-5 control-label" style="text-align: left;">Assistência Técnica Autorizada</label>
					                <div class="col-md-7">
					                     <input type="text" class="form-control" id="inputNomeAssistencia" name="inputNomeAssistencia" placeholder="" value="<?php echo $_SESSION['nome_usuario']; ?>" readonly>
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="page-header">
						  <h3><center>Equipamento</center></h3>
						</div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputEquipamento" class="col-md-2 control-label" style="text-align:left !important;">Equipamento<span style="color:red;">*</span></label>
					                <div class="col-md-10">
					                	<select id="inputEquipamento" name="inputEquipamento" onchange="buscar_vista_explodida()" class="form-control">
					                    	<option value="">Selecione um equipamento</option>
					                    	<?php
					                    	$sql_equipamentos = "SELECT * FROM equipamentos";
											$result_equipamentos = mysqli_query($mysqli, $sql_equipamentos);
											while($row_equipamentos = mysqli_fetch_assoc($result_equipamentos)){
					                    	?>
											<option value="<?php echo $row_equipamentos['codigo']; ?>"><?php echo $row_equipamentos['nome']; ?></option>
											<?php
											}
											?>
										</select>
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="form-group">
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-md-12" id="btn_vista_explodida" style="text-align: center;">
					                	<a href="" id="inputVistaExplodida" target="_blank"><span class="glyphicon glyphicon-picture btn-lg" aria-hidden="true"></span>Ver Vista Explodida</a>
					                </div>
								</div>
							</div>
						</div>
						<div class="page-header">
						  <h3><center>Solicitação de Peças</center></h3>
						</div>
						<div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputCodPeca" class="col-md-2 control-label">Código Peça</label>
					                <div class="col-md-3">
					                     <input type="text" class="form-control" id="inputCodPeca" name="inputCodPeca" placeholder="" aria-describedby="helpBlock">
					                     <span id="helpBlock" class="help-block"></span>
					                </div>
					                <label for="inputQuantidade" class="col-md-2 control-label">Quantidade</label>
					                <div class="col-md-2">
					                    <input type="text" class="form-control" id="inputQuantidade" name="inputQuantidade" placeholder="">
					                </div>
					                <div class="col-md-3" align="right">
					                    <a id="btn_adicionar_peca" target="_blank" style="text-align: right;cursor:pointer;text-decoration:none;"><span class="glyphicon glyphicon-plus btn-lg" aria-hidden="true" style="margin-top:-6px;"></span>Adicionar</a>
					                </div>
					            </div>
					        </div>
					   </div>
					   <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					            	<div class="col-md-12">
						                <table class="table table-bordered" id="grid" cellpadding="0" cellspacing="0">
						                	<tbody>
						                		<tr>
							                		<th style="font-size:13px;font-weight: normal;">Nome da Peça</th>
							                		<th style="font-size:13px;font-weight: normal;">Equipamento</th>
							                		<th style="font-size:13px;font-weight: normal;text-align: center;">Cód.</th>
							                		<th style="font-size:13px;font-weight: normal;text-align: center;">Qtde</th>
							                		<th style="font-size:13px;font-weight: normal;text-align: center;">Ação</th>
							                	</tr>
						                		<tr>
						                		</tr>
						                	</tbody>
						                </table>
					                </div>
					            </div>
					        </div>
					    </div>
					    <!-- Guarda o total de peças inseridas -->
					    <input type="hidden" name="totalRegistros" value="">
					    <!-- -->
					    <div class="form-group" style="padding:0px 15px;">
					        <div class="col-md-12">
					            <div class="form-group row">
					    			<fieldset style="display: none;"></fieldset>
					    		</div>
					    	</div>
					    </div>
					    <div class="form-group" style="padding:0px 15px;">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <div class="checkbox">
									  <label>
									    <input type="checkbox" value="" id="check_ok" onclick="MostraBotao();">
									   	Declaro ser verdade todas as informações inseridas e estar ciente do registro da Ficha de Peças pela minha empresa, envolvendo todas as peças solicitadas.
									  </label>
									</div>
					            </div>
					        </div>
					    </div>
					    <div class="form-group">
					        <div class="col-md-12 text-center">
					            <div class="form-group row">
					    			<button type="submit" id="btn_enviar" class="btn btn-warning" disabled>Enviar</button>
					    		</div>
					    	</div>
					    </div>
					</form>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		
		<script type="text/javascript">
		$('#btn_adicionar_peca').click(function(){
		  var cod_peca = $("input[name='inputCodPeca']").val();
		  var retorno;
		  $.get('ajax_busca_peca.php?cod_peca=' + cod_peca,function(data){
		   	retorno = data;
		   	adicionarPeca(retorno);
		  });
		});
		
		var cont = 1;
		function adicionarPeca(retorno){
			if(($("input[name='inputQuantidade']").val())> 0){
				var tr = '<tr>'+
				'<td style="font-size:13px;">'+retorno+'</td>'+
				'<td style="text-align:center;font-size:13px;">'+$("#inputEquipamento").val()+'</td>'+
				'<td style="text-align:center;font-size:13px;">'+$("input[name='inputCodPeca']").val()+'</td>'+
				'<td style="text-align:center;font-size:13px;">'+$("input[name='inputQuantidade']").val()+'</td>'+
				'<td style="text-align:center;font-size:13px;"><a class="remover" style="cursor:pointer;text-decoration:none" title="Excluir este produto">Remover</a></td>'+
				'</tr>'
				$('#grid').find('tbody').append( tr );
				
				var hiddens = '<input type="hidden" name="descricao[]" value="'+retorno+'" />'+
				'<input type="hidden" name="codEquipamento[]" value="'+$('#inputEquipamento').val()+'" />'+
				'<input type="hidden" name="codPeca[]" value="'+$("input[name='inputCodPeca']").val()+'" />'+
				'<input type="hidden" name="quantidade[]" value="'+$("input[name='inputQuantidade']").val()+'" />';
				$('#formulario_pecas').find('fieldset').append( hiddens );
				
				$("input[name='totalRegistros']").val(cont);
				cont++;
				return false;
			}
			else{
				alert('Quantidade deve ser maior que 0');
			}
			
		}
		
		$("#grid").on("click", ".remover", function(e){
		    $(this).closest('tr').remove(); 
		});
		
		function enviarDados(){
		  // converter o resultado pra json
		  $json = $("#grid").tableToJSON();
		  
		  // mostrar o resultado
		}
		</script>
		<?php
		include('../footer.php');
}
else{
	include('../header.php');
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
