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
		$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id WHERE athl_id='$edit_id'";
		//DATE_FORMAT(athl_b_day, '%d/%m/%Y')as athl_b_day 
		$run = $db_pres->select_row($sel);
		$row = $run->fetch_array();
				
		$id = $row['athl_id'];
		$name = $row['athl_name'];
		$surname = $row['athl_surname'];
		$gender = $row['athl_gender'];		
		$address = $row['athl_address'];
		$city = $row['athl_city'];
		$zip = $row['athl_zip'];
		$pr = $row['athl_pr'];
		$b_day = date_create($row['athl_b_day']);
		$phone_no = $row['athl_no'];
		$email = $row['athl_email'];
		$image = $row['athl_image'];
		$class = $row['athl_class'];
		$register_date = $row['athl_register_date'];
		$belt = $row['athl_ryu_belt'];
		$data_belt = date_create($row['athl_ryu_data']);	
	}
?>
<!DOCTYPE html>

<html>
	<head>
		<title>Modifica Atleta</title>
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
	             <div class="col-md-8">
	             	<div class="card">
					        <div class="card-header" data-background-color="red">
		              	<h4 class="title">Dettagli Atleta:  <?php echo $name.' '.$surname ;?></h4>
		              </div>
									<div class="card-content">
									<form action="edit_athlete.php?id=<?php echo $edit_id;?>" method="post" enctype="multipart/form-data">
										
										<div class="row">
											
											<div class="col-md-5">
												<div class="form-group">
													<label class="control-label">Name</label>
													<input type="text" class="form-control" name="athl_name" value="<?php echo $name ;?>" disabled/>
												</div>
											</div>
											
											<div class="col-md-3">
												<div class="form-group">
													<label class="control-label">Cognome</label>
													<input type="text" class="form-control" name="athl_surname" value="<?php echo $surname ;?>" disabled/>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Sesso</label>
													<input type="text" class="form-control" name="athl_gender" value="<?php echo $gender ;?>" disabled/>

												</div>
											</div>
											
										</div>
										
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label class="control-label">Data di nascita</label>
													<input type="text" class="form-control" name="athl_b_day" value="<?php echo date_format($b_day,'d/m/Y') ;?>" disabled/>
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label class="control-label">Email></label>
													<input type="text" class="form-control" name="athl_email" value="<?php echo $email ;?>" disabled/>						
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Numero di telefono:</label>
													<input type="text" class="form-control" name="athl_no" value="<?php echo $phone_no; ?>" disabled/>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">Indirizzo:</label>
													<input type="text" class="form-control" name="athl_address" value="<?php echo $address; ?>" disabled/>
												</div>
											</div>
											
											<div class="col-md-3">											
												<div class="form-group">
													<label class="control-label">Città:</label>
													<input type="text" class="form-control" name="athl_city" value="<?php echo $city; ?>" disabled/>
												</div>
											</div>
											
											<div class="col-md-2">
												<div class="form-group">
													<label class="control-label">Cap:</label>
													<input type="text" class="form-control" name="athl_zip" value="<?php echo $zip; ?>" disabled/>
												</div>
											</div>
											
											<div class="col-md-1">
												<div class="form-group">
													<label class="control-label">Provincia:</label>
													<input type="text" class="form-control" name="athl_pr" value="<?php echo $pr; ?>" disabled/>
												</div>
											</div>
											
										</div>
										
										
										<div class="row">
											<div class="col-md-4">						
												<div class="form-group">
													<label class="control-label">Cintura:</label>
													<input type="text" class="form-control" name="athl_belt" value="<?php echo $belt; ?>" disabled/>
												</div>
											</div>
												
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">Data di Ottenimento Cintura</label>
												<input type="text" class="form-control" name="athl_ryu_data" value="<?php echo date_format($data_belt,'d/m/Y') ;?>" disabled/>	
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group"><label class="control-label">Classe</label>
													<input type="text" class="form-control" name="athl_class" value="<?php echo $class ?>" disabled/>
												</div>
											</div>
										</div>
										
									<!--		<div class="col-md-6 col-sm-6">
												<div class="form-group">
													<label class="control-label">Cambia immagine</label>
												<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Cambia immagine</button>
												</div>
											</div>
										</div>
							
										<div class="row">
										<div class="form-group col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-sx-8 ">
											<input type="submit" class=" btn btn-danger btn-block" name="update" value="Aggiorna!"/>
										</div>
									</div>
								
										<button type="submit" class="btn btn-danger pull-right" name="update" >Aggiorna Profilo</button>
	                  <button type="submit" class="btn btn-danger pull-left" data-toggle="modal" data-target="#myModal">Aggiorna Immagine</button>
	                  <div class="clearfix"></div>
	                  	-->
									</form>
									</div>
								</div>
								<!-- SEZIONE LATERALE -->
							</div>
								<div class="col-md-4">
									<div class="row">
		    						<div class="card card-profile">
		    							<div class="card-avatar">
		    								<a href="#pablo">
		    									<img class="img" src="images/foto/<?php echo $image;?>" />
		    								</a>
		    							</div>
		
		    							<div class="content">
		    								<h6 class="category text-gray"><?php echo $belt;?></h6>
		    								<h4 class="card-title"><?php echo $name.' '.$surname ;?></h4>
		    								<p class="card-content">
													KATA preferiti</p>
		    							</div>
	    							</div>
	    						</div>
	    						
	    						<div class="row">
	    							<div class="card">
	    								<div class="card-header" data-background-color="red">
												<h4 class="title">Presenze</h4>
												<p class="category">Presenze durante il mese di <?php setlocale(LC_ALL,"it_IT,UTF-8","it_IT");echo strftime("%B %G");?></p>
											</div>
		    							<div class="content table-responsive">
		    								<p class="card-content">
													<?php	$tpa=array(0,0,0);$tpa = $db_pres->valuta_presenza($edit_id);?></p>
		    							</div>
		    							<div class="card-footer">
												<div class="stats">
													<i class="material-icons text-danger">warning</i> <a href="#pablo"><?php echo $tpa[2]." assenze, pari al ".((round(($tpa[2]/$tpa[0]),1))*100)."% del totale.";?></a>
												</div>
		    						</div>
		    					</div>
			    			</div>

						</div>
				</div>
			</div>
				<footer class="footer">
					<div class="container-fluid">
					<p><a href="<?php echo $_SERVER["HTTP_REFERER"];?>">Indietro</a></p>
					</div>
				</footer>
			</div>		
		</div>

	</body>
	<?php include 'footer.php';?>
</html>
