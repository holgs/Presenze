<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$con = connessione($messaggi_errore);
?>
<html>
	<head>
		<title>PAGINA DI TEST PHP</title>
		<link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
	</head>
	<body>
		<?php
		$sel = "SELECT * FROM athletes";
// TEST CON LA FUNZIONE DB_SELECT_ROW		
		$result = db_select_row($con,$sel);
		//print_r($result);
		echo "<br>-----------------------<br>";
		echo count($result);		
		echo "<br>-----------------------<br>";
		while($row = mysqli_fetch_array($result)){
			$id = $row['athl_name'];
			echo $id."<br>";
		echo "<br>-----------------------<br>";
		echo "<br>-----------------------<br>";
		}
		
// TEST CON LA FUNZIONE DB_SELECT	
		$row = db_select_var($con,$sel);
		echo "<br>-----------------------<br>";
		echo "<br>-----------------------<br>";
		echo is_array($row)."<br>";
		echo count($row);
		echo "<br>-----------------------<br>";
		echo "<br>-----------------------<br>";
		echo $row['athl_id'];
	
//		if (array_key_exists('2', $rows)) {
//    echo "The 'athl_id' element is in the array";
//		} else echo "Elemento non presente";
		
//		echo "<br>-----------------------<br>";
//		print_r(array_keys($rows['3']));
//		echo "<br>-----------------------<br>";
//		print_r(array_values($rows));
//		echo "<br>-----------------------<br>";
	
		
		?>
		
	</body>
</html>