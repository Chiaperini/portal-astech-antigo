<?php
  header("Content-Type: text/html; charset=UTF-8");

  include('../media/core/functions.php');
  
  $cod_peca = $_GET['cod_peca'];  //codigo da peça passada por parametro
  
  $sql = "SELECT * FROM pecas WHERE codigo = $cod_peca";  //consulta todas as cidades que possuem o codigo do estado
  $result_busca_peca = mysqli_query($mysqli, $sql);
  if($peca = mysqli_fetch_assoc($result_busca_peca)){
  	echo $peca['descricao']; 
  }
?>