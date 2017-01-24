<?php
session_start();
include "function_setup.php";
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
} else
{
	$db_pres = new db($cartella_ini,$messaggi_errore,true);
	
?>

<?php
      $email = $_SESSION['user_email'];
			$sel = "SELECT * FROM register_user where user_email='$email'";
			
			$risultato_query = $db_pres->select_row($sel);
			//while($riga = mysqli_fetch_assoc($risultato_query))
			while($riga = $risultato_query->fetch_array())
			{
				$righe_estratte[] = $riga;
			}
			//$row = $db_pres->db->fetch_array($run);
			//print_r($righe_estratte);
			$id = $righe_estratte[0]['user_id'];
			$name = $righe_estratte[0]['user_name'];
			$_SESSION['username'] = $name;

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Gestione Iscritti</title>
		<link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
 		<meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
	</head>
	<body>
		<div class="jumbotron">
			
			<div class="container">
				<div class="page-header text-center">
					<p>Ciao, <?php echo $name?>!</p>
				</div>

				<div class="row">
					<div class="col-md-4 col-sm-8">
						<div class="list-group ">
							<ol>
								<a href="presence.php?class=Bambini"><li class="list-group-item center-block"><b>Inserisci Presenze Bambini</b></li></a>
							</ol>	
						</div>
					</div>
					<div class="col-md-4 col-sm-8">
						<div class="list-group ">
							<ol>
								<a href="presence.php?class=Ragazzi"><li class="list-group-item center-block"><b>Inserisci Presenze Ragazzi</b></li></a>
							</ol>	
						</div>
					</div>					
					<div class="col-md-4 col-sm-8">
						<div class="list-group">
							<ol>
								<a href="presence.php?class=Adulti"><li class="list-group-item center-block"><b>Inserisci Presenze Adulti</b></li></a>
							</ol>	
						</div>
					</div>
				</div>
				
				<div class="clearfix visible-xs-block"></div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<div class="list-group">
								<ol>
									<a href="new_athlete.php"><li class="list-group-item"><b>Inserisci un nuovo atleta</b></li></a>
								</ol>	
							</div>
						</div>
						<div class="clearfix visible-xs-block"></div>
						<div class="col-md-4 col-sm-8">
							<div class="list-group">
								<ol>
									<a href="view_athletes.php?ordina=athl_name&come=ASC"><li class="list-group-item"><b>Mostra tutti gli atleti</b></li></a>
								</ol>	
							</div>
						</div>
						<div class="clearfix visible-xs-block"></div>
						<div class="col-md-4 col-sm-8">
							<div class="list-group">
								<ol>
									<a href="view_presenze.php"><li class="list-group-item"><b>Mostra report presenze</b></li></a>
								</ol>	
							</div>
						</div>
					</div>
					
					<div class="clearfix visible-xs-block"></div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<div class="list-group">
								<ol>
									<a href="export_athletes.php"><li class="list-group-item"><b>Esporta Atleti</b></li></a>
								</ol>	
							</div>
						</div>
						<div class="clearfix visible-xs-block"></div>
						<div class="col-md-4 col-sm-8">
							<div class="list-group">
								<ol>
									<a href="export_presenze_totali.php"><li class="list-group-item"><b>Esporta Presenze Totali</b></li></a>
								</ol>	
							</div>
						</div>
						<div class="clearfix visible-xs-block"></div>
						<div class="col-md-4 col-sm-8">
							<div class="list-group">
								<ol>
									<a href="#"><li class="list-group-item"><b></b></li></a>
								</ol>	
							</div>
						</div>
					</div>
				</div>
				
				<div class="page-header text-center">
					<p><a href="logout.php">Logout</a>	</p>
				</div>
						
			</div>
			
			
		</div>
		
	</body>
</html>
<?php
}    
?>