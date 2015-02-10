
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
         		<?=$desc?> 
         	</div>
         	<!-- /.panel-heading -->
        	<div class="panel-body">
						<div class="col-lg-6">
 							<form role="form" method="post" action="<?=$submit_data?>">

								<?php

									foreach ($form_data as $fdata) {
										echo "<div class='form-group'>";
										echo "<label>" . $fdata['title'] ."</label>";

										if ($fdata['type'] == 'number') {
 											echo "<input type='number' name='" .
												 $fdata['name'] .
													"' class='form-control' min='0' step='1'>";
										}else if ( $fdata['type'] == 'textarea') {
 											echo "<textarea name='" .
												 $fdata['name'] .
													"' class='form-control' rows='5'> </textarea>";
							
										}else {
 											echo "<input name='" . $fdata['name'] ."' class='form-control'>";
										}
                  	echo "<p class='help-block'>" . $fdata['desc']. "</p>";


         						echo "</div>";
									}
								?>
								<button type="submit" class="btn btn-default">Submit</button>
								<button type="reset" class="btn btn-default">Reset</button>

							</form>
         		</div>
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
