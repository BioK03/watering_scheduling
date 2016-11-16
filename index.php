<?php
	session_start();
	header('Content-Type: text/html; charset=UTF-8');
	
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="lib/mdb/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="lib/mdb/css/mdb.min.css"/>
		<link rel="stylesheet" href="lib/font-awesome/css/font-awesome.min.css"/>
		
		<link rel="stylesheet" href="styles/styles.css"/>
	</head>
	<body>
		<h1 class="title">Système d'arrosage connecté</h1>
		<div class="homediv">
			<div id="formContainer" class="card hoverable">
				<form action="forms/postformconnection.php" method="GET">
					<span class="md-form">
						<i class="fa fa-user prefix"></i>
						<input id="login" type="text" name="login" class="form-control validate"/>
						<label for="login">Identifiant</label>
					</span>
					<span class="md-form">
						<i class="fa fa-lock prefix"></i>
						<input id="password" type="password" name="password" class="form-control validate"/>
						<label for="password">Mot de passe</label>
					</span>
					<span>
						<button class="btn btn-outline-primary" type="submit">
							<i class="fa fa-check"></i>
							Se connecter
						</button>
					</span>
				</form>
			</div>
		</div>
		
		<script type="text/javascript" src="lib/mdb/js/jquery-2.2.3.min.js"></script>
		<script type="text/javascript" src="lib/mdb/js/tether.min.js"></script>
		<script type="text/javascript" src="lib/mdb/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="lib/mdb/js/mdb.min.js"></script>
	</body>
</html>
