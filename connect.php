<!DOCTYPE html>
<html>
	<head>
			<link type="text/css" rel="stylesheet" href="bootstrap.css">
			<link type="text/css" rel="stylesheet" href="custom.css">
			<meta charset="utf-8">
			<title>Wind Scan - Login</title>
	</head>
	<body>
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
		// END
		?>
		<img src="back.png" id="paralax">
		<div class="col-md-8 col-md-offset-2" id="header">
			<a class="return" href="index.php"><h1><strong>Wind Scan</strong></h1></a>
		</div>
		<div class="col-md-8 col-md-offset-2" id="main">
			<form action="connect.php" method="post"i id="logfield">
				Nom d'utilisateur :<br></br>
				<input type="text" name="pseudo"><br></br>
				Mot de Pass :<br></br>
				<input type="password" name="pass"><br></br>
				<input type="submit" value="Enter !">
			</form>

			<?php
			// CHECK THE LOGIN CONTENTS
				$log = $_POST["pseudo"];
				$pw = $_POST["pass"];
				$check = $bdd->query('SELECT * FROM winduser WHERE name =\'' . $log . '\'');
				$donnees = $check->fetch();
				if ($donnees['pass'] == $pw && $log != NULL)
				{	
					echo "GOOD !";
					header('Location: profil.php?session='.$log);
				}
			//END
			?>

		</div>
	</body>
</html>
