<?php 

$servidor = 'localhost';
$usuario = 'paste_pa';
$senha = 'NwiP^y4-3+=a';
$banco = 'paste_pa';

// Conecta-se ao banco de dados MySQL
$mysqli = new mysqli($servidor, $usuario, $senha, $banco);

if (mysqli_connect_errno()) {
    die('Não foi possível conectar-se ao banco de dados: ' . mysqli_connect_error());
    exit();
}

?>