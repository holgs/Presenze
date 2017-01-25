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
			while($riga = $risultato_query->fetch_array())
			{
				$righe_estratte[] = $riga;
			}
			$id = $righe_estratte[0]['user_id'];
			$name = $righe_estratte[0]['user_name'];
			$_SESSION['username'] = $name;

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Gestione Iscritti</title>
		<?php include 'header_head.php';?>

	</head>
	<body>
		<div class="wrapper">
		<?php include 'sidebar.php';?>  

			<div class="main-panel">
				<?php include 'header.php';?>
				
		
			
		<div class="content">
			<div class="container-fluid">


<!-- -------- PRIMA RIGA DI PULSANTI -------- -->
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<a href="presence.php?class=Bambini">
							<div class="card card-stats">
								<div class="card-header" data-background-color="green">
									<i class="material-icons">check_box</i>
								</div>
								<div class="card-content">
									<p class="category">Inserisci presenze</p>
									<h3 class="title">Bambini</h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons text-danger">warning</i><?php echo date('l \t\h\e jS');?>
									</div>
								</div>
							</div>
						</a>							
					</div>
					<div class="col-md-4 col-sm-8">
						<a href="presence.php?class=Ragazzi">
							<div class="card card-stats">
								<div class="card-header" data-background-color="blue">
									<i class="material-icons">check_box</i>
								</div>
								<div class="card-content">
									<p class="category">Inserisci presenze</p>
									<h3 class="title">Ragazzi</h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons text-danger">warning</i><?php echo date('l \t\h\e jS');?>
									</div>
								</div>
							</div>
						</a>
					</div>					
					<div class="col-md-4 col-sm-8">
						<a href="presence.php?class=Adulti">
							<div class="card card-stats">
								<div class="card-header" data-background-color="orange">
									<i class="material-icons">check_box</i>
								</div>
								<div class="card-content">
									<p class="category">Inserisci presenze</p>
									<h3 class="title">Adulti</h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons text-danger">warning</i><?php echo date('l \t\h\e jS');?>
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
<!-- -------- SECONDA RIGA DI PULSANTI -------- -->
				<div class="clearfix visible-xs-block"></div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<a href="new_athlete.php">
								<div class="card card-stats">
									<div class="card-header" data-background-color="red">
										<i class="material-icons">person_add</i>
									</div>
									<div class="card-content">
										<p class="category">Inserisci</p>
										<h3 class="title">Nuovo Atleta</h3>
									</div>
									<div class="card-footer">
										<div class="stats">
											<i class="material-icons text-danger">warning</i>23/12/2017
										</div>
									</div>
								</div>	
							</a>
						</div>
						<div class="clearfix visible-xs-block"></div>
						<div class="col-md-4 col-sm-8">
							<a href="view_athletes.php?ordina=athl_name&come=ASC">
								<div class="card card-stats">
									<div class="card-header" data-background-color="red">
										<i class="material-icons">view_list</i>
									</div>
									<div class="card-content">
										<p class="category">Mostra</p>
										<h3 class="title">Tutti gli Atleti</h3>
									</div>
									<div class="card-footer">
										<div class="stats">
											<i class="material-icons text-danger">warning</i>23/12/2017
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="clearfix visible-xs-block"></div>
						<div class="col-md-4 col-sm-8">
							<a href="export_athletes.php">
								<div class="card card-stats">
									<div class="card-header" data-background-color="red">
										<i class="material-icons">print</i>
									</div>
									<div class="card-content">
										<p class="category">Esporta</p>
										<h3 class="title">Atleti</h3>
									</div>
									<div class="card-footer">
										<div class="stats">
											<i class="material-icons text-danger">warning</i>23/12/2017
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
<!-- -------- TERZA RIGA DI PULSANTI -------- -->
					<div class="clearfix visible-xs-block"></div>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<a href="view_presenze.php">
								<div class="card card-stats">
								<div class="card-header" data-background-color="purple">
									<i class="material-icons">library_books</i>
								</div>
								<div class="card-content">
									<p class="category">Mostra</p>
									<h3 class="title">Presenze</h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons text-danger">warning</i>23/12/2017
									</div>
								</div>
							</div>
								
							</a>
						</div>
						<div class="clearfix visible-xs-block"></div>
						<div class="col-md-4 col-sm-8">
							<a href="export_presenze_totali.php">
								<div class="card card-stats">
								<div class="card-header" data-background-color="purple">
									<i class="material-icons">reorder</i>
								</div>
								<div class="card-content">
									<p class="category">Esporta</p>
									<h3 class="title">Presenze totali</h3>
								</div>
								<div class="card-footer">
									<div class="stats">
										<i class="material-icons text-danger">warning</i>23/12/2017
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- FINE DIV MAIN PANEL-->
	</div> <!-- FINE DIV WRAPPER -->
			
		
	</body>
	<?php include 'footer.php';?>
</html>
<?php
}    
?>