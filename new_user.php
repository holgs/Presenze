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
		<title>Nuovo Utente</title>
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
				<h2 class="text-center">Modulo di registrazione nuovo Utente</h2>
				<form action="new_user.php" method="post" enctype="multipart/form-data">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
							<label>Nome</label>
							<input type="text" class="form-control" name="user_name" placeholder="Inserisci il nome" required="required"/>
						</div>
						
						<div class="form-group">
							<label>Cognome</label>
							<input type="text" class="form-control" name="user_surname" placeholder="Inserisci il cognome" required="required"/>
						</div>
						
<!--						<div class="form-group">
							<label>Data di nascita:</label>
							<input type="date" class="form-control" name="user_b_day" required="required"/>
						</div>
-->						
						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control" name="user_email" placeholder="Inserisci la email" required="required"/>
						</div>
						
						<div class="form-group">
							<label>Password</label>
							<input type="text" class="form-control" name="user_pass" placeholder="Inserisci la password" required="required"/>
						</div>
						
						<div class="form-group">
							<label>Numero di Telefono:</label>
							<input type="text" class="form-control" name="user_no" placeholder="Inserisci il tuo Numero di telefono" required="required"/>
						</div>
						
						<div class="form-group">
							<label>Immagine:</label>
							<input class="btn btn-default" type="file" name="user_image" required="required"/>
						</div>
						<div class="form-group">
								<input type="submit" class="form-control btn btn-success" name="register_user" value="Registra Utente!"/>
						</div>	
					</div>
				</form>		
				<div class="col-md-12 col-sm-12 col-sx-12">						
				<div class="page-header text-center">
					<p><a href="view_users.php">indietro</a></p>
				</div>
				<div class="page-header text-right">Benvenuto: <?php echo $_SESSION['user_email'];?> - <a href="view_users.php">Home</a> - <a href="logout.php">Logout</a></div>
				</div>
			</div>			
		</div>
		
		<?php

		if(isset($_POST['register_user']))
		{
			$db_pres->inserisci_utente();
		}
		$db_pres->close();
		
		?>
	</body>
</html>
