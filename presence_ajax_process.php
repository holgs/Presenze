<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$name = $_SESSION['username'];
$db_pres = new db($cartella_ini,$messaggi_errore,true);

if(isset($_GET['id']) && isset($_GET['presence']))
{
	$db_pres->athlete_presence($_GET['id'],$_GET['presence']);
	//echo "<script>window.open('presence.php?class=".$_GET['class']."','_self')</script>";
} 
?>

<?php
	$class = $_REQUEST['class'];	
	//$class = $_GET['class'];
	$sel = "SELECT * FROM athletes LEFT JOIN athletes_ryu ON athl_id = athl_ryu_athl_id LEFT JOIN athl_presence ON athl_id = athl_pres_athl_id AND athl_pres_date = CURDATE()  WHERE athl_class ='$class' GROUP BY athl_id";
	$run = $db_pres->select_row($sel);
	
	while($row = mysqli_fetch_assoc($run)){
		$id = $row['athl_id'];
		$athlete = $row['athl_name']." ".$row['athl_surname'];
		$pres_recorded = $row['athl_pres_presence']; 		
		echo "
				<div class=''>
					<div class='col-md-6 col-sm-12 col-xs-12'>
						<div class='thumbnail' >
							<div style='height:60%;'>
								<img src='images/foto/$row[athl_image]' class='img-thumbnail center-block' style='max-height:100%;' />
							</div>
							<div style='height:60px;'>
								<div class='caption text-center'>
									<h4>$athlete</h4>
								</div>
							</div>";
		if($pres_recorded ==''){				
			echo "					
						<div class='row' style='height:90px;'>
							<div class='col-md-5 col-md-offset-1'>" ?>
<!--								<a href='presence.php?id=$id&presence=1&class=$class'> -->
								<button class="btn btn-success btn-block" onclick="ajax_presente(<?php echo $id.',1'?>);">PRESENTE</button>
			<?php
			echo "					
								</a><br>
							</div>
							<div class='col-md-5'> "?>
<!--								<a href='presence.php?id=$id&presence=0&class=$class'> -->
								<button class='btn btn-danger btn-block' onclick="ajax_presente(<?php echo $id.',0'?>);">ASSENTE</button>
			<?php
			echo "
								</a>
							</div>
						</div>
						";
		} else {
			echo "					
						<div class='row' style='height:90px;'>
							<div class='col-md-5 col-md-offset-1'>
								<a href='presence.php'><button class='btn btn-success btn-block' disabled='disabled'>PRESENTE</button>
								</a><br>
							</div>
							<div class='col-md-5'>
								<a href='presence.php'><button class='btn btn-danger btn-block' disabled='disabled'>ASSENTE</button>
								</a>
							</div>
						</div>
						";
		}
		echo"
						</div>
					</div>
				</div>
				
		";
	}
	
	
?>
