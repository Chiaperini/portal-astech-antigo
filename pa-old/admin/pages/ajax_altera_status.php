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
	//Procura email assistente
	$busca_assistentes = "SELECT * FROM assistentes WHERE id = '{$id}'";
	$result_assistentes = mysqli_query($mysqli, $busca_assistentes);
	if($row_assistentes = mysqli_fetch_assoc($result_assistentes)){
		
		//Altera status do assistente
		$sql_update_assistente = "UPDATE assistentes SET status ='{$novo_status}' WHERE id='{$id}' AND email = '{$row_assistentes['email']}'";
		if($result_update_assistente = mysqli_query($mysqli, $sql_update_assistente)){
			
			//Altera status do usuario do assistente
			$sql_update_usuario = "UPDATE usuarios SET status ='{$novo_status}' WHERE email='{$row_assistentes['email']}'";
			if($result_update = mysqli_query($mysqli, $sql_update_usuario)){
				
				//Adiciona no log de Informações
				$insert_admin = "INSERT into log_informacoes(id_user, nome, email, acao, local, data) VALUES('{$_SESSION['id_admin']}', '{$_SESSION['nome_admin']}', '{$_SESSION['usuario_admin']}', 'atualizacao status' , 'Assistente {$id}' ,'{$_SESSION['ultimoAcesso_admin']}')  ";
				if ($mysqli->query($insert_admin) === TRUE){
					echo 'Status do assistente alterado com sucesso';
				}
			}
			else{
				echo "O status do Assistente foi alterado, porém houve um erro ao alterar o status do seu usuário. Por favor faça essa alteração manualmente no item usuário do Menu.";
			}
		}
		else{
			?><script>alert('Erro ao alterar status do assistente. Verifique sua conexão ou entre em contato com o setor responsável');</script><?php
		}
	} 
	else{
		echo "Erro ao localizar assistente.";
	}
?>
