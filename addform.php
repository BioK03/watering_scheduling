<?php
	session_start();

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
		<h1 class="title">Programmation d'un arrosage</h1>
		<div id="formadd" class="card styleDiv hoverable">
			<a id="linkH" href="dashboard.php"><i class="fa fa-arrow-left"></i></a>
			<form method="GET" action="forms/getformwater.php">
				<?php
					if(isset($_GET["zone"]) && isset($_GET["litres"])){
						echo '<input type="hidden" name="action" value="edit"/>';
						echo '<input type="hidden" name="oldzone" value="'.$_GET["zone"].'"/>';
						echo '<input type="hidden" name="oldlitres" value="'.$_GET["litres"].'"/>';
					}else{
						echo '<input type="hidden" name="action" value="add"/>';
					}
				?>
				
				<label for="zone">Zone</label><br/>
				<div class="funkyradio">
					<div class="funkyradio-success">
						<input type="radio" name="zone" id="radio1" value="1" required <?php if(isset($_GET["zone"]) && $_GET["zone"] == 1){echo 'checked';}?> />
						<label for="radio1">Zone 1</label>
					</div>
					<div class="funkyradio-success">
						<input type="radio" name="zone" id="radio2" value="2" required <?php if(isset($_GET["zone"]) && $_GET["zone"] == 2){echo 'checked';}?> />
						<label for="radio2">Zone 2</label>
					</div>
					<div class="funkyradio-success">
						<input type="radio" name="zone" id="radio3" value="3" required <?php if(isset($_GET["zone"]) && $_GET["zone"] == 3){echo 'checked';}?> />
						<label for="radio3">Zone 3</label>
					</div>
				</div><br/>
				<span class="md-form">
					<i class="fa fa-tachometer prefix"></i>
					<input type="number" id="litres" class="form-control validate" name="litres" min="1" required <?php if(isset($_GET["litres"])){echo 'value="'.$_GET["litres"].'"';}?> />
					<label for="litres">Nombre de litres</label>
				</span><br/>
				<button class="btn btn-outline-primary" type="submit">
					<i class="fa fa-check"></i>
					Valider
				</button>
			</form>
		</div>
		
		<script type="text/javascript" src="lib/mdb/js/jquery-2.2.3.min.js"></script>
		<script type="text/javascript" src="lib/mdb/js/tether.min.js"></script>
		<script type="text/javascript" src="lib/mdb/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="lib/mdb/js/mdb.min.js"></script>
		<script>
			
		</script>
	</body>
</html>
	