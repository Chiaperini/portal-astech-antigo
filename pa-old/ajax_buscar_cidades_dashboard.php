<?php
  header("Content-Type: text/html; charset=UTF-8");

  include('media/core/functions.php');
  
  echo $estado = $_GET['cod_estado'];  //codigo do estado passado por parametro
  
	$sql = "SELECT * FROM cidade WHERE estado = 1 ORDER BY nome";  //consulta todas as cidades que possuem o codigo do estado
	$result_busca_cidade = mysqli_query($mysqli, $sql);
	$num_cidades = mysqli_num_rows($result_busca_cidade);
	 
	// <select name="inputCidade" id="inputCidade" class="form-control">
	for($j=0;$j<$num_cidades;$j++){
		$dados = mysqli_fetch_array($result_busca_cidade);
	?>
		<option value="<?php echo $dados['id']?>"><?php echo utf8_encode($dados['nome']); ?></option>
	<?php 
	}
?>