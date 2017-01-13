<?php
session_start();
include "database.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
} else if(isset($_GET['id']))
	{
		$edit_id = $_GET['id'];
		$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id WHERE athl_id='$edit_id'";
		
		$run = mysqli_query($con,$sel);
		$row = mysqli_fetch_array($run);
		
		$id = $row['athl_id'];
		$name = $row['athl_name'];
		$surname = $row['athl_surname'];
		$address = $row['athl_address'];
		$city = $row['athl_city'];
		$zip = $row['athl_zip'];
		$pr = $row['athl_pr'];
		$b_day = date_create($row['athl_b_day']);
		$phone_no = $row['athl_no'];
		$email = $row['athl_email'];
		$image = $row['athl_image'];
		$register_date = $row['athl_register_date'];
		$belt = $row['athl_ryu_belt'];
		$data_belt = date_create($row['athl_ryu_data']);
	}
?>
<!DOCTYPE html>


<html>
	<head>
		<title>Visualizza tutti gli atleti</title>
        <link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/style.css" />
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
	</head>
	
<body>
	<div class="jumbotron">
		<div class="container">
		<h2>Visualizza tutti gli utenti</h2>
		<table class="table table-hover" align="center">
			<tr align="left">
				<th>Num</th>
				<th>Foto</th>
				<th>Nome</th>
				<th>Cognome</th>
				<th>Data di nascita</th>
				<th>E-mail</th>
				<th>Telefono</th>
				<th>Cintura</th>
				<th></th>
				
			</tr>
			<?php
				//$sel = "SELECT * FROM athletes";
				$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id";
				$run = mysqli_query($con,$sel);
				
				$i = 0;
				
				while($row = mysqli_fetch_array($run))
				{
					$id = $row['athl_id'];
					$name = $row['athl_name'];
					$surname = $row['athl_surname'];
					$email = $row['athl_email'];
					$b_day = date_create($row['athl_b_day']);
					$image = $row['athl_image'];
					$phone = $row['athl_no'];
					$belt = $row['athl_ryu_belt'];
					$ryu_id = $row['athl_ryu_athl_id'];
					
					$i++;
				
	
			?>
			<tr align="left">
				<td><?php echo $i;?></td>
				<td><img src="images/<?php echo $image;?>" class="img-thumbnail center-block" style="max-width:140px;max-height:70px;"/></td>
				<td><?php echo $name;?></td>
				<td><?php echo $surname;?></td>
				<td><?php echo date_format($b_day,'d/m/Y');?></td>
				<td><?php echo $email;?></td>
				<td><?php echo $phone;?></td>
				<td><?php echo $belt;?></td>
				<td>
					<div class="btn-group btn-group-xs" role="group">
						<a href="view_athletes.php?id=<?php echo $id;?>&ryu_id=<?php echo $ryu_id?>">
						<button type="button" class="btn btn-default">Cancella</button>
						</a>
						<a href="edit_athlete.php?id=<?php echo $id; ?>">
						<button type="button" class="btn btn-default">Modifca</button>
						</a>
						<!--<a href="view_athletes.php?id=<?php echo $id; ?>&presence=1">
						<button type="button" class="btn btn-default">Presenza</button>
						</a> -->
						<a href="detail_athlete.php?id=<?php echo $id; ?>">
						<button type="button" class="btn btn-default">Dettagli</button>
						</a>
					</div>
				</td>
			</tr>
			<?php } ?>
		</table>
		<div class="page-header text-center">
			<p><a href="index_home.php">Indietro</a></p>
		</div>
		<div class="page-header text-right">Benvenuto: <?php echo $_SESSION['user_email'];?> - <a href="index_home.php">Home</a> - <a href="logout.php">Logout</a></div>
		</div>		
	</div>
    <div class="clearfix"></div>

		
		<?php
		//DELETE USER
		if(isset($_GET['id']) && isset($_GET['ryu_id']))
		{
			$get_id = $_GET['id'];
			$get_ryu_id = $_GET['ryu_id'];
			
			$delete = "DELETE FROM athletes WHERE athl_id='$get_id'";
			$run_delete = mysqli_query($con,$delete);
			
			$delete_belt ="DELETE FROM athletes_ryu WHERE athl_ryu_athl_id='$get_ryu_id'";
			$run_ryu_delete = mysqli_query($con,$delete_belt);
			
			if($run_delete && $run_ryu_delete)
			{
				echo "<script>alert('Atleta cancellato con successo')</script>";
				echo "<script>window.open('view_athletes.php','_self')</script>";
				
			}
		}
		?>
		<?php
		//INSERISCI PRESENZA
		if(isset($_GET['id']) && isset($_GET['presence']))
		{
			$get_id = $_GET['id'];
			//$athl_pres_presence = $_GET['ryu_id'];
			
			$presence = "INSERT INTO athl_presence (athl_pres_athl_id,athl_pres_date,athl_pres_presence) VALUES ('$get_id',NOW(),'1')";
			$run_presence = mysqli_query($con,$presence);
						
			if($run_presence)
			{
				echo "<script>alert('Presenza inserita con successo')</script>";
				echo "<script>window.open('view_athletes.php','_self')</script>";
				
			}
		}
		?>

</body>
</html>