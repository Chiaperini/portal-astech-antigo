<?php include('header.php'); ?>
<?php
if(usuarioestalogado()){
	?>
	 <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-2">
                                <i class="fa fa-wrench fa-4x"></i>
                            </div>
                            <div class="col-xs-10 text-right">
                                <div class="huge">
                                	<?php
                                	$sql_qtde_assistentes = "SELECT * FROM assistentes";
									$result_qtde_assistentes = mysqli_query($mysqli, $sql_qtde_assistentes);
									$row_qtde_assistentes = mysqli_num_rows($result_qtde_assistentes);
									echo $row_qtde_assistentes;
                                	?>
                                </div>
                                <div>Assistentes Cadastrados</div>
                            </div>
                        </div>
                    </div>
                    <a href="assistentes.php?acao=gerenciar">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalhes</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-2">
                                <i class="fa fa-users fa-4x"></i>
                            </div>
                            <div class="col-xs-10 text-right">
                                <div class="huge">
                                	<?php
                                	$sql_qtde_usuarios = "SELECT * FROM usuarios";
									$result_qtde_usuarios = mysqli_query($mysqli, $sql_qtde_usuarios);
									$row_qtde_usuarios = mysqli_num_rows($result_qtde_usuarios);
									echo $row_qtde_usuarios;
                                	?>
                                </div>
                                <div>Usuários Cadastrados</div>
                            </div>
                        </div>
                    </div>
                    <a href="usuarios.php?acao=gerenciar">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalhes</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-users fa-4x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                	<?php
                                	$sql_qtde_usuarios_ativos = "SELECT * FROM usuarios WHERE status = 1";
									$result_qtde_usuarios_ativos = mysqli_query($mysqli, $sql_qtde_usuarios_ativos);
									$row_qtde_usuarios_ativos = mysqli_num_rows($result_qtde_usuarios_ativos);
									echo $row_qtde_usuarios_ativos;
                                	?>
                                </div>
                                <div>Usuários Ativos</div>
                            </div>
                        </div>
                    </div>
                    <a href="usuarios.php?acao=gerenciar">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalhes</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-envelope fa-4x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                	<?php
                                	$sql_qtde_fichas = "SELECT * FROM formularios_rat";
									$result_qtde_fichas = mysqli_query($mysqli, $sql_qtde_fichas);
									$row_qtde_fichas = mysqli_num_rows($result_qtde_fichas);
									echo $row_qtde_fichas;
                                	?>
                                </div>
                                <div>Formulários Enviados</div>
                            </div>
                        </div>
                    </div>
                    <a href="formularios.php?acao=gerenciar">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalhes</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    	<i class="fa fa-certificate fa-fw"></i> Ranking Assistentes
                    </div>
                    <div class="panel-body">
                    	 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Nome da Empresa</th>
                                    <th width="20%">Formulários enviados </th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php 
								$busca_ranking = "SELECT * , COUNT(*) AS Quantidade FROM formularios_rat  GROUP BY id_usuario ORDER BY Quantidade DESC LIMIT 10";
								$result_ranking = mysqli_query($mysqli, $busca_ranking);
								
								while($row_ranking = mysqli_fetch_assoc($result_ranking)){
                            	?>
                                <tr class="even gradeC">
                                    <td><?php echo $row_ranking['assistente_solicitante']; ?></td>
                                    <td><center><?php echo $row_ranking['Quantidade']; ?></center></td>
                                </tr>
                                <?php
								}
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-8 -->
            <!--
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> Painel de Notificações
                    </div>
                    <!-- /.panel-heading 
                    <div class="panel-body">
                        <div class="list-group">
                        	<?php
                        	$busca_log = "SELECT * FROM log_informacoes WHERE acao = 'insercao' ORDER BY data DESC LIMIT 2";
							$result_log = mysqli_query($mysqli, $busca_log);
							while($row_log = mysqli_fetch_assoc($result_log)){
								?>
								<a href="#" class="list-group-item">
                                    <i class="fa fa-user fa-fw"></i>Novo Cadastro <?php echo $row_log['local'] ; ?>
                                    <span class="pull-right text-muted small"><em><?php echo $row_log['data'];?></em>
                                    </span>
                                </a>
								<?php
							}
							$busca_rat = "SELECT * FROM formularios_rat ORDER BY data_insercao DESC LIMIT 2";
							$result_rat = mysqli_query($mysqli, $busca_rat);
							while($row_rat = mysqli_fetch_assoc($result_rat)){
								?>
								<a href="#" class="list-group-item">
                                    <i class="fa fa-envelope fa-fw"></i>Novo Formulário <?php echo $row_rat['numero_ficha']; ?>
                                    <span class="pull-right text-muted small"><em><?php echo $row_rat['data_insercao'];?></em>
                                    </span>
                                </a>
								<?php
							}
                        	?>
                        </div>
                        <!-- /.list-group 
                    </div>
                    <!-- /.panel-body 
                </div>
                <!-- /.panel 
            </div>
           -->
            <!-- /.col-lg-4 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
	<?php
}
else{
	echo '<script>alert("Nenhum usuário logado no sistema.");window.location.href="http://portalastech.chiaperini.com.br/admin"</script>';
}
       
include_once('footer.php'); ?>
