<?php 
include_once('media/core/functions.php');
?>

<script type="text/javascript">

// Quando a Página Carregar por completo
$(document).ready(function () {
  console.log("JQuery carregado");

  // Quando o formulário for enviado
  $("##formulario_RAT").submit(function (elemento) {
    console.log("formulario acionado");
    // Previne o formulário de executar a ação principal
    elemento.preventDefault();
    // Flag alertar true=sim, false=nao
    var alertar = false;
    // Pega todos os campos dentro do formulario
    var campos = $("#formulario input");
    // Para cada campo verifica se esta preenchido
    // Se não estive muda a flag alertar para sim
    console.log("verificando campos em branco");
    campos.each(function (id) {
      if (campos[id].value == "") {
        alertar = true;
        console.log("campo "+id+" vazio")
      }
    });

    // Se o alertar estiver marcado para sim
    // Exibe o aviso removendo a classe d-none
    if (alertar == true) {
      console.log("exibindo aviso");
      $("#aviso").toggleClass("d-none");
    }
    else {
      console.log("nenhum campo vazio")
    }
  });
});

	function buscar_cidades(){
		$("#inputCidade").html("<option value='0'>Carregando...</option>");
      var estado = $('#inputEstado').val();  //codigo do estado escolhido
      //se encontrou o estado
      if(estado){
        var url = 'ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD
        $.get(url, function(dataReturn) {
          $('#inputCidade').html(dataReturn);  //coloco na div o retorno da requisicao
        });
      }
    }
    
    function buscar_vista_explodida(){
      var equipamento = $('#inputEquipamento').val();  //codigo do estado escolhido
      //se encontrou o estado
      if(equipamento){
        var url = 'ajax_buscar_vista_explodida.php?equipamento='+equipamento;  //caminho do arquivo php que irá buscar as cidades no BD
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
	include('header.php');
	include_once('time_logout.php');
		?>
		<script type="text/javascript">
		function mascaraMutuario(o,f){
		    v_obj=o
		    v_fun=f
		    setTimeout('execmascara()',1)
		}
		function execmascara(){
		    v_obj.value=v_fun(v_obj.value)
		}
		function cpfCnpj(v){
		    //Remove tudo o que não é dígito
		    v=v.replace(/\D/g,"")
		    if (v.length <= 14) { //CPF
		        //Coloca um ponto entre o terceiro e o quarto dígitos
		        v=v.replace(/(\d{3})(\d)/,"$1.$2")
		        //Coloca um ponto entre o terceiro e o quarto dígitos
		        //de novo (para o segundo bloco de números)
		        v=v.replace(/(\d{3})(\d)/,"$1.$2")
		        //Coloca um hífen entre o terceiro e o quarto dígitos
		        v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
		    } else { //CNPJ
		        //Coloca ponto entre o segundo e o terceiro dígitos
		        v=v.replace(/^(\d{2})(\d)/,"$1.$2")
		        //Coloca ponto entre o quinto e o sexto dígitos
		        v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
		        //Coloca uma barra entre o oitavo e o nono dígitos
		        v=v.replace(/\.(\d{3})(\d)/,".$1/$2")
		        //Coloca um hífen depois do bloco de quatro dígitos
		        v=v.replace(/(\d{4})(\d)/,"$1-$2")
		    }
		    return v
		}
		
		jQuery(function($){
			$("#inputTelefone").mask("(99)9999-9999?9");
	   		$("#inputCelular").mask("(99)9999-9999?9");
	   		$("#inputEntrada").mask("99:99");
	   		$("#inputSaida").mask("99:99");
	   		$("#InputDataNotaFiscal").mask("99/99/9999");
			$('a#inputVistaExplodida').hide();
			
	   		
	   		$("#formulario_RAT").validate({
		       rules : {
		             inputNomeCliente:{required:true, minlength:3},
		             inputNomeContato:{required:true, minlength:3},
		             inputEndereco:{required:true, minlength:10},
		             inputBairro:{required:true, minlength:5},
		             inputEstado:{required:true},
		             inputCidade:{required:true},
		             inputCNPJ:{required:true, minlength:14},                            
		       		 inputTelefone:{required:true, minlength:8},
		       		 inputEquipamento:{required:true},
		       		 inputNumeroSerie:{required:true},
		       		 inputInformacoes:{required:true},
		       		 InputNotaFiscal:{required:true},
		       		 InputDataNotaFiscal:{required:true},
		       		 "InputFotosProduto[]":{required:true},
		       		 inputdefeitoprimario:{required:true},
		       },
		       messages:{
		             inputNomeCliente:{required:"Campo obrigatório", minlength:"O nome deve ter pelo menos 3 caracteres"},
		             inputNomeContato:{required:"Campo obrigatório", minlength:"O nome deve ter pelo menos 3 caracteres"},
		             inputEndereco:{required:"Campo obrigatório", minlength:"O nome deve ter pelo menos 10 caracteres"},
		             inputBairro:{required:"Campo obrigatório", minlength:"O nome deve ter pelo menos 5 caracteres"},
		             inputEstado:{required:"Campo obrigatório"}, 
		             inputCidade:{required:"Campo obrigatório"}, 
		             inputCNPJ:{required:"Campo obrigatório", minlength:"O nome deve ter pelo menos 14 caracteres"}, 
		             inputTelefone:{required:"Campo obrigatório", minlength:"O nome deve ter pelo menos 8 caracteres"},
		             inputEquipamento:{required:"Campo obrigatório"}, 
		             inputNumeroSerie:{required:"Campo obrigatório"}, 
		             inputInformacoes:{required:"Campo obrigatório"},
		             InputNotaFiscal:{required:"Campo obrigatório"},
		             InputDataNotaFiscal:{required:"Campo obrigatório"},
		             "InputFotosProduto[]":{required:"Campo obrigatório"},
		             inputdefeitoprimario:{required:"Campo obrigatório"},
		       }
			});
	 	});
		</script>
		<div class="container">
			<div class="row">
				<div class="col-md-12 titulo_relatorio">
					<h1 class="text-center">Relatório de Assistência Técnica</h1>
					<h5 class="text-center">Os campos com (<span style="color:red;">*</span>) são de preenchimento obrigatório</h5>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-8 col-md-offset-2">
					<form class="form-horizontal" role="form" id="formulario_RAT" onsubmit="$('#loading').show();return validaFoto();" method="POST" action="<?php echo $url_atual;?>enviar_rat.php" enctype="multipart/form-data">
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
					                	 	$sql_ficha = "SELECT id_rat from formularios_rat ORDER by id_rat DESC";
											$result_ficha = mysqli_query($mysqli, $sql_ficha);
											if($row_ficha = mysqli_fetch_assoc($result_ficha)){
						                    	$ficha = $row_ficha['id_rat'] + 1;
											}
					                    ?>
					                    <input type="text" class="form-control" name="inputNumeroFicha" id="inputNumeroFicha" value="<?php echo $ficha; ?>" readonly>
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
						  <h3><center>Dados do cliente final</center></h3>
						</div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputNomeCliente" class="col-md-1 control-label">Cliente<span style="color:red;">*</span></label>
					                <div class="col-md-6">
					                     <input type="text" class="form-control" id="inputNomeCliente" name="inputNomeCliente" placeholder="Nome do Cliente">
					                </div>
					                <label for="inputNomeContato" class="col-md-1 control-label">Contato<span style="color:red;">*</span></label>
					                <div class="col-md-4">
					                    <input type="text" class="form-control" id="inputNomeContato" name="inputNomeContato" placeholder="Nome do Contato">
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputEndereco" class="col-md-2 control-label" style="text-align:left;">Endereço<span style="color:red;">*</span></label>
					                <div class="col-md-5">
					                     <input type="text" class="form-control" name="inputEndereco" id="inputEndereco" placeholder="Endereço do Cliente">
					                </div>
					                <label for="inputBairro" class="col-md-1 control-label">Bairro<span style="color:red;">*</span></label>
					                <div class="col-md-4">
					                    <input type="text" class="form-control" name="inputBairro" id="inputBairro" placeholder="Bairro do Cliente">
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					            	<label for="inputEstado" class="col-md-1 control-label">Estado<span style="color:red;">*</span></label>
					                <div class="col-md-2">
					                    <select id="inputEstado" name="inputEstado" onchange="buscar_cidades()" class="form-control">
					                    	<option value=""></option>
					                    	<?php
					                    	$sql_estados = "SELECT * FROM estado";
											$result_estados = mysqli_query($mysqli, $sql_estados);
											while($row_estados = mysqli_fetch_assoc($result_estados)){
					                    	?>
											<option value="<?php echo $row_estados['id']; ?>"><?php echo $row_estados['uf']; ?></option>
											<?php
											}
											?>
										</select>
					                </div>
					                <label for="inputCidade" class="col-md-1 control-label">Cidade<span style="color:red;">*</span></label>
					                <div class="col-md-8">
					                	<select name="inputCidade" id="inputCidade" class="form-control">
								           <option value="">Escolha um estado</option>
								        </select>
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="form-group">
					    	<div class="col-md-12">
					    		<div class="form-group row">
					    			<label for="inputCNPJ" class="col-md-2 control-label" style="text-align: left;">CNPJ/CPF<span style="color:red;">*</span></label>
					                <div class="col-md-3">
					                     <input type="text" class="form-control" id="inputCnpj" name="inputCNPJ" onkeypress='mascaraMutuario(this,cpfCnpj)' onblur='clearTimeout()' placeholder="CNPJ ou CPF">
					                </div>
					                <label for="inputEmailCliente" class="col-md-3 control-label">Email do Cliente<span style="color:red;">*</span></label>
					                <div class="col-md-4">
					                     <input type="text" class="form-control" id="inputEmailCliente" name="inputEmailCliente" placeholder="Email do Cliente">
					                </div>
					    		</div>
					    	</div>
					    </div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputTelefone" class="col-md-2 control-label" style="text-align:left;">Tel/Cel<span style="color:red;">*</span></label>
					                <div class="col-md-4">
					                    <input type="tel" class="form-control" name="inputTelefone" id="inputTelefone" placeholder="(00) 0000 00000" >
					                </div>
					                <label for="inputCelular" class="col-md-1 control-label">Tel/Cel</label>
					                <div class="col-md-5">
					                    <input type="text" class="form-control" id="inputCelular" name="inputCelular" placeholder="(00) 0000 00000">
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="page-header">
						  <h3><center>Dados do equipamento</center></h3>
						</div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputEquipamento" class="col-md-2 control-label" style="text-align:left !important;">Equipamento<span style="color:red;">*</span></label>
					                <div class="col-md-6">
					                	<select id="inputEquipamento" name="inputEquipamento" onchange="buscar_vista_explodida()" class="form-control">
					                    	<option value="">Selecione um equipamento</option>
					                    	<?php
					                    	$sql_equipamentos = "SELECT * FROM equipamentos ORDER BY nome";
											$result_equipamentos = mysqli_query($mysqli, $sql_equipamentos);
											while($row_equipamentos = mysqli_fetch_assoc($result_equipamentos)){
					                    	?>
											<option value="<?php echo $row_equipamentos['codigo']; ?>"><?php echo $row_equipamentos['nome']; ?> (cod.: <?php echo $row_equipamentos['codigo']; ?>)</option>
											<?php
											}
											?>
										</select>
					                </div>
					                <label for="inputNumeroSerie" class="col-md-2 control-label" style="text-align:left !important;">Nº de Série<span style="color:red;">*</span></label>
					                <div class="col-md-2">
					                    <input type="text" class="form-control" id="inputNumeroSerie" name="inputNumeroSerie" placeholder="00000">
					                </div>
					            </div>
					        </div>
					    </div>
						<div class="form-group">
						<div class="col-md-12" style="text-align: center;">       	
					             <h4>Solicite ao cliente maiores detalhes, de onde e como ele utiliza este produto</h4></div>
						</div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					            	<label for="inputInformacoes" class="col-md-2 control-label" style="text-align:left !important;">Informações Técnicas<span style="color:red;">*</span></label>
					                <div class="col-md-10">
					                     <textarea class="form-control" rows="4" id="inputInformacoes" name="inputInformacoes"></textarea>
										 <p class="help-block"><b>Exemplo:</b> no caso de um compressor 10 pés, aonde ele é utilizado e para fazer oque: Se este compressor é usado em uma oficina para ferramentas pneumáticas ou para lavar carros, etc...</p>
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <label for="inputKM" class="col-md-1 control-label">KM</label>
					                <div class="col-md-3">
					                     <input type="text" class="form-control" id="inputKM" name="inputKM" placeholder="00" aria-describedby="helpBlock">
					                     <span id="helpBlock" class="help-block">Caso atenda o cliente no local</span>
					                </div>
					                <label for="inputEntrada" class="col-md-1 control-label">Entrada</label>
					                <div class="col-md-3">
					                    <input type="text" class="form-control" id="inputEntrada" name="inputEntrada" placeholder="">
					                </div>
					                <label for="inputSaida" class="col-md-1 control-label">Saída</label>
					                <div class="col-md-3">
					                    <input type="text" class="form-control" id="inputSaida" name="inputSaida" placeholder="">
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="form-group">
					    	<div class="col-md-12">
					            <div class="form-group row">
								    <label for="InputNotaFiscal" class="col-md-2 control-label" style="text-align:left;">Nota Fiscal<span style="color:red;">*</span></label>
								    <div class="col-md-10">
								    	<input type="file" id="InputNotaFiscal" name="InputNotaFiscal">
								    	<p class="help-block">Certifique-se que o documento está legível.<br>
								    		O nome do arquivo não pode conter acentos nem espaços.<br>
O arquivo deve ter no máximo 1Mb.<br>Para a diminuir o tamanho das imagens acesse <a href="https://squoosh.app/" target="_blank"> https://squoosh.app</a><br>Siga as instruções presentes neste <a href="https://portalastech.chiaperini.com.br/media/images/passo-a-passo-compactar-imagem.pdf" target="_blak">PASSO-A-PASSO <b>clique aqui</b></a></p>
								    </div>
								</div>
							</div>
						</div>
						<div class="form-group">
					    	<div class="col-md-12">
					            <div class="form-group row">
								    <label for="InputDataNotaFiscal" class="col-md-3 control-label" style="text-align:left;">Data da Nota Fiscal<span style="color:red;">*</span></label>
								    <div class="col-md-3">
								    	<input type="text" class="form-control" id="InputDataNotaFiscal" name="InputDataNotaFiscal">
								    </div>
								</div>
							</div>
						</div>
						<div class="form-group">
					    	<div class="col-md-12">
					            <div class="form-group row">
								    <label for="InputFotosProduto" class="col-md-3 control-label" style="text-align:left;">Fotos do Produto<span style="color:red;">*</span></label>
								    <div class="col-md-9">
								    	<input type="hidden" name="MAX_FILE_SIZE" value="31457280">
								    	<input type="file" id="InputFotosProduto" name="InputFotosProduto[]" multiple>
								    	<p class="help-block">
								    		É obrigatório o envio da foto da Plaqueta e do Local de Instalação.<br>
								    		Selecione uma ou mais fotos do produto.
								    		Cada foto deve ter no máximo 300kb.
											<br>O arquivo deve ter no máximo 1Mb.<br>Para a diminuir o tamanho das imagens acesse <a href="https://squoosh.app/" target="_blank"> https://squoosh.app</a><br>Siga as instruções presentes neste <a href="https://portalastech.chiaperini.com.br/media/images/passo-a-passo-compactar-imagem.pdf" target="_blak">PASSO-A-PASSO <b>clique aqui</b></a></p>
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
									<div class="col-md-12" id="btn_vista_explodida"  style="text-align: center;">
					                	<a href="" id="inputVistaExplodida" style=" background-color: #337ab7; color: #ffffff; padding: 15px; font-size: 15px; border-radius: 10px;" target="_blank"><span class="glyphicon glyphicon-picture btn-lg" aria-hidden="true"></span>Ver Vista Explodida</a>
					                </div>
								</div>
							</div>
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
							                		<th style="font-size:13px;font-weight: normal;text-align: center;">Cód.</th>
							                		<th style="font-size:13px;font-weight: normal;text-align: center;">Qtde</th>
							                		<th style="font-size:13px;font-weight: normal;text-align: center;">Ação</th>
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
					    <div class="form-group">
					        <div class="col-md-12">
					            <div class="form-group row">
					            	<label for="inputdefeitoprimario" class="col-md-2 control-label" style="text-align:left !important;">Defeito Prim&aacute;rio<span style="color:red;">*</span></label>
					                <div class="col-md-10">
					                     <input type="text" class="form-control" id="inputdefeitoprimario" name="inputdefeitoprimario" aria-describedby="helpBlock2">
					                     <span id="helpBlock2" class="help-block">Aonde foi o primeiro defeito do equipamento</span>
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="form-group" style="padding:0px 15px;">
					        <div class="col-md-12">
					            <div class="form-group row">
					                <div class="checkbox">
									  <label>
									    <input type="checkbox" value="" id="check_ok" onclick="MostraBotao();">
									   	Declaro ser verdade todas as informações inseridas e estar ciente do registro do Relatório de Assistência Técnica pela minha empresa exclusivamente para este cliente, envolvendo todas as peças solicitadas.
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
								<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
						<div id="loading" style="display:none"><p style="font-size: 20px;font-style: italic;font-weight: 900;">Enviando Relatório Aguarde.....</p><script type="text/javascript">
    $(document).ready(function () {
        setInterval(function () {
            $('#loading').fadeOut(1500);
        }, 30000);


        //setInterval(function () {
         //   $('#loading	').fadeIn(1500);
        //}, 4000);
    });
    </script></div>
								
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
		
		$('#InputFotosProduto').change(function(){
		    var files = this.files; // SELECIONA OS ARQUIVOS
		    var qtde = files.length; // CONTA QUANTOS TEM
		    
		    if(qtde > 5) { // VERIFICA SE É MAIOR DO QUE 5
		     	alert("Não é permitido enviar mais do que 5 arquivos.");
		       	$(this).val("");
		       	return false;
		    } else { // SE NÃO FOR MAIS DO QUE 5 ELE CONTINUA.
		    	var tamanhoArquivo = 0;
		        if(tamanhoArquivo > 31457280){ //MAX_FILE_SIZE = 2097152 Bytes
		            alert("O tamanho das imagens excede o permitido de 2MB!");
		            $(this).val("");
		            return false;
		        }
		        else{
		        	return true;
		        }
		    }
		});
		
		function validaFoto(){
			var tamanhoArquivo = 0;
	    	for(i=0;i<qtde;i++){
	    		tamanhoArquivo = tamanhoArquivo + parseInt(document.getElementById("InputFotosProduto").files[i].size);
	    	}
	        if(tamanhoArquivo = 0){ //MAX_FILE_SIZE = 2097152 Bytes
	            alert("É obrigatório o envio das fotos do equipamento");
	            return false;
	        }
	        else{
	        	return true;
	        }
		}
		
		var cont = 1;
		function adicionarPeca(retorno){
			if(($("input[name='inputQuantidade']").val())> 0){
				var tr = '<tr>'+
				'<td style="font-size:13px;"><input type="text" name="descricao[]" value="'+retorno+'"  readonly/></td>'+
				'<td style="text-align:center;font-size:13px;"><input type="text" name="codPeca[]" value="'+$("input[name='inputCodPeca']").val()+'" readonly /></td>'+
				'<td style="text-align:center;font-size:13px;"><input type="text" name="quantidade[]" value="'+$("input[name='inputQuantidade']").val()+'" readonly /></td>'+
				'<td style="text-align:center;font-size:13px;"><a class="remover" style="cursor:pointer;text-decoration:none" title="Excluir este produto">Remover</a></td>'+
				'</tr>'
				$('#grid').find('tbody').append( tr );
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

