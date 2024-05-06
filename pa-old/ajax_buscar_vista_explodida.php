<?php
  header("Content-Type: text/html; charset=UTF-8");

  include('media/core/functions.php');
  
  $equipamento = $_GET['equipamento'];  //codigo do estado passado por parametro
  
  $sql = "SELECT * FROM vistas_explodidas WHERE codigo = $equipamento";  //consulta todas as cidades que possuem o codigo do estado
  $result_busca_vistas_explodidas = mysqli_query($mysqli, $sql);
  if($vistas_explodidas = mysqli_fetch_assoc($result_busca_vistas_explodidas)){
  	echo $url_vistas.$vistas_explodidas['link']; 
  }
?>