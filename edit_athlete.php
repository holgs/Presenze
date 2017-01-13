<?php
session_start();
include "database.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
} else if(isset($_GET['id']))
	{
		$edit_id = $_GET['id'];
		$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id WHERE athl_id='$edit_id'";
		//DATE_FORMAT(athl_b_day, '%d/%m/%Y')as athl_b_day 
		$run = mysqli_query($con,$sel);
		$row = mysqli_fetch_array($run);
		
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
		$register_date = $row['athl_register_date'];
		$belt = $row['athl_ryu_belt'];
		$data_belt = date_create($row['athl_ryu_data']);	
	}
?>
<!DOCTYPE html>

<html>
	<head>

		<title>Modifica Atleta</title>
		<link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/style.css" />
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
	</head>

	<body>
		<div class="jumbotron">
			<div class="container">
				<h2 class="text-center">Modifica dettagli Atleta:  <?php echo $name.' '.$surname ;?></h2>
				<form action="edit_athlete.php?id=<?php echo $edit_id;?>" method="post" enctype="multipart/form-data">
					<div class="col-md-6">
						<div class="form-group"><label>Name</label>
							<input type="text" class="form-control"  name="athl_name" value="<?php echo $name ;?>"/>
						</div>
						<div class="form-group"><label>Cognome</label>
							<input type="text" class="form-control"  name="athl_surname" value="<?php echo $surname ;?>"/>
						</div>
						<div class="form-group"><label>Sesso</label>
							<select name="athl_gender" class="form-control">
								<option>Maschio</option>
								<option>Femmina</option>
							</select>
						</div>
						<div class="form-group"><label>Data di nascita</label>
							<input type="text" class="form-control"  name="athl_b_day" value="<?php echo date_format($b_day,'d/m/Y') ;?>"/>
						</div>
						<div class="form-group"><label>Email></label>
							<input type="text" class="form-control"  name="athl_email" value="<?php echo $email ;?>"/>						
						</div>
						<div class="form-group"><label>Numero di telefono:</label>
							<input type="text" class="form-control"  name="athl_no" value="<?php echo $phone_no; ?>"/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group"><label>Indirizzo:</label>
							<input type="text" class="form-control"  name="athl_address" value="<?php echo $address; ?>"/>
						</div>
						<div class="form-group"><label>Città:</label>
							<input type="text" class="form-control"  name="athl_city" value="<?php echo $city; ?>"/>
						</div>
						<div class="form-group"><label>Cap:</label>
							<input type="text" class="form-control"  name="athl_zip" value="<?php echo $zip; ?>"/>
						</div>
						<div class="form-group"><label>Provincia:</label>
							<input type="text" class="form-control"  name="athl_pr" value="<?php echo $pr; ?>"/>
						</div>
						<div class="form-group"><label>Cintura:</label>
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
						<div class="col-md-6">
							<div class="form-group"><label>Data di Ottenimento Cintura</label>
							<input type="text" class="form-control"  name="athl_ryu_data" value="<?php echo date_format($data_belt,'d/m/Y') ;?>"/>	
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group"><label>Cambia immagine</label>
							<button type="button" class="form-control btn btn-default" data-toggle="modal" data-target="#myModal">Cambia immagine</button>
							</div>
						</div>
						</div>
		
					<div class="row">
						<div class="form-group">
							<input type="submit" class="form-control btn btn-success" name="update" value="Aggiorna!"/>
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
					Benvenuto: <?php echo $_SESSION['user_email'];?> - <a href="index_home.php">Home</a> - <a href="logout.php">Logout</a></div>
				</div>		
			</div>
		</div>
		<?php

		if(isset($_POST['update']))
		{
		
			$athl_name = mysqli_real_escape_string($con,$_POST['athl_name']);
			$athl_surname = mysqli_real_escape_string($con,$_POST['athl_surname']);
			$athl_b_day =mysqli_real_escape_string($con,$_POST['athl_b_day']);
			echo $athl_b_day;
			$athl_email = mysqli_real_escape_string($con,$_POST['athl_email']);
			$athl_no = mysqli_real_escape_string($con,$_POST['athl_no']);
			$athl_address = mysqli_real_escape_string($con,$_POST['athl_address']);
			$athl_city = mysqli_real_escape_string($con,$_POST['athl_city']);
			$athl_zip = mysqli_real_escape_string($con,$_POST['athl_zip']);
			$athl_pr = mysqli_real_escape_string($con,$_POST['athl_pr']);
			$athl_ryu_belt = mysqli_real_escape_string($con,$_POST['athl_ryu_belt']);
			$athl_ryu_data = mysqli_real_escape_string($con,$_POST['athl_ryu_data']);

			

			//if($user_address =='' OR $user_image =='')
			//{
			//	echo "<script>alert('Please fill all the fields!')</script>";
			//	exit();
			//}
		
			if(!filter_var($athl_email,FILTER_VALIDATE_EMAIL))
			{
				echo "<script>alert('L'indirizzo email non è valido!')</script>";
				exit();
			}
			//$_SESSION['user_email'] = $user_email;
			//$query = "INSERT INTO table VALUES('" . STR_TO_DATE($data_input, '%d/%m/%Y' )."')";
			$fmt ="'%d/%m/%Y'";
			$update = "UPDATE athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id
							SET athl_name='$athl_name',
							athl_surname='$athl_surname',
							athl_b_day=STR_TO_DATE('$athl_b_day',$fmt),
							athl_email='$athl_email',
							athl_no='$athl_no',
							athl_address='$athl_address',
							athl_city='$athl_city',
							athl_zip='$athl_zip',
							athl_pr='$athl_pr',
							athl_ryu_belt='$athl_ryu_belt',
							athl_ryu_data=STR_TO_DATE('$athl_ryu_data',$fmt)
							WHERE athl_id='$edit_id'";
			

			$run_update = mysqli_query($con,$update);
			
				if($run_update)
				{
					echo "<script>alert('Aggiornamento completato con successo')</script>";
					echo "<script>window.open('view_athletes.php','_self')</script>";

				} else {
					echo "<script>alert('Aggiornamento non effettuato')</script>";
				}
		}
		
		if(isset($_POST['update_image'])){
			$athl_image = $_FILES['athl_image']['name'];
			$athl_tmp = $_FILES['athl_image']['tmp_name'];
			
			move_uploaded_file($athl_tmp,"images/$athl_image");
			
			$update_image ="UPDATE athletes SET athl_image='$athl_image' WHERE athl_id='$edit_id'";
			
			$run_update_image = mysqli_query($con,$update_image);
			if($run_update_image)
			{
				echo"<script>alert('Aggiornamento immagine completato con successo')</script>";
				echo "<script>window.open('view_athletes.php','_self')</script>";

			} else {
					echo "<script>alert('Aggiornamento non effettuato')</script>";
			}
		}
		?>
	</body>
</html>
