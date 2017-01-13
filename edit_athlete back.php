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
		$b_day = $row['athl_b_day'];
		$phone_no = $row['athl_no'];
		$email = $row['athl_email'];
		$image = $row['athl_image'];
		$register_date = $row['athl_register_date'];
		$belt = $row['athl_ryu_belt'];
		$data_belt = $row['athl_ryu_data'];	
	}
?>
<!DOCTYPE html>

<html>
	<head>

		<title>Modifica Atleta</title>
		<link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/style.css" />
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
	</head>

	<body>
	<body>
		<form action="edit_athlete.php?id=<?php echo $edit_id;?>" method="post" enctype="multipart/form-data">
			<table bgcolor="gray" width="600">
			    <tr align="center">
			        <td colspan="6"><h2>Modifica dati Atleta</h2></td>
			    </tr>
				<tr>
					<td align="right"><strong>Name</strong></td>
					<td><input type="text" name="athl_name" value="<?php echo $name ;?>" required="required"/></td>
				</tr>
				<tr>
					<td align="right"><strong>Cognome</strong></td>
					<td><input type="text" name="athl_surname" value="<?php echo $surname ;?>" required="required"/></td>
				</tr>
				<tr>
					<td align="right"><strong>Data di nascita</strong></td>
					<td><input type="text" name="athl_b_day" value="<?php echo $b_day ;?>" required="required"/></td>
				</tr>
				<tr>
					<td align="right"><strong>Email</strong></td>
					<td>
					<input type="text" name="athl_email" value="<?php echo $email ;?>" required="required"/>
					</td>						
				</tr>
				<tr>
					<td align="right"><strong>Numero di telefono:</strong></td>
					<td><input type="text" name="athl_no" value="<?php echo $phone_no; ?>" required="required"/></td>
				</tr>
				<tr>
					<td align="right"><strong>Indirizzo:</strong></td>
					<td><input type="text" name="athl_address" value="<?php echo $address; ?>" required="required"/></td>
				</tr>
				<tr>
					<td align="right"><strong>Città:</strong></td>
					<td><input type="text" name="athl_city" value="<?php echo $city; ?>" required="required"/></td>
				</tr>
				<tr>
					<td align="right"><strong>Cap:</strong></td>
					<td><input type="text" name="athl_zip" value="<?php echo $zip; ?>" required="required"/></td>
				</tr>
				<tr>
					<td align="right"><strong>Provincia:</strong></td>
					<td><input type="text" name="athl_pr" value="<?php echo $pr; ?>" required="required"/></td>
				</tr>
				<tr>
					<td align="right"><strong>Cintura:</strong></td>
					<td>
						<select name="athl_ryu_belt">
							<option><?php echo $belt;?></option>
							<option>Bianca</option>
							<option>Gialla</option>
							<option>Arancione</option>
							<option>Verde</option>
							<option>Blu</option>
							<option>Marrone</option>
							<option>Nera - 1° DAN</option>
							<option>Nera - 2° DAN</option>
							<option>Nera - 3° DAN</option>
							<option>Nera - 4° DAN</option>
							<option>Nera - 5° DAN</option>
						</select>
					</td>	
				</tr>
				<tr>
					<td align="right"><strong>Data di Ottenimento Cintura</strong></td>
					<td><input type="text" name="athl_ryu_data" value="<?php echo $data_belt ;?>" required="required"/></td>
				</tr>

				<tr>
					<td align="right"><strong>Immagine:</strong></td>
					<td>
						<input type="file" name="athl_image" />
						<img src="images/<?php echo $image;?>" width="50" height="50">
					</td>
				</tr>
				<tr>
					<td align="center" colspan="6"><input type="submit" name="update" value="Update Now!"/></td>
				</tr>
			</table>
		</form>
	<h3>Benvenuto: <?php echo $_SESSION['user_email'];?> - <a href="logout.php">Logout</a>
	</h3>
	<br>
	<a href="index_home.php"> <<<< </a>
		<?php

		if(isset($_POST['update']))
		{
		
			$athl_name = mysqli_real_escape_string($con,$_POST['athl_name']);
			$athl_surname = mysqli_real_escape_string($con,$_POST['athl_surname']);
			$athl_b_day = mysqli_real_escape_string($con,$_POST['athl_b_day']);
			$athl_email = mysqli_real_escape_string($con,$_POST['athl_email']);
			$athl_no = mysqli_real_escape_string($con,$_POST['athl_no']);
			$athl_address = mysqli_real_escape_string($con,$_POST['athl_address']);
			$athl_city = mysqli_real_escape_string($con,$_POST['athl_city']);
			$athl_zip = mysqli_real_escape_string($con,$_POST['athl_zip']);
			$athl_pr = mysqli_real_escape_string($con,$_POST['athl_pr']);
			$athl_ryu_belt = mysqli_real_escape_string($con,$_POST['athl_ryu_belt']);
			$athl_ryu_data = mysqli_real_escape_string($con,$_POST['athl_ryu_data']);

			$athl_image = $_FILES['athl_image']['name'];
			$athl_tmp = $_FILES['athl_image']['tmp_name'];

			//if($user_address =='' OR $user_image =='')
			//{
			//	echo "<script>alert('Please fill all the fields!')</script>";
			//	exit();
			//}
		
			if(!filter_var($athl_email,FILTER_VALIDATE_EMAIL))
			{
				echo "<script>alert('L'indirizzo email non è valido!')</script>";
				exit();
			}
			//$_SESSION['user_email'] = $user_email;
			
			move_uploaded_file($athl_tmp,"images/$athl_image");
			
			$update = "UPDATE athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id
							SET athl_name='$athl_name',
							athl_surname='$athl_surname',
							athl_b_day='$athl_b_day',
							athl_email='$athl_email',
							athl_no='$athl_no',
							athl_address='$athl_address',
							athl_city='$athl_city',
							athl_zip='$athl_zip',
							athl_pr='$athl_pr',
							athl_ryu_belt='$athl_ryu_belt',
							athl_ryu_data='$athl_ryu_data',
							athl_image='$athl_image'
							WHERE athl_id='$edit_id'";
			
			$run_update = mysqli_query($con,$update);
			
				if($run_update)
				{
					echo "<script>alert('Aggiornamento completato con successo')</script>";
					echo "<script>window.open('view_athletes.php','_self')</script>";

				} else {
					echo "<script>alert('Aggiornamento non effettuato')</script>";
				}
			
		}
		?>
	</body>
</html>
