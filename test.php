<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$db_pres = new db($cartella_ini,$messaggi_errore,true);
?>

?>
<html>
	<head>
		<title>PAGINA DI TEST PHP</title>
		<link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
	</head>
	<body>
		<form action="test.php" method="post" enctype="multipart/form-data">
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
		<?php
		if(isset($_POST['register']))
		{
			$db_pres->inserisci_img($_FILES['athl_image']['name'],$_FILES['athl_image']['tmp_name'],$_FILES['athl_image']['size']);
		}
		?>
		
	</body>
</html>