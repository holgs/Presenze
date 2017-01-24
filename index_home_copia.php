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
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			            <span class="sr-only">Toggle navigation</span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Brand</a>
				</div>
			
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
					<li class="active"><a href="#">Link</a></li>
			    		<li><a href="#">Link</a></li>
			    		<li class="dropdown">
			    			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
			    			<ul class="dropdown-menu">
						  <li><a href="#">Action</a></li>
						  <li><a href="#">Another action</a></li>
						  <li><a href="#">Something else here</a></li>
						  <li class="divider"></li>
						  <li><a href="#">Separated link</a></li>
						  <li class="divider"></li>
					      <li><a href="#">One more separated link</a></li>
			    			</ul>
			    		</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="jumbotron">
			
			<div class="container">
				<div class="page-header text-center">
					<p>Ciao, <?php echo $name?>!</p>
				</div>
<!-- -------- PRIMA RIGA DI PULSANTI -------- -->
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<div class="thumbnail">
							<div style="height:100px;"></div>
							<div class="caption" align="center">
								<a href="presence.php?class=Bambini"><b>Inserisci Presenze Bambini</b></a>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-8">
						<div class="thumbnail ">
							<div style="height:100px;"></div>
							<div class="caption" align="center">
								<a href="presence.php?class=Ragazzi"><b>Inserisci Presenze Ragazzi</b></a>
							</div>
						</div>
					</div>					
					<div class="col-md-4 col-sm-8">
						<div class="thumbnail">
							<div style="height:100px;"></div>
							<div class="caption" align="center">
								<a href="presence.php?class=Adulti"><b>Inserisci Presenze Adulti</b></a>
							</div>
						</div>
					</div>
				</div>
<!-- -------- SECONDA RIGA DI PULSANTI -------- -->
				<div class="clearfix visible-xs-block"></div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<div class="thumbnail">
								<div style="height:100px;"></div>
								<div class="caption" align="center">
									<a href="new_athlete.php"><b>Inserisci un nuovo atleta</b></a>
								</div>	
							</div>
						</div>
						<div class="clearfix visible-xs-block"></div>
						<div class="col-md-4 col-sm-8">
							<div class="thumbnail">
								<div style="height:100px;"></div>
								<div class="caption" align="center">
									<a href="view_athletes.php?ordina=athl_name&come=ASC"><b>Mostra tutti gli atleti</b></a>
								</div>	
							</div>
						</div>
						<div class="clearfix visible-xs-block"></div>
						<div class="col-md-4 col-sm-8">
							<div class="thumbnail">
								<div style="height:100px;"></div>
								<div class="caption" align="center">
									<a href="view_presenze.php"><b>Mostra report presenze</b></a>
								</div>	
							</div>
						</div>
					</div>
<!-- -------- TERZA RIGA DI PULSANTI -------- -->
					<div class="clearfix visible-xs-block"></div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<div class="thumbnail">
								<div style="height:100px;"></div>
								<div class="caption" align="center">
									<a href="export_athletes.php"><b>Esporta Atleti</b></a>
								</div>	
							</div>
						</div>
						<div class="clearfix visible-xs-block"></div>
						<div class="col-md-4 col-sm-8">
							<div class="thumbnail">
								<div style="height:100px;"></div>
								<div class="caption" align="center">
									<a href="export_presenze_totali.php"><b>Esporta Presenze Totali</b></a>
								</div>	
							</div>
						</div>
						<div class="clearfix visible-xs-block"></div>
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