<?php
 	header("Content-Type: text/html; charset=UTF-8");
  	include('../media/core/functions.php');
  
	$id = $_GET['id'];
	$status = $_GET['status'];
	
	if($status == 0){
		$novo_status = 1;
	}
	else{
		$novo_status = 0;
	}
	//Procura email lojista
	$busca_lojista = "SELECT * FROM lojistas WHERE id = '{$id}'";
	$result_lojista = mysqli_query($mysqli, $busca_lojista);
	if($row_lojista = mysqli_fetch_assoc($result_lojista)){
		
		//Altera status do assistente
		$sql_update_lojista = "UPDATE lojistas SET status ='{$novo_status}' WHERE id='{$id}' AND email = '{$row_lojista['email']}'";
		if($result_update_lojista = mysqli_query($mysqli, $sql_update_lojista)){
			
			//Altera status do usuario do assistente
			$sql_update_usuario = "UPDATE usuarios SET status ='{$novo_status}' WHERE email='{$row_lojista['email']}'";
			if($result_update = mysqli_query($mysqli, $sql_update_usuario)){
				
				//Adiciona no log de Informações
				$insert_admin = "INSERT into log_informacoes(id_user, nome, email, acao, local, data) VALUES('{$_SESSION['id_admin']}', '{$_SESSION['nome_admin']}', '{$_SESSION['usuario_admin']}', 'atualizacao status' , 'Lojista {$id}' ,'{$_SESSION['ultimoAcesso_admin']}')  ";
				if ($mysqli->query($insert_admin) === TRUE){
					echo 'Status do lojista alterado com sucesso';
				}
			}
			else{
				echo "O status do Lojista foi alterado, porém houve um erro ao alterar o status do seu usuário. Por favor faça essa alteração manualmente no item usuário do Menu.";
			}
		}
		else{
			?><script>alert('Erro ao alterar status do lojista. Verifique sua conexão ou entre em contato com o setor responsável');</script><?php
		}
	} 
	else{
		echo "Erro ao localizar lojista.";
	}
?>
