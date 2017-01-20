<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
} else if(isset($_GET['id']))
	{
		$db_pres = new db($cartella_ini,$messaggi_errore,true);
		
		$edit_id = $_GET['id'];
		$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id WHERE athl_id='$edit_id'";
		//DATE_FORMAT(athl_b_day, '%d/%m/%Y')as athl_b_day 
		$run = $db_pres->select_row($sel);
		$row = $run->fetch_array();
				
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
		<meta charset="utf-8">
		<title>Modifica Atleta</title>
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Holgs">
		<link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
</head>	
<body>
	<div class="jumbotron">
		<div class="container">
			<h2 class="text-center">Modifica dettagli Atleta:  <?php echo $name.' '.$surname ;?></h2>
			<form action="edit_athlete.php?id=<?php echo $edit_id;?>" method="post" enctype="multipart/form-data">
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="athl_name" value="<?php echo $name ;?>"/>
					</div>
					<div class="form-group">
						<label>Cognome</label>
						<input type="text" class="form-control" name="athl_surname" value="<?php echo $surname ;?>"/>
					</div>
					<div class="form-group">
						<label>Sesso</label>
						<select name="athl_gender" class="form-control">
							<option>Maschio</option>
							<option>Femmina</option>
						</select>
					</div>
					<div class="form-group">
						<label>Data di nascita</label>
						<input type="text" class="form-control" name="athl_b_day" value="<?php echo date_format($b_day,'d/m/Y') ;?>"/>
					</div>
					<div class="form-group">
						<label>Email></label>
						<input type="text" class="form-control" name="athl_email" value="<?php echo $email ;?>"/>						
					</div>
					<div class="form-group">
						<label>Numero di telefono:</label>
						<input type="text" class="form-control" name="athl_no" value="<?php echo $phone_no; ?>"/>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label>Indirizzo:</label>
						<input type="text" class="form-control" name="athl_address" value="<?php echo $address; ?>"/>
					</div>
					<div class="form-group">
						<label>Città:</label>
						<input type="text" class="form-control" name="athl_city" value="<?php echo $city; ?>"/>
					</div>
					<div class="form-group">
						<label>Cap:</label>
						<input type="text" class="form-control" name="athl_zip" value="<?php echo $zip; ?>"/>
					</div>
					<div class="form-group">
						<label>Provincia:</label>
						<input type="text" class="form-control" name="athl_pr" value="<?php echo $pr; ?>"/>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="form-group"><label>Classe</label>
							<select name="athl_class" class="form-control" required="required">
								<option><?php echo $class;?></option>	
								<option>Bambini</option>
								<option>Ragazzi</option>
								<option>Adulti</option>
							</select>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">						
						<div class="form-group">
							<label>Cintura:</label>
							<select name="athl_ryu_belt" class="form-control" >
								<option><?php echo $belt;?></option>
								<option>Bianca</option>
								<option>Gialla</option>
								<option>Arancione</option>
								<option>Verde</option>
								<option>Blu</option>
								<option>Marrone</option>
								<option>Nera - 1° DAN</option>
								<option>Nera - 2° DAN</option>
								<option>Nera - 3° DAN</option>
								<option>Nera - 4° DAN</option>
								<option>Nera - 5° DAN</option>
							</select>
						</div>
					</div>	
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label>Data di Ottenimento Cintura</label>
						<input type="text" class="form-control" name="athl_ryu_data" value="<?php echo date_format($data_belt,'d/m/Y') ;?>"/>	
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label>Cambia immagine</label>
						<button type="button" class="form-control btn btn-default" data-toggle="modal" data-target="#myModal">Cambia immagine</button>
						</div>
					</div>
				</div>
	
				<div class="row">
					<div class="form-group col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-sx-8 ">
						<input type="submit" class="form-control btn btn-success btn-block" name="update" value="Aggiorna!"/>
					</div>
				</div>
			</form>
			
			<!-- MODAL PER CAMBIO IMMAGINE -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Cambia immagine</h4>
						</div>
						
						<div class="modal-body">
							<form action="" method="post" enctype="multipart/form-data">
								<div class="form-group">Seleziona l'immagine e clicca OK<br><br>
									<div class="col-md-6">							
										<input class="btn btn-default" type="file" name="athl_image"/>
									</div>
									<div class="col-md-3 col-md-offset-3">
										<input type="submit" class="form-control btn btn-success" name="update_image" value="OK"/>
									</div>
									<div class="row"></div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
						</div>
				  </div>
				</div>
			</div>
			<!-- FINE MODAL CAMBIO IMMAGINE -->
			<div class="page-header text-center">
				<p><a href="index_home.php">Indietro</a></p>
			</div>
			<div class="page-header text-right">
				Benvenuto: <?php echo $_SESSION['user_email']." - ".$_SESSION['username'];?> - <a href="index_home.php">Home</a> - <a href="logout.php">Logout</a></div>
			</div>		
		</div>
	</div>
	<?php
	if(isset($_POST['update']))
	{
	$db_pres->aggiorna_atleta($id);
	}
	
	if(isset($_POST['update_image']))
	{
		$db_pres->aggiorna_immagine($id,$name,$surname);
	}
	$db_pres->close();
	?>
	</body>
</html>
