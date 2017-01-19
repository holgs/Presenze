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
	$sel = "SELECT * FROM register_user WHERE user_id='$edit_id'";
	
	$run = $db_pres->select_row($sel);
	$row = $run->fetch_array();
	
	$id = $row['user_id'];
	$name = $row['user_name'];	
	$surname = $row['user_surname'];
	$phone_no = $row['user_no'];
	$email = $row['user_email'];
	$pass = $row['user_pass'];
}


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Modifica Utente</title>
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
				<h2 class="text-center">Modulo di modifca Utente: <?php echo $name." ".$surname;?></h2>
				<form action="edit_user.php?id=<?php echo $edit_id ;?>" method="post" enctype="multipart/form-data">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
							<label>Nome</label>
							<input type="text" class="form-control" name="user_name" value="<?php echo $name ;?>"/>
						</div>
						
						<div class="form-group">
							<label>Cognome</label>
							<input type="text" class="form-control" name="user_surname" value="<?php echo $surname ;?>"/>
						</div>
						
						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control" name="user_email" value="<?php echo $email ;?>"/>
						</div>
						
						<div class="form-group">
							<label>Password</label>
							<input type="text" class="form-control" name="user_pass" value="<?php echo $pass ;?>"/>
						</div>
						
						<div class="form-group">
							<label>Numero di Telefono:</label>
							<input type="text" class="form-control" name="user_no" value="<?php echo $phone_no ;?>"/>
						</div>
						<!--
						<div class="form-group">
							<label>Immagine:</label>
							<input class="btn btn-default" type="file" name="user_image"/>
						</div>
						-->
						<div class="form-group">
								<input type="submit" class="form-control btn btn-success" name="update" value="Aggiorna Utente!"/>
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

		if(isset($_POST['update']))
		{
			$db_pres->aggiorna_utente($id);
		}
		$db_pres->close();
		
		?>
	</body>
</html>
