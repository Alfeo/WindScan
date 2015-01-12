<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.css">
		<link type="text/css" rel="stylesheet" href="custom.css">
		<meta charset="utf-8">
		<title>Wind Scan - Profil</title>
	</head>
	<body>
		<img src="back.png" id="paralax">
		<div class="col-md-8 col-md-offset-2" id="header">
			<a class="return" href="index.php"><h1><strong>Wind Scan</strong></h1></a>
		</div>
		<div class="col-md-8 col-md-offset-2" id="main">
			<div id="welcome">
				<h3><strong>Bonjour <?php echo $_GET['session'];?> !</strong></h3>
			</div>
			<?php
			// CONNECT TO THE DB
				try
				{
					$bdd = new PDO('mysql:host=localhost;dbname=windscan', 'root', 'Rabbit');
				}
				catch (Exception $e)
				{
					die('Erreur : ' . $e->getMessage());
				}
				$log = $_GET['session'];
			// END
			?>
			<form method="post" action="profil.php?session=<?php echo $log; ?>">
				<input type="hidden" name="sign" placeholder="Pseudo" value="<?php echo $log; ?>">
				<input type="text" name="vivi" placeholder="Ville">
				<input type="text" name="lat" placeholder="Latitude">
				<input type="text" name="lon" placeholder="Longitude">
				<input type="hidden" name="access" value="one">
				<br></br>
				<input type="submit" value="Ajouter aux spots !">
			</form>

			<?php
				$check = $bdd->query('SELECT * FROM windspot WHERE name =\'' . $log . '\'');
				echo "<h3 id=\"all\"><strong>Vos Spots</strong></h3>";
				while ($donnees = $check->fetch())
				{
					echo $donnees['spot'];
					echo "<br></br>";
				}
			?>

			<?php
				$access = $_POST["access"];
				$town = $_POST["vivi"];
				$lat = $_POST["lat"];
				$lon = $_POST["lon"];
				$sign = $_POST["sign"];
			
				if ($access == "one" )
				{
					$bdd->exec('INSERT INTO windspot (name, spot) VALUES ('."\"".$sign."\"".", "."\"".$town." "."lat : ".$lat." "."|| lon : ".$lon."\"".')');
					$access = "two";
					header('Location: profil.php?session='.$sign);
				}
			?>

			</form>
		</div>
	</body>
</html>
