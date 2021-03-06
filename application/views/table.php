
<?php include 'header.php'?>
<body>
<div id="wrapper">
<?php include 'navbar.php'?>
<?php include 'sidebar.php'?>
<div id="page-wrapper">
	<div class="row">
 		<div class="col-lg-12">
   		<h1 class="page-header"><?=$title?></h1>
 		</div>
			<!-- /.col-lg-12 -->
		</div>
   	<!-- /.row -->
   	<div class="row">
   		<div class="col-lg-12">
     		<div class="panel panel-default">
       		<div class="panel-heading">
         		<?=$desc?> &nbsp&nbsp<a href='<?=$create_data?>' class='fa fa-plus'> Create </a>
         	</div>
         	<!-- /.panel-heading -->
        	<div class="panel-body">
         		<div class="dataTable_wrapper">
           		<table class="table table-striped table-bordered table-hover" id="dataTables-example">
             		<thead>
               		<tr>
    							<?php foreach ($desc_headers as $header) { 
                 					echo "<th>$header</th>";
    										} 
                   			echo "<th>Actions</th>";
									?>
                 	</tr>
            		</thead>
              	<tbody>
								<?php 
									foreach ($table_data['rows'] as $row) { 
                 		echo '<tr class="odd gradeX">';
										foreach ($headers as $header) { 
                   		echo "<td>" . $row->$header . "</td>";
    								} 
                   	echo "<td><a href='" . $delete_data ."/" . $row->id . "' class='fa fa-times'/>";
                   	echo "</a>&nbsp&nbsp&nbsp<a href='". $edit_data . "/" . $row->id ."' class='fa fa-edit'/></td>";
                   	echo '</tr>';
									}
								?>
		
   							</tbody>
           	</table>
         	</div>
         	<!-- /.table-responsive -->

 				</div>
				<!-- /.panel-body -->
     	</div>
     	<!-- /.panel -->
 		</div>
 	<!-- /.col-lg-12 -->
	</div>

</div>
	<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<?php include 'footer.php'?>
<!-- DataTables JavaScript -->
<script src="<?=base_url()?>/bower_components/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>

</body>

</html>
