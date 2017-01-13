<?php
session_start();
include "database.php";
//include "header01.php";
?>
<!DOCTYPE html>


<html>
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Modulo di Registrazione</title>
		<meta name="description" content="">
		<meta name="author" content="Holgs">
		<!-- <meta name="viewport" content="width=device-width; initial-scale=1.0"> -->
		<link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/style.css" />
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>

		<style>
		    table{
				margin: 30px;
		        color:white;
		        padding: 15px;
		        width: 400px;
		    }
		    input, textarea{
		        padding: 10px;
		    }
		    body{
		        padding:0;
		        margin:0;
		        background: skyblue;
		    }

		</style>
	</head>
	<body>
		<form action="registration.php" method="post" enctype="multipart/form-data">
			<table bgcolor="gray" width="600">
			    <tr align="center">
			        <td colspan="6"><h2>Modulo di registrazione nuovo utente</h2></td>
			    </tr>
				<tr>
					<td align="right"><label>Nome</label></td>
					<td><input type="text" name="user_name" placeholder="Inserisci il tuo nome" required="required"/></td>
				</tr>
				<tr>
					<td align="right"><label>Email</label></td>
					<td>
						<input type="text" name="user_email" placeholder="Inserisci la tua email" required="required"/>
					</td>						
				</tr>
				<tr>
					<td align="right"><label>Password</label></td>
					<td><input type="password" name="user_pass" placeholder="Inserisci la password" required="required"/></td>
				</tr>
				<tr>
					<td align="right"><label>Stato</label></td>
					<td>
						<select name="user_country" required="required">
							<option>Italia</option>
							<option>Germania</option>
						</select>
					</td>	
				</tr>
				<tr>
					<td align="right"><label>Numero di Telefono:</label></td>
					<td><input type="text" name="user_no" placeholder="Inserisci il tuo Numero di telefono" required="required"/></td>
				</tr>
				<tr>
					<td align="right"><label>Indirizzo:</label></td>
					<td><input type="text" name="user_address" placeholder="Inserisci il tuo Indirizzo" required="required"></td>
				</tr>
				<tr>
					<td align="right"><label>Città:</label></td>
					<td><input type="text" name="user_city" placeholder="Inserisci la Città" required="required"></td>
				</tr>
				<tr>
					<td align="right"><label>CAP:</label></td>
					<td><input type="text" name="user_zip" placeholder="Inserisci il CAP" required="required"></td>
				</tr>
				<tr>
					<td align="right"><label>Provincia:</label></td>
					<td><input type="text" name="user_pr" placeholder="Inserisci la Procincia" required="required"></td>
				</tr>
				<tr>
					<td align="right"><label>Genere</label></td>
					<td>
						Maschio<input type="radio" name="user_gender" value="Maschio"/>
						Femmina<input type="radio" name="user_gender" value="Femmina"/>
					</td>
				</tr>
				<tr>
                    <td align="right"><label>Data di nascita:</label></td>
                    <td><input type="date" name="user_b_day" required="required"/></td>
                </tr>

				<tr>
					<td align="right"><label>Immagine:</label></td>
					<td><input type="file" name="user_image" required="required"/></td>
				</tr>
				<tr>
					<td align="center" colspan="6"><input type="submit" name="register" value="Registrati adesso!"/></td>
				</tr>
			</table>
		</form>
		
		    <h3>
		        Già registrato? <a href="login.php">Login.</a>
		    </h3>
		
		<?php
		if(isset($_POST['register']))
		{
		
			$user_name = mysqli_real_escape_string($con,$_POST['user_name']);
			$user_pass = mysqli_real_escape_string($con,$_POST['user_pass']);
			$user_email = mysqli_real_escape_string($con,$_POST['user_email']);
			$user_country = mysqli_real_escape_string($con,$_POST['user_country']);
			$user_gender = mysqli_real_escape_string($con,$_POST['user_gender']);
			$user_no = mysqli_real_escape_string($con,$_POST['user_no']);
			$user_address = mysqli_real_escape_string($con,$_POST['user_address']);
			$user_zip = mysqli_real_escape_string($con,$_POST['user_zip']);
			$user_city = mysqli_real_escape_string($con,$_POST['user_city']);
			$user_pr = mysqli_real_escape_string($con,$_POST['user_pr']);
			$user_b_day = mysqli_real_escape_string($con,$_POST['user_b_day']);

			$user_image = $_FILES['user_image']['name'];
			$user_tmp = $_FILES['user_image']['tmp_name'];

			if($user_address =='' OR $user_country == '' OR $user_image =='' OR $user_gender='')
			{
				echo "<script>alert('Compila tutti i campi!')</script>";
				exit();
			}
		
			if(!filter_var($user_email,FILTER_VALIDATE_EMAIL))
			{
				echo "<script>alert('La tua email non è valida!')</script>";
				exit();
			}
		
			if(strlen($user_pass) < 8 )
			{
				echo "<script>alert('Seleziona una password di almeno 8 caratteri!')</script>";
				exit();
			}
			
			$sel_email = "select * from register_user where user_email='$user_email'";
			$run_email = mysqli_query($con,$sel_email);
			
			$check_email = mysqli_num_rows($run_email);
					
			if($check_email == 1)
			{
				echo "<script>alert('La tua email è già registrata! Provane un'altra')</script>";
				exit();	
			} else
			{
				
				$_SESSION['user_email'] = $user_email;
				
				move_uploaded_file($user_tmp,"images/$user_image");
				
				$insert = "insert into register_user 
				(user_name,user_pass,user_email,user_country,user_no,user_address,user_zip,user_city,user_pr,user_gender,user_b_day,user_image, register_date) 
				values ('$user_name','$user_pass','$user_email','$user_country','$user_no','$user_address','$user_zip','$user_city','$user_pr','$user_gender','$user_b_day','$user_image',NOW())";
				
				$run_insert = mysqli_query($con,$insert);
				
					if($run_insert)
					{
						echo "<script>alert('Registrazione completata con successo, Benvenuto!')</script>";
						echo "<script>window.open('index_home.php','_self')</script>";

					}
			}
			
		}
		?>
	</body>
</html>
