<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$name = $_SESSION['username'];
$db_pres = new db($cartella_ini,$messaggi_errore,true);
?>

<html>
    <head>
        <title>Inserisci presenze</title>
       <?php include 'header_head.php';?>

    </head>
    <body>
        <!-- NAV BAR -->
 		<div class="wrapper">
		<?php include 'sidebar.php';?>
			<div class="main-panel">
				<?php include 'header.php';?>
        <!-- PRODUCT BODY -->
				<div class="content">
					<div class="container-fluid">
						<div class="row">
							<!-- PIASTRELLA CON PRODOTTO SINGOLO-->
							<!-- INIZIO -->
							<?php
								$class = $_REQUEST['class'];			
								$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id LEFT JOIN athl_presence ON athl_id = athl_pres_athl_id AND athl_pres_date = CURDATE()  WHERE athl_class ='$class' GROUP BY athl_id";
								$run = $db_pres->select_row($sel);
								
								while($row = mysqli_fetch_assoc($run)){
									$id = $row['athl_id'];
									$athlete = $row['athl_name']." ".$row['athl_surname'];
									$pres_recorded = $row['athl_pres_presence']; 		
									echo "
											<div class=''>
												<div class='col-md-6 col-sm-12 col-xs-12'>
													<div class='thumbnail' >
														<div style='height:60%;'>
															<img src='images/foto/$row[athl_image]' class='img-thumbnail center-block' style='max-height:100%;' />
														</div>
														<div style='height:60px;'>
															<div class='caption text-center'>
																<h4>$athlete</h4>
															</div>
														</div>";
									if($pres_recorded ==''){				
										echo "					
													<div class='row' style='height:90px;'>
														<div class='col-md-5 col-md-offset-1'>
															<a href='presence.php?id=$id&presence=1&class=$class'><button class='btn btn-success btn-block'>PRESENTE</button>
															</a><br>
														</div>
														<div class='col-md-5'>
															<a href='presence.php?id=$id&presence=0&class=$class'><button class='btn btn-danger btn-block'>ASSENTE</button>
															</a>
														</div>
													</div>
													";
									} else {
										echo "					
													<div class='row' style='height:90px;'>
														<div class='col-md-5 col-md-offset-1'>
															<a href='presence.php'><button class='btn btn-success btn-block' disabled='disabled'>PRESENTE</button>
															</a><br>
														</div>
														<div class='col-md-5'>
															<a href='presence.php'><button class='btn btn-danger btn-block' disabled='disabled'>ASSENTE</button>
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
				<footer class="footer">
					<div class="container-fluid">
					<p><a href="<?php echo $_SERVER["HTTP_REFERER"];?>">Indietro</a></p>
					</div>
				</footer>
					</div>
				</div>
			</div>
		</div>        <div class="clearfix"></div>

    </body>
<?php
		//INSERISCI PRESENZA
		if(isset($_GET['id']) && isset($_GET['presence']))
		{
			$db_pres->athlete_presence($_GET['id'],$_GET['presence']);
			echo "<script>window.open('presence.php?class=".$_GET['class']."','_self')</script>";
		}
		?>
			
<?php include 'footer.php';?>

</html>
