<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$con = connessione($messaggi_errore);
?>

<html>
    <head>
        <title>Inserisci presenze</title>
        <link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/style.css" />
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
    </head>
    <body>
        <!-- NAV BAR -->
        

        <!-- PRDUCT BODY -->
		<div class="jumbotron">
			<div class="container">
				<div class="row">
					<!-- PIASTRELLA CON PRODOTTO SINGOLO-->
					<!-- INIZIO -->
					<?php
						$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id LEFT JOIN athl_presence ON athl_id = athl_pres_athl_id AND athl_pres_date = CURDATE() GROUP BY athl_id";
						$run = mysqli_query($con,$sel);
						
						while($row = mysqli_fetch_assoc($run)){
							$id = $row['athl_id'];
							$athlete = $row['athl_name']." ".$row['athl_surname'];
							$pres_recorded = $row['athl_pres_presence'];
							echo "
									<div class=''>
										<div class='col-sm-6 col-md-4'>
											<div class='thumbnail' style='height:350px;margin:10px;'>
												<div style='height:200px;'>
													<img src='images/$row[athl_image]' class='img-thumbnail center-block' style='max-width:320px;max-height:200px'/>
												</div>
												<div style='height:60px;'>
													<div class='caption text-center'>
														<h4>$athlete</h4>
													</div>
												</div>";
							if($pres_recorded ==''){				
								echo "					
											<div class='row' style='height:90px;'>
												<div class='col-sm-5 col-md-offset-1'>
													<a href='presence.php?id=$id&presence=1'><button class='btn btn-success btn-lg'>PRESENTE</button>
													</a>
												</div>
												<div class='col-sm-5'>
													<a href='presence.php?id=$id&presence=0'><button class='btn btn-danger btn-lg'>ASSENTE</button>
													</a>
												</div>
											</div>
											";
							} else {
								echo "					
											<div class='row' style='height:90px;'>
												<div class='col-sm-5 col-md-offset-1'>
													<a href='presence.php?id=$id&presence=1'><button class='btn btn-success btn-lg' disabled='disabled'>PRESENTE</button>
													</a>
												</div>
												<div class='col-sm-5'>
													<a href='presence.php?id=$id&presence=0'><button class='btn btn-danger btn-lg' disabled='disabled'>ASSENTE</button>
													</a>
												</div>
											</div>
											";
							}
							echo"
											</div>
										</div>
									</div>
									
							";
						}
					?>
					<!-- FINE -->
				</div>
				<div class="page-header text-center">
					<p><a href="index_home.php">Finito</a></p>
				</div>
				<div class="page-header text-right">Benvenuto: <?php echo $_SESSION['user_email'];?> - <a href="index_home.php">Home</a> - <a href="logout.php">Logout</a></div>
			</div>
			</div>
		</div>
        <div class="clearfix"></div>

    </body>
<?php
		//INSERISCI PRESENZA
		if(isset($_GET['id']) && isset($_GET['presence']))
		{
			athlete_presence($con,$_GET['id'],$_GET['presence']);
			echo "<script>window.open('presence.php','_self')</script>";
		}
		?>
			

</html>
