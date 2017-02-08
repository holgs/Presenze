<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$db_pres = new db($cartella_ini,$messaggi_errore,true);
$gara_id = $_GET['gara_id'];

$sel = "SELECT * FROM gara WHERE gara_id='$gara_id'";
	//DATE_FORMAT(athl_b_day, '%d/%m/%Y')as athl_b_day 
$run = $db_pres->select_row($sel);
$row = $run->fetch_array();
			
$gara_nome = $row['gara_nome'];

?>
<!DOCTYPE html>


<html lang="en">
	<head>
		<title>Inserisci esito della gara <?php echo $gara_nome;?></title>
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
	                  	<h4 class="title">Inserisci l'esito della gara <?php echo $gara_nome;?></h4>
	                  	<p class="category">Risultati della gara per ciascun atleta</p>
	                  </div>
	                  <div class="card-content table-responsive">
											<table class="table table-hover" align="center">
												<thead class="text-danger" align="left">
													<th>Num</th>
													<th>Foto</th>
													<th>
														<a href="esito_gara.php?ordina=athl_name&come=
															<?php 
																if($_GET['come']=="ASC")
																{
																	$come="DESC";
																}
																else 
																{
																	$come="ASC";	
																}
																echo $come."&gara_id=".$gara_id;
															?>
															" class="text-danger">
															Nome
														</a>
													</th>
													<th>
														<a href="esito_gara.php?ordina=athl_surname&come=
															<?php 
																if($_GET['come']=="ASC")
																{
																	$come="DESC";
																}
																else 
																{
																	$come="ASC";	
																}
																echo $come."&gara_id=".$gara_id;
															?>
															" class="text-danger">
															Cognome
														</a>
													</th>
													<th>
														<a href="esito_gara.php?ordina=athl_class&come=
															<?php 
																if($_GET['come']=="ASC")
																{
																	$come="DESC";
																}
																else 
																{
																	$come="ASC";	
																}
																echo $come."&gara_id=".$gara_id;
															?>
															" class="text-danger">
															Classe
														</a>
													</th>
													<th>
														<a href="esito_gara.php?ordina=athl_ryu_nbelt&come=
															<?php 
																if($_GET['come']=="ASC")
																{
																	$come="DESC";
																}
																else 
																{
																	$come="ASC";	
																}
																echo $come."&gara_id=".$gara_id;
															?>
															" class="text-danger">
															Cintura
														</a>
													</th>
													<th>Esito</th>
													<th></th>
													<th></th>
													<th></th>

												</thead>
												<?php
												// BLOCCO GESTIONE ORDINAMENTO -- INIZIO
												$ordina = $_GET['ordina'];
												$come = $_GET['come'];
												if($ordina == "" && $come =="")
												{
													$sel = "SELECT risult_athl_id, risult_esito,
																	athletes.athl_name, athletes.athl_surname, athletes.athl_class, athletes.athl_image,
																	athletes_ryu.athl_ryu_belt,athletes_ryu.athl_ryu_nbelt
																	FROM risultati
																	JOIN athletes ON risult_athl_id = athl_id
																	JOIN athletes_ryu ON risult_athl_id = athl_ryu_athl_id
																	WHERE risult_gara_id = $gara_id
																	ORDER BY athl_name ASC";									
												}
												else 
												{
													switch ($come) 
													{
														case 'DESC':
															$sel = "SELECT risult_athl_id, risult_esito,
																			athletes.athl_name, athletes.athl_surname, athletes.athl_class, athletes.athl_image,
																			athletes_ryu.athl_ryu_belt,athletes_ryu.athl_ryu_nbelt
																			FROM risultati
																			JOIN athletes ON risult_athl_id = athl_id
																			JOIN athletes_ryu ON risult_athl_id = athl_ryu_athl_id
																			WHERE risult_gara_id = $gara_id
																			ORDER BY $ordina DESC";
															$come == "ASC";
															break;
														case 'ASC':
															$sel = "SELECT risult_athl_id, risult_esito,
																			athletes.athl_name, athletes.athl_surname, athletes.athl_class, athletes.athl_image,
																			athletes_ryu.athl_ryu_belt,athletes_ryu.athl_ryu_nbelt
																			FROM risultati
																			JOIN athletes ON risult_athl_id = athl_id
																			JOIN athletes_ryu ON risult_athl_id = athl_ryu_athl_id
																			WHERE risult_gara_id = $gara_id
																			ORDER BY $ordina ASC";
															$come == "DESC";
															break;
														default:
															$sel = "SELECT risult_athl_id, risult_esito,
																			athletes.athl_name, athletes.athl_surname, athletes.athl_class, athletes.athl_image,
																			athletes_ryu.athl_ryu_belt,athletes_ryu.athl_ryu_nbelt
																			FROM risultati
																			JOIN athletes ON risult_athl_id = athl_id
																			JOIN athletes_ryu ON risult_athl_id = athl_ryu_athl_id
																			WHERE risult_gara_id = $gara_id
																			ORDER BY $ordina ASC";
															break;
													}
												}
												// BLOCCO GESTIONE ORDINAMENTO -- FINE
																				
													$run = $db_pres->select_row($sel);
													$i = 0;
													while($row = $run->fetch_array())
													{
														$id = $row['risult_athl_id'];
														$esito = $row['risult_esito'];
														$name = $row['athl_name'];
														$surname = $row['athl_surname'];
														$class = $row['athl_class'];
														$image = $row['athl_image'];
														$belt = $row['athl_ryu_belt'];
														$nbelt = $row['athl_ryu_nbelt'];
														//$atleta_iscritto = $row['part_athl_id'];
														//$iscritto_gara = $row['part_gara_id'];
														//echo "<script>alert('ciclo WHILE Atleta ".$atleta_iscritto." iscritto a gara ".$iscritto_gara." stato atleta ".$iscritto."');</script>";
																												
														$i++;
										
												?>
												<tr align="left">
													<td><?php echo $i;?></td>
													<td><img src="images/foto/<?php echo $image;?>" class="img-thumbnail center-block" style="max-width:70px;max-height:70px;"/></td>
													<td><?php echo $name;?></td>
													<td><?php echo $surname;?></td>
													<td><?php echo $class;?></td>
													<td><?php echo $belt;?></td>
													<td>
													<?php						
													//&& $iscritto_gara == $gara_id && $atleta_iscritto == $id																				
													if($esito == '' )
													{
														echo "
																<a href='esito_gara_process.php?gara_id=$gara_id&part_id=$id&esito=1-oro'>
																	<button type='button' class='btn btn-warning btn-xs pull-left'><i class='material-icons'>grade</i></button>
																</a>	
															</td>
															<td>
																<a href='esito_gara_process.php?gara_id=$gara_id&part_id=$id&esito=2-argento'>
																	<button type='button' class='btn btn-default btn-xs pull-left'><i class='material-icons'>grade</i></button>
																</a>															
															</td>
															<td>
																<a href='esito_gara_process.php?gara_id=$gara_id&part_id=$id&esito=3-bronzo'>
																	<button type='button' class='btn btn-danger btn-xs pull-left'><i class='material-icons'>grade</i></button>
																</a>
															</td>	
															<td>
																<a href='esito_gara_process.php?gara_id=$gara_id&part_id=$id&esito=nc'>
																	<button type='button' class='btn btn-danger btn-xs pull-left'><i class='material-icons'>block</i></button>
																</a>								
														";
													}
													else if($esito =='1-oro')
													{
														echo "
															<button type='button' class='btn btn-warning btn-xs pull-left'><i class='material-icons'>grade</i></button>
														";
													}
													else if($esito =='2-argento')
													{
														echo "
															<button type='button' class='btn btn-default btn-xs pull-left'><i class='material-icons'>grade</i></button>
														";
													}
													else if($esito =='3-bronzo')
													{
														echo "
															<button type='button' class='btn btn-danger btn-xs pull-left'><i class='material-icons'>grade</i></button>
														";
													}
													?>						

													</td>
												</tr>
												<?php } ?>
											</table>
										</div>
											<footer class="footer">
												<div class="container-fluid">
												<p><a href="<?php echo "detail_gara.php?id=".$gara_id;?>">Indietro</a></p>
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
	
			<!--
			<?php
			//ADD ATLETA A GARA
			if(isset($_GET['part_id']) && isset($_GET['gara_id']) && isset($_GET['aggiungi']))
			{
				$part_id = $_GET['part_id'];
				echo $part_id."<br>".$gara_id;
				$add = "INSERT INTO partecipanti (part_gara_id,part_athl_id,part_status) VALUES ('".$gara_id."','".$part_id."','ISCRITTO')";
				//$add = "INSERT INTO partecipanti (part_status) VALUES ('Iscritto')";
				$db_pres->insert($add);
				echo "<script>window.open('add_iscritti.php?".$gara_id."','_self'</script>";
			}		
			?> -->


	</body>
	<?php include 'footer.php';?>
	
</html>