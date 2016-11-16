<?php
	session_start();
	header('Content-Type: text/html; charset=UTF-8');
	if($_SESSION["connected"] == 0){
		header("Location:index.php");
	}
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
		<a id="logout" href="forms/postformconnection.php"><i class="fa fa-sign-out"></i>Déconnexion</a>
		<div id="containerDash">
			<div class="clearfix"></div>
			<div id="cours" class="card styleDiv hoverable">
				<h2>Programmation</h2>
				<table id="courant"></table>
				<a id="prog" href="addform.php"><i class="fa fa-plus"></i> Programmer un arrosage</a>
			</div><!--
			--><div id="eclairage" class="card styleDiv hoverable">
				<h2>Eclairage</h2>
			</div>
		</div>
		<div class="clearfix"></div>
		<div id="data">
			<div class="styleDiv card">
				<i class="fa fa-clock-o"></i><br/><?php $now = new DateTime();echo $now->format('d/m/Y H:i');  ?>
			</div><!--
			--><div class="styleDiv card">
				<i class="fa fa-tachometer"></i><br/><span id="litrecounter"></span>
			</div><!--
			--><div class="styleDiv card">
				<img class='img2em' src='images/sprinkler.png'/><br/><span id="arrosagecounter"></span>
			</div>
		</div><!--
		--><div id="histo" class="card styleDiv hoverable">
			<h2>Derniers arrosages</h2>
			<table id="histoContainer">

			</table>
		</div>
		
		<script type="text/javascript" src="lib/mdb/js/jquery-2.2.3.min.js"></script>
		<script type="text/javascript" src="lib/mdb/js/tether.min.js"></script>
		<script type="text/javascript" src="lib/mdb/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="lib/mdb/js/mdb.min.js"></script>
		<script type="text/javascript" src="scripts/script.js"></script>
		
	</body>
</html>