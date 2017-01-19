<?php
session_start();
include "database.php";
//	$con = mysqli_connect("localhost","adiuva01","adiuva01","ad-iuva") or die("");
?>
<!DOCTYPE html>


<html lang="en">
	<head>
		<title>View Users - Admin Panel</title>
	<style>
		    table{
		        color:white;
		        padding: 2px;
		        width: 1000px;
		        background: orange;
		    }
		    input, textarea{
		        padding: 5px;
		    }
		    body{
		        padding:0;
		        margin:0;
		        background: skyblue;
		    }
		    th{
		    	border: 2px solid black;
		    }
			h3{
				float:right;
				margin-right:120px;
			}
		</style>
		
	</head>
	
<body>
	<table align="center">
		<tr align="center">
			<td colspan="7"><h2>Visualizza tutti gli utenti</h2></td>
		</tr>
		<tr align="center">
			<th>S.N</th>
			<th>Nome</th>
			<th>E-mail</th>
			<th>Foto</th>
			<th>Data di creazione</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
		<?php
			$sel = "select * from register_user";
			$run = mysqli_query($con,$sel);
			
			$i = 0;
			
			while($row = mysqli_fetch_array($run))
			{
				$id = $row['user_id'];
				$name = $row['user_name'];
				$email = $row['user_email'];
				$image = $row['user_image'];
				$register_date = $row['register_date'];
				
				$i++;
			

		?>
		<tr align="center">
			<td>
				<?php echo $i;?>
			</td>
			<td>
				<?php echo $name;?>
			</td>
			<td>
				<?php echo $email;?>
			</td>
			<td>
				<img src="images/<?php echo $image;?>" width="50" height="50" />
			</td>
			<td>
				<?php echo $register_date;?>
			</td>
			<td>
				<a href="view_users.php?id=<?php echo $id; ?>">Delete</a>
			</td>
			<td>
				<a href="edit_users.php?id=<?php echo $id; ?>">Edit</a>
			</td>
		</tr>
		<?php } ?>
	</table>
	<h3>Benvenuto: <?php echo $_SESSION['admin_email'];?> <a href="admin_logout.php">Logout</a></h3>
		
		<?php
		//DELETE USER
		if(isset($_GET['id']))
		{
			$get_id = $_GET['id'];
			
			$delete = "delete from register_user where user_id='$get_id'";
			$run_delete = mysqli_query($con,$delete);
			
			if($run_delete)
			{
				echo "<script>alert('Utente cancellato con successo')</script>";
				echo "<script>window.open('view_users.php','_self')</script>";
				
			}
		}
		?>
</body>
</html>