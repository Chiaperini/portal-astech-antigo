<?php
  header("Content-Type: text/html; charset=UTF-8");

  include('media/core/functions.php');
  
  //$cnpj = $_GET['cnpj'];
  $cnpj = preg_replace("/\D+/", "", $_GET['cnpj']); // remove qualquer caracter não numérico
 
  $sql = "SELECT * FROM assistentes WHERE cnpj = '$cnpj' AND status = '1'"; //monto a query
  $query = $mysqli->query( $sql ); //executo a query

  if( $query->num_rows > 0 ) {//se retornar algum resultado
    echo '<p class="text-success"><span id="info_2" rel="popover" class="glyphicon glyphicon-ok" aria-hidden="true"></p>';
  	?><script>$('#group_senha').show();</script><?php
  } else {
    echo '<p class="text-danger"><span id="foo" rel="popover" class="glyphicon glyphicon-remove" aria-hidden="true"></p>' ;
	?><script>$('#group_senha').hide();</script><?php
  }
?>
	<script>
	$('#foo').popover({
	    placement : 'bottom',
	    trigger: 'hover',
	    content : 'Assistente não encontrado. Acesso restrito à assistentes autorizados Chiaperini.'
	});
	$('#info_2').popover({
	    placement : 'bottom',
	    trigger: 'hover',
	    content : 'Assistente autorizado Chiaperini'
	});
	</script>