<?php
session_start();
include "database.php";
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
} else
{
?>

<?php
            $email = $_SESSION['user_email'];
			$sel = "SELECT * FROM register_user where user_email='$email'";
			
			$run = mysqli_query($con,$sel);
			$row = mysqli_fetch_array($run);
			
			$id = $row['user_id'];
			$name = $row['user_name'];

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Gestione Iscritti</title>
		<link rel="stylesheet" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/style.css" />
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>

	</head>
	<body>
		<div class="jumbotron">
			
			<div class="container">
				<div class="page-header text-center">
					<p>Ciao, <?php echo $name?>!</p>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="list-group">
							<ol>
								<a href="presence.php"><li class="list-group-item">Inserisci le presenze</li></a>
							</ol>	
						</div>
					</div>
					<div class="clearfix visible-xs-block"></div>
					<div class="col-md-4">
						<div class="list-group">
							<ol>
								<a href="new_athlete.php"><li class="list-group-item">Inserisci un nuovo atleta</li></a>
							</ol>	
						</div>
					</div>
					<div class="clearfix visible-xs-block"></div>
					<div class="col-md-4">
						<div class="list-group">
							<ol>
								<a href="view_athletes.php"><li class="list-group-item">Mostra tutti gli atleti</li></a>
							</ol>	
						</div>
					</div>
					<div class="clearfix visible-xs-block"></div>
				</div>
				<div class="page-header text-center">
					<p><a href="logout.php">Logout</a>	</p>
				</div>
						
			</div>
			
			
		</div>
		
	</body>
</html>
<?php
}    
?>