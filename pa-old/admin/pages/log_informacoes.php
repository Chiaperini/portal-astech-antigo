<?php include('header.php'); ?>

<?php
if(usuarioestalogado()){
	?>
	<div id="page-wrapper">
		<div class="row">
	        <div class="col-lg-12">
	            <h1 class="page-header"><i class="fa fa-cogs fa-fw"></i> Log de Informações</h1>
	        </div>
	        <!-- /.col-lg-12 -->
	    </div>
	   	<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Informações Cadastradas
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th width="7%">ID</th>
                                    <th width="15%">Nome</th>
                                    <th>Email </th>
                                    <th width="10%">Ação </th>
                                    <th>Local</th>
                                    <th width="15%">Data</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
								$busca_info = "SELECT * FROM log_informacoes";
								$result_info = mysqli_query($mysqli, $busca_info);
								
								while($row_info = mysqli_fetch_assoc($result_info)){
                            	?>
                                <tr class="even gradeC">
                                    <td><center><?php echo $row_info['id']; ?></center></td>
                                    <td><?php echo $row_info['nome']; ?></td>
                                    <td><?php echo $row_info['email']; ?></td>
                                    <td><center><?php echo ucfirst($row_info['acao']); ?></center></td>
                                    <td><?php echo utf8_encode($row_info['local']); ?></td>
                                    <td class="center"><?php echo date('d/m/Y H:m:s', strtotime($row_info['data'])); ?></td>
                                </tr>
                                <?php
								}
                                ?>
                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
	</div>
	<?php
}
else{
	echo '<script>alert("Nenhum usuário logado no sistema.");window.location.href="http://portalastech.chiaperini.com.br/admin"</script>';
}
?>
	<!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>