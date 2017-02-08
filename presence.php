<?php
include "function_setup.php";
// VERIFICARE CHE LA SESSIONE SIA ANCORA APERTA
if(!isset($_SESSION['user_email']))
{
    header("location: login.php");
}
$name = $_SESSION['username'];
$db_pres = new db($cartella_ini,$messaggi_errore,true);
$class = $_REQUEST['class'];	
?>

<html>
    <head>
      <title>Inserisci presenze</title>
      <?php include 'header_head.php';?>
			
			<script>
				function ajax_function(){
					xmlhttp = new XMLHttpRequest();					
					xmlhttp.onreadystatechange = function(){
						if(xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
							document.getElementById('get_atleti').innerHTML = xmlhttp.responseText;
						}
					}
					xmlhttp.open('GET','presence_ajax_process.php?class=<?php echo $class;?>',true);
					xmlhttp.send();
				}
				
				function ajax_presente(athl_id,status){
					xmlhttp.onreadystatechange = function(){
						if(xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
							document.getElementById('get_atleti').innerHTML = xmlhttp.responseText;
						}
					}
					xmlhttp.open('GET','presence_ajax_process.php?id='+athl_id+'&presence='+status+'&class=<?php echo $class;?>',true);
					xmlhttp.send();
				}
				
				
				
				
			</script>
    </head>
    <body onload="ajax_function();">
        <!-- NAV BAR -->
 		<div class="wrapper">
		<?php include 'sidebar.php';?>
			<div class="main-panel">
				<?php include 'header.php';?>
        <!-- PRODUCT BODY -->
				<div class="content">
					<div class="container-fluid">
						<div class="row" id="get_atleti">
							<!-- INIZIO -->
							<!-- PRESENCE_AJAX_PROCESS-->
							<!-- FINE -->
						</div>
				<footer class="footer">
					<div class="container-fluid">
					<p><a href="<?php echo $_SERVER["HTTP_REFERER"];?>">Indietro</a></p>
					</div>
				</footer>
					</div>
				</div>
			</div>
		</div>        <div class="clearfix"></div>

    </body>
<?php
		//INSERISCI PRESENZA
/*		if(isset($_GET['id']) && isset($_GET['presence']))
		{
			$db_pres->athlete_presence($_GET['id'],$_GET['presence']);
			//echo "<script>window.open('presence.php?class=".$_GET['class']."','_self')</script>";
		} 
 */
		?>
			
<?php include 'footer.php';?>

</html>
