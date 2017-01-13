<?php
session_start();
include "database.php";
if(!isset($_SESSION['user_email']))
	{
		header("location: login.php");
	}
?>
<!DOCTYPE html>


<html>
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Nuovo Atleta</title>
		<meta name="description" content="">
		<meta name="author" content="Holgs">
		<!-- <meta name="viewport" content="width=device-width; initial-scale=1.0"> -->
		<link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/style.css" />
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
	</head>
	<body>
		<div class="jumbotron">
			<div class="container">
				<h2 class="text-center">Modulo di registrazione nuovo Atleta</h2>
				<form action="new_athlete.php" method="post" enctype="multipart/form-data">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nome</label>
							<input type="text" class="form-control" name="athl_name" placeholder="Inserisci il nome" required="required"/>
						</div>
						
						<div class="form-group"><label>Cognome</label>
							<input type="text" class="form-control" name="athl_surname" placeholder="Inserisci il nome" required="required"/>
						</div>
						
						<div class="form-group"><label>Sesso</label>
							<select name="athl_gender" class="form-control" required="required">
								<option>Maschio</option>
								<option>Femmina</option>
							</select>
						</div>
						
						<div class="form-group"><label>Data di nascita:</label>
						<input type="date" class="form-control" name="athl_b_day" required="required"/></div>
						
						<div class="form-group"><label>Email</label>
						<input type="text" class="form-control" name="athl_email" placeholder="Inserisci la email" required="required"/></div>
						
						<div class="form-group"><label>Numero di Telefono:</label>
						<input type="text" class="form-control" name="athl_no" placeholder="Inserisci il tuo Numero di telefono" required="required"/></div>
					</div>
					<div class="col-md-6">

						<div class="form-group"><label>Indirizzo:</label>
						<input type="text" class="form-control" name="athl_address" placeholder="Inserisci il tuo Indirizzo" required="required"></div>
						
						<div class="form-group"><label>Città:</label>
						<input type="text" class="form-control" name="athl_city" placeholder="Inserisci la Città" required="required"></div>
						
						<div class="form-group"><label>CAP:</label>
						<input type="text" class="form-control" name="athl_zip" placeholder="Inserisci il CAP" required="required"></div>
						
						<div class="form-group"><label>Provincia:</label>
						<input type="text" class="form-control" name="athl_pr" placeholder="Inserisci la Procincia" required="required"></div>
						
						<div class="form-group"><label>Cintura</label>
							<select name="athl_ryu_belt" class="form-control" required="required">
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
						
						<div class="form-group"><label>Immagine:</label>
						<input class="btn btn-default" type="file" name="athl_image" required="required"/>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<input type="submit" class="form-control btn btn-success" name="register" value="Registra Atleta!"/>
						</div>						
					</div>
				</form>								
				<div class="page-header text-center">
					<p><a href="index_home.php">indietro</a></p>
				</div>
				<div class="page-header text-right">Benvenuto: <?php echo $_SESSION['user_email'];?> - <a href="index_home.php">Home</a> - <a href="logout.php">Logout</a></div>
				</div>
			</div>			
		</div>
		
		<?php

		if(isset($_POST['register']))
		{
		
			$athl_name = mysqli_real_escape_string($con,$_POST['athl_name']);
			$athl_surname = mysqli_real_escape_string($con,$_POST['athl_surname']);
			$athl_address = mysqli_real_escape_string($con,$_POST['athl_address']);
			$athl_city = mysqli_real_escape_string($con,$_POST['athl_city']);
			$athl_zip = mysqli_real_escape_string($con,$_POST['athl_zip']);
			$athl_pr = mysqli_real_escape_string($con,$_POST['athl_pr']);
			$athl_b_day = mysqli_real_escape_string($con,$_POST['athl_b_day']);
			$athl_no = mysqli_real_escape_string($con,$_POST['athl_no']);
			$athl_email = mysqli_real_escape_string($con,$_POST['athl_email']);
			$athl_gender = mysqli_real_escape_string($con,$_POST['athl_gender']);
			$athl_ryu_belt = mysqli_real_escape_string($con,$_POST['athl_ryu_belt']);

			$athl_image = $_FILES['athl_image']['name'];
			$athl_tmp = $_FILES['athl_image']['tmp_name'];

			if($athl_address =='' OR $athl_image =='' OR $athl_gender='')
			{
				echo "<script>alert('Compila tutti i campi!')</script>";
				exit();
			}
		
			if(!filter_var($athl_email,FILTER_VALIDATE_EMAIL))
			{
				echo "<script>alert('La tua email non è valida!')</script>";
				exit();
			}
			//$_SESSION['user_email'] = $user_email;
			
			move_uploaded_file($athl_tmp,"images/$athl_image");
			
			// QUERY INSERIMENTO ATLETA
			$insert = "INSERT INTO athletes 
			(athl_name,athl_surname,athl_email,athl_address,athl_zip,athl_city,athl_pr,athl_gender,athl_b_day,athl_no,athl_image,athl_register_date) 
			VALUES ('$athl_name','$athl_surname','$athl_email','$athl_address','$athl_zip','$athl_city','$athl_pr','$athl_gender','$athl_b_day','$athl_no','$athl_image',NOW())";
			$run_insert = mysqli_query($con,$insert);
			
			// QUERY DI OTTENIMENTO ATHL_ID APPENA INSERITO
			$get_athl_id = "SELECT athl_id FROM athletes ORDER BY athl_id DESC LIMIT 1";
			$athl_result = mysqli_query($con,$get_athl_id);
			$athl_row = mysqli_fetch_row($athl_result);
			$athl_id = $athl_row[0];
			//echo "<script>alert('Athl_id caricato $athl_id')</script>";
			
			// QUERY DI INSERIMENTO CINTURA
			$insert_belt = "INSERT INTO athletes_ryu (athl_ryu_athl_id,athl_ryu_belt,athl_ryu_data) VALUES ('$athl_id','$athl_ryu_belt',NOW())";
			$run_insert_belt = mysqli_query($con,$insert_belt);
			
			// VERIFICA CORRETTO INSERIMENTO ATLETA e CINTURA
			if($run_insert && $run_insert_belt)
				{
					echo "<script>alert('Atleta inserito con successo!')</script>";
					echo "<script>window.open('index_home.php','_self')</script>";
				}
		}
		?>
	</body>
</html>
