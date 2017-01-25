<?php
echo "
			<nav class='navbar navbar-transparent navbar-absolute'>
				<div class='container-fluid'>
					<div class='navbar-header'>
						<button type='button' class='navbar-toggle' data-toggle='collapse'>
							<span class='sr-only'>Toggle navigation</span>
							<span class='icon-bar'></span>
							<span class='icon-bar'></span>
							<span class='icon-bar'></span>
						</button>
						<a class='navbar-brand' href='#'>Karate Shotokan Viareggio - Benvenuto, ".$_SESSION['username']."!</a>
					</div>
					<div class='collapse navbar-collapse'>
						<ul class='nav navbar-nav navbar-right'>
							<li class='dropdown'>
								<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
	 							   <i class='material-icons'>person</i>
	 							   <p class='hidden-lg hidden-md'>Profile</p>
		 						</a>
								<ul class='dropdown-menu'>
									<li><a href='#'>Mike John responded to your email</a></li>
									<li><a href='#'>You have 5 new tasks</a></li>
								</ul>
							</li>
						</ul>
						<form class='navbar-form navbar-right' role='search'>
							<div class='form-group  is-empty'>
								<input type='text' class='form-control' placeholder='Cerca'>
								<span class='material-input'></span>
							</div>
							<button type='submit' class='btn btn-white btn-round btn-just-icon'>
								<i class='material-icons'>search</i><div class='ripple-container'></div>
							</button>
						</form>
					</div>
				</div>
			</nav>
";
?>