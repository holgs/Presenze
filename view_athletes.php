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


<html lang="en">
	<head>
		<title>Visualizza tutti gli atleti</title>
	<?php include 'header_head.php';?>
	</head>
	<body>
		<div class="wrapper">
		<?php include 'sidebar.php';?>  
			<div class="main-panel">
				<?php include 'header.php';?>
				<div class="content">
					<div class="container-fluid">
						
						
							<div class="row">
								<div class="col-md-12">
									<div class="card">
										<div class="card-header" data-background-color="red">
	                  	<h4 class="title">Visualizza tutti gli utenti</h4>
	                  	<p class="category">Here is a subtitle for this table</p>
	                  </div>
	                  <div class="card-content table-responsive">
											<table class="table table-hover" align="center">
												<thead class="text-danger" align="left">
													<th>Num</th>
													<th>Foto</th>
													<th>
														<a href="view_athletes.php?ordina=athl_name&come=
															<?php 
																if($_GET['come']=="ASC")
																{
																	$come="DESC";
																}
																else 
																{
																	$come="ASC";	
																}
																echo $come;
															?>
															" class="text-danger">
															Nome
														</a>
													</th>
													<th>
														<a href="view_athletes.php?ordina=athl_surname&come=
															<?php 
																if($_GET['come']=="ASC")
																{
																	$come="DESC";
																}
																else 
																{
																	$come="ASC";	
																}
																echo $come;
															?>
															" class="text-danger">
															Cognome
														</a>
													</th>
													<th>Compleanno</th>
													<th>E-mail</th>
													<th>Telefono</th>
													<th>
														<a href="view_athletes.php?ordina=athl_class&come=
															<?php 
																if($_GET['come']=="ASC")
																{
																	$come="DESC";
																}
																else 
																{
																	$come="ASC";	
																}
																echo $come;
															?>
															" class="text-danger">
															Classe
														</a>
													</th>
													<th>
														<a href="view_athletes.php?ordina=athl_ryu_nbelt&come=
															<?php 
																if($_GET['come']=="ASC")
																{
																	$come="DESC";
																}
																else 
																{
																	$come="ASC";	
																}
																echo $come;
															?>
															" class="text-danger">
															Cintura
														</a>
													</th>
													<th>Azioni</th>
													<th></th>
													<th></th>
												</thead>
												<?php
												// BLOCCO GESTIONE ORDINAMENTO -- INIZIO
												$ordina = $_GET['ordina'];
												$come = $_GET['come'];
												if($ordina == "" && $come =="")
												{
													$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id ORDER BY athl_name ASC";									
												}
												else 
												{
													switch ($come) 
													{
														case 'DESC':
															$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id ORDER BY $ordina DESC";
															$come == "ASC";
															break;
														case 'ASC':
															$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id ORDER BY $ordina ASC";
															$come == "DESC";
															break;
														default:
															$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id ORDER BY $ordina ASC";
															break;
													}
												}
												// BLOCCO GESTIONE ORDINAMENTO -- FINE
																				
													$run = $db_pres->select_row($sel);
													$i = 0;
													while($row = $run->fetch_array())
													{
														$id = $row['athl_id'];
														$name = $row['athl_name'];
														$surname = $row['athl_surname'];
														$email = $row['athl_email'];
														$b_day = date_create($row['athl_b_day']);
														$image = $row['athl_image'];
														$phone = $row['athl_no'];
														$class = $row['athl_class'];
														$belt = $row['athl_ryu_belt'];
														$nbelt = $row['athl_ryu_nbelt'];
														$ryu_id = $row['athl_ryu_athl_id'];
														$i++;
										
												?>
												<tr align="left">
													<td><?php echo $i;?></td>
													<td><img src="images/foto/<?php echo $image;?>" class="img-thumbnail center-block" style="max-width:70px;max-height:70px;"/></td>
													<td><?php echo $name;?></td>
													<td><?php echo $surname;?></td>
													<td><?php echo date_format($b_day,'d/m/Y');?></td>
													<td><?php echo $email;?></td>
													<td><?php echo $phone;?></td>
													<td><?php echo $class;?></td>
													<td><?php echo $belt;?></td>
													<td>
															<a href="view_athletes.php?id=<?php echo $id;?>&ryu_id=<?php echo $ryu_id?>">
															<button type="button" class="btn btn-danger btn-xs pull-left"><i class="material-icons">delete</i></button>
															</a>
														</td>
														<td>
															<a href="edit_athlete.php?id=<?php echo $id; ?>">
															<button type="button" class="btn btn-warning btn-xs pull-left"><i class="material-icons">create</i></button>
															</a>
														</td>
														<td>
															<a href="detail_athlete.php?id=<?php echo $id; ?>">
															<button type="button" class="btn btn-success btn-xs pull-left"><i class="material-icons">info</i></button>
															</a>
													</td>
												</tr>
												<?php } ?>
											</table>
										</div>
											<footer class="footer">
												<div class="container-fluid">
												<p><a href="<?php echo $_SERVER["HTTP_REFERER"];?>">Indietro</a></p>
												</div>
											</footer>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>		
		</div>
	  <div class="clearfix"></div>
	
			
			<?php
			//DELETE USER
			if(isset($_GET['id']) && isset($_GET['ryu_id']))
			{
				$db_pres->athlete_delete($_GET['id'],$_GET['ryu_id']);
			}		
			?>
			
			<?php
			//INSERISCI PRESENZA
			if(isset($_GET['id']) && isset($_GET['presence']))
			{
				$get_id = $_GET['id'];
				$run_presence = $db_pres->athlete_presence($_GET['id']);
			}
			$db_pres->close();
			
			?>

	</body>
	<?php include 'footer.php';?>
	
</html>