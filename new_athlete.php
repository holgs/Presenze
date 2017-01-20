<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$db_pres = new db($cartella_ini,$messaggi_errore,true);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Nuovo Atleta</title>
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Holgs">
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
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Nome</label>
							<input type="text" class="form-control" name="athl_name" placeholder="Inserisci il nome" required="required"/>
						</div>
						
						<div class="form-group"><label>Cognome</label>
							<input type="text" class="form-control" name="athl_surname" placeholder="Inserisci il cognome" required="required"/>
						</div>
						
						<div class="form-group"><label>Sesso</label>
							<select name="athl_gender" class="form-control" required="required">
								<option>Maschio</option>
								<option>Femmina</option>
							</select>
						</div>
						
						<div class="form-group"><label>Data di nascita:</label>
						<input type="date" class="form-control" name="athl_b_day" /></div>
						
						<div class="form-group"><label>Email</label>
						<input type="text" class="form-control" name="athl_email" placeholder="Inserisci la email" /></div>
						
						<div class="form-group"><label>Numero di Telefono:</label>
						<input type="text" class="form-control" name="athl_no" placeholder="Inserisci il tuo Numero di telefono" /></div>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12">

						<div class="form-group"><label>Indirizzo:</label>
						<input type="text" class="form-control" name="athl_address" placeholder="Inserisci il tuo Indirizzo" ></div>
						
						<div class="form-group"><label>Città:</label>
						<input type="text" class="form-control" name="athl_city" placeholder="Inserisci la Città" ></div>
						
						<div class="form-group"><label>CAP:</label>
						<input type="text" class="form-control" name="athl_zip" placeholder="Inserisci il CAP" ></div>
						
						<div class="form-group"><label>Provincia:</label>
						<input type="text" class="form-control" name="athl_pr" placeholder="Inserisci la Procincia" ></div>
						
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

						<div class="form-group"><label>Classe</label>
							<select name="athl_class" class="form-control" required="required">
								<option>Bambini</option>
								<option>Ragazzi</option>
								<option>Adulti</option>
							</select>
						</div>


					</div>
					<!-- IMMAGINE -->
					<div class="col-md-12 col-xs-12">
						<div class="form-group"><label>Immagine:</label>
							<input class="btn btn-default" type="file" name="athl_image" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-xs-12">
							<div class="form-group">
								<input type="submit" class="form-control btn btn-success" name="register" value="Registra Atleta!"/>
							</div>	
						</div>					
					</div>
				</form>		
										
				<div class="page-header text-center">
					<p><a href="index_home.php">indietro</a></p>
				</div>
				<div class="page-header text-right">Benvenuto: <?php echo $_SESSION['user_email']." - ".$_SESSION['username'];?> - <a href="index_home.php">Home</a> - <a href="logout.php">Logout</a></div>
				</div>
			</div>			
		</div>
		
		<?php

		if(isset($_POST['register']))
		{
			$db_pres->inserisci_atleta();
		}
		$db_pres->close();
		
		?>
	</body>
</html>
