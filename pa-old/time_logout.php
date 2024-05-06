<?php
if ( isset( $_SESSION['sessiontime'] ) ) { 
	if ($_SESSION['sessiontime'] < time() ) { 
		session_unset();
		echo "<script>alert('Sua sessão expirou, por favor faça login novamente.');window.location.href = 'http://portalastech.chiaperini.com.br/';</script>";
		//Redireciona para login
	} else {
		//Seta mais tempo 60 segundos
		$_SESSION['sessiontime'] = time() + 600;
	}
} else { 
	session_unset();
	echo "<script>alert('Sua sessão expirou, por favor faça login novamente.');window.location.href = 'http://portalastech.chiaperini.com.br/';</script>";
}

?>