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
		<title>Iscrivi atleti alla gara <?php echo $gara_nome;?></title>
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
	                  	<h4 class="title">Iscrivi gli atleti alla gara <?php echo $gara_nome;?></h4>
	                  	<p class="category">Iscrizione degli atleti</p>
	                  </div>
	                  <div class="card-content table-responsive">
											<table class="table table-hover" align="center">
												<thead class="text-danger" align="left">
													<th>Num</th>
													<th>Foto</th>
													<th>
														<a href="add_iscritti.php?ordina=athl_name&come=
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
														<a href="add_iscritti.php?ordina=athl_surname&come=
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
													<th>Compleanno</th>
													<th>E-mail</th>
													<th>Telefono</th>
													<th>
														<a href="add_iscritti.php?ordina=athl_class&come=
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
														<a href="add_iscritti.php?ordina=athl_ryu_nbelt&come=
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
													<th>Azioni</th>

												</thead>
												<?php
												// BLOCCO GESTIONE ORDINAMENTO -- INIZIO
												$ordina = $_GET['ordina'];
												$come = $_GET['come'];
												if($ordina == "" && $come =="")
												{
													$sel = "SELECT * 
																	FROM athletes 
																	LEFT JOIN athletes_ryu 
																		ON athl_id = athl_ryu_athl_id
																	LEFT JOIN partecipanti 
																		ON athl_id = part_athl_id 
																	LEFT JOIN gara 
																		ON gara_id = part_gara_id
																	WHERE part_gara_id = $gara_id
																	ORDER BY athl_name ASC";									
												}
												else 
												{
													switch ($come) 
													{
														case 'DESC':
															$sel = "SELECT * FROM athletes 
																			LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id 
																			LEFT JOIN partecipanti ON athl_id = part_athl_id 
																			LEFT JOIN gara ON gara_id = part_gara_id 
																			WHERE part_gara_id = $gara_id
																			ORDER BY $ordina DESC";
															$come == "ASC";
															break;
														case 'ASC':
															$sel = "SELECT * FROM athletes 
																			LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id 
																			LEFT JOIN partecipanti ON athl_id = part_athl_id 
																			LEFT JOIN gara ON gara_id = part_gara_id 
																			WHERE part_gara_id = $gara_id
																			ORDER BY $ordina ASC";
															$come == "DESC";
															break;
														default:
															$sel = "SELECT * FROM athletes 
																			LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id 
																			LEFT JOIN partecipanti ON athl_id = part_athl_id 
																			LEFT JOIN gara ON gara_id = part_gara_id
																			WHERE part_gara_id = $gara_id
																			ORDER BY $ordina ASC";
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
														$gara_nome = $row['gara_nome'];
														$iscritto = $row['part_status'];
														$atleta_iscritto = $row['part_athl_id'];
														$iscritto_gara = $row['part_gara_id'];
														//echo "<script>alert('ciclo WHILE Atleta ".$atleta_iscritto." iscritto a gara ".$iscritto_gara." stato atleta ".$iscritto."');</script>";
																												
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
													<?php																										
													if($iscritto == 'ISCRITTO' && $iscritto_gara == $gara_id)
//																		<script>alert('IF ISCRITTO e GARA gia iscritto : ".$iscritto_gara."');</script>
													{
														echo "
														
															<a href='add_iscritti_process.php?gara_id=$gara_id&part_id=$id&rimuovi=ok'>
															<button type='button' class='btn btn-danger btn-xs pull-left'><i class='material-icons'>delete</i></button>
															</a>														
														";
													} 
													else 
													{
//																		<script>alert('Atleta da iscrivere: ".$gara_id." ".$id."');</script>
														echo "
														
															<a href='add_iscritti_process.php?gara_id=$gara_id&part_id=$id&aggiungi=ok'>
															<button type='button' class='btn btn-success btn-xs pull-left'><i class='material-icons'>trending_flat</i></button>
															</a>														
														";
														//echo "<script>alert('NON ISCRITTO ".$id."')</script>";
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