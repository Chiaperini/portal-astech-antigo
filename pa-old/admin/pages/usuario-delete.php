<?php 

$servidor = 'localhost';
$banco = 'paste_pa';
$usuario = 'paste_pa';
$senha = 'NwiP^y4-3+=a';

// para usuar em localhost tirar as barras da linha abaixo e adiciona-las as mesmas variáveis acima

//$usuario = 'root';
//$senha = '';


// Conecta-se ao banco de dados MySQL
$mysqli = new mysqli($servidor, $usuario, $senha, $banco);

if (mysqli_connect_errno()) {
    die('Não foi possível conectar-se ao banco de dados: ' . mysqli_connect_error());
    exit();
}

if(isset($_GET['deleteid'])){

    $id = $_GET['deleteid'];

    $sql = "delete from `usuarios` where id=$id";
    $result = mysqli_query($mysqli, $sql);

    if ($result) {
        
        echo '<script>alert("Usuário deletado com sucesso.");window.location.href="usuarios.php?acao=gerenciar"</script>';

    } else {

        echo '<script>alert("Erro ao deletar Usuário, por favor tente novamente.");window.location.href="usuarios.php?acao=gerenciar"</script>';
    }
    
}


?>