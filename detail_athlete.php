<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
} else if(isset($_GET['id']))
	{
		//$con = connessione($messaggi_errore);
		$db_pres = new db($cartella_ini,$messaggi_errore,true);
		
		$edit_id = $_GET['id'];
		$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id WHERE athl_id='$edit_id'";
		
		$run = $db_pres->select_row($sel);
		$row = $run->fetch_array();
//		$row = mysqli_fetch_array($run);
		
		$id = $row['athl_id'];
		$name = $row['athl_name'];
		$surname = $row['athl_surname'];
		$address = $row['athl_address'];
		$city = $row['athl_city'];
		$zip = $row['athl_zip'];
		$pr = $row['athl_pr'];
		$b_day = date_create($row['athl_b_day']);
		$phone_no = $row['athl_no'];
		$email = $row['athl_email'];
		$image = $row['athl_image'];
		$class = $row['athl_class'];
		$register_date = $row['athl_register_date'];
		$belt = $row['athl_ryu_belt'];
		$data_belt = date_create($row['athl_ryu_data']);
				
	}
	
?>
<!DOCTYPE html>


<html>
	<head>
		<title>Visualizza dettagli Atleta</title>
        <link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/style.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
	</head>

	<body>
		<div class="jumbotron">
			<div class="container">
			    <h2>Visualizza dettagli Atleta: <?php echo $name.' '.$surname ;?></h2>
				<div class="col-md-6 col-sm-10 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-body text-center">
						    <img src="images/foto/<?php echo $image;?>" style="max-width:510px;max-height:287px;">
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">Data di nascita</div>
						<div class="panel-body">
						    <?php echo date_format($b_day,'d/m/Y');?>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">E-Mail</div>
						<div class="panel-body">
						    <?php echo $email ;?>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">Numero di telefono</div>
						<div class="panel-body">
						    <?php echo $phone_no ;?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-10 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">Indirizzo</div>
						<div class="panel-body">
						    <?php echo $address ;?>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">Città</div>
						<div class="panel-body">
						    <?php echo $city ;?>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">Cap</div>
						<div class="panel-body">
						    <?php echo $zip ;?>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">Provincia</div>
						<div class="panel-body">
						    <?php echo $pr ;?>
						</div>
					</div>
				</div>
					<div class="col-md-3 col-sm-10 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading">Cintura</div>
							<div class="panel-body">
							    <?php echo $belt ;?>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-10 col-xs-12">			
						<div class="panel panel-default">
							<div class="panel-heading">Data passaggio cintura</div>
							<div class="panel-body">
							    <?php echo date_format($data_belt,'d/m/Y') ;?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-10 col-xs-12">								
						<div class="panel panel-default">
							<div class="panel-heading">Classe</div>
							<div class="panel-body">
							    <?php echo $class ;?>
							</div>
						</div>		
					</div>			
					
					
				<div class="row">
					<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-sx-8 "> <!--  col-md-offset-10 col-sm-offset-6 col-xs-12 col-sx-offset-6 -->
						<button type="button" class="panel-body btn btn-block btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
						Presenze
						</button>
					</div>
					
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Elenco Presenze</h4>
						</div>
						<div class="modal-body">
							<?php	$db_pres->valuta_presenza($edit_id); ?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
						</div>
					  </div>
					</div>
				  </div>
				</div>
				<div class="page-header text-center">
					<p><a href="view_athletes.php">indietro</a></p>
				</div>
				<div class="page-header text-right">Benvenuto: <?php echo $_SESSION['user_email']." - ".$_SESSION['username'];?> - <a href="index_home.php">Home</a> - <a href="logout.php">Logout</a></div>
				</div>
		</div>
	</body>
</html>
