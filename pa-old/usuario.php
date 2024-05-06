<?php
  header("Content-Type: text/html; charset=UTF-8");

  include('media/core/functions.php');
  
  $login = $_GET['login'];
 
  $sql = "SELECT * FROM usuarios WHERE email = '$login' AND status = 1"; //monto a query
  $query = $mysqli->query( $sql ); //executo a query

  if( $query->num_rows > 0 ) {//se retornar algum resultado
    echo '<p class="text-success"><span id="login_encontrado" rel="popover" class="glyphicon glyphicon-ok" aria-hidden="true"></p>';
  	?><script>$('#group_senha_login').show();</script><?php
  } else {
    echo '<p class="text-danger"><span id="login_nao_encontrado" rel="popover" class="glyphicon glyphicon-remove" aria-hidden="true"></p>' ;
	?><script>$('#group_senha_login').hide();</script><?php
  }
?>
	<script>
	$('#login_nao_encontrado').popover({
	    placement : 'bottom',
	    trigger: 'hover',
	    content : 'Usuário não encontrado. Para acessar o portal você deve se cadastrar primeiro.'
	});
	$('#login_encontrado').popover({
	    placement : 'bottom',
	    trigger: 'hover',
	    content : 'Usuário cadastrado no portal'
	});
	</script>