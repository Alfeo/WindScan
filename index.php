<!DOCTYPE html>
<html>
	<head>
		<title>Wind Scan - Index</title>
		<link type="text/css" rel="stylesheet" href="bootstrap.css">
		<link type="text/css" rel="stylesheet" href="custom.css">
		<meta charset="utf-8">
	</head>
	<body>
		<img src="back.png" id="paralax">
		<div class="col-md-8 col-md-offset-2" id="header">
			<h1 class="return"><strong>Wind Scan</strong></h1>
		</div>
		<div class="col-md-8 col-md-offset-2" id="main">
			<a href="connect.php"><img id="but" src="profil.png"></a>
			<form action="index.php" method="POST" id="search">
				<input type="text" name="adr" placeholder="Adresse" size="36px">
				<br></br>	
				<input type="text" name="cop" placeholder="Code Postal" size="10px">	
				<input type="text" name="vil" placeholder="Ville" size="10px">	
				<input type="text" name="pay" placeholder="Pays" size="10px">
				<br></br>	
				<input type="submit" value="Check !">
			</form>
			<?php
			//CONVERTER ADRESS TO GPS
				$adre = $_POST['adr'];
				$copo = $_POST['cop'];
				$vill = $_POST['vil'];
				$pays = $_POST['pay'];
				function AdressCheck($address)
				{
					$coord=array();
					$api="http://maps.googleapis.com/maps/api/geocode/xml?";
					$request = $api . "address=" . urlencode($address).'&sensor=false';
					$xml = simplexml_load_file($request) or die("url not loading");
					$coord['lat']=$coord['lon']='';
					$coord['status'] = $xml->status ;
					if($coord['status']=='OK')
					{
						$coord['lat'] = $xml->result->geometry->location->lat ;
						$coord['lon'] = $xml->result->geometry->location->lng ;
					}
					return $coord;
				}
				$entry = "$adre, $copo $vill, $pays";
				$coord=AdressCheck("$entry");
				if ($entry != NULL)
				{
					echo "<div id=\"result\">Lattitude :<strong> ".$coord['lat']."</strong> || Longitude :<strong> ".$coord['lon']."</strong></div>";

					include('lib/forecast.io.php');
			
					$api_key = '19d8afb60adf960b4e67967d6949a902';
			
					$latitude = $coord['lat'];
					$longitude = $coord['lon'];
					$units = 'auto';  // Can be set to 'us', 'si', 'ca', 'uk' or 'auto' (see forecast.io API); default is auto
					$lang = 'fr'; // Can be set to 'en', 'de', 'pl', 'es', 'fr', 'it', 'tet' or 'x-pig-latin' (see forecast.io API); default is 'en'
			
					$forecast = new ForecastIO($api_key);
			
					$condition = $forecast->getCurrentConditions($latitude, $longitude, $units, $lang);
				
					echo "<div class=\"advance\"> Température : <strong>".$condition->getTemperature()." °C</strong><br></br>";
					echo "Vitesse du Vent : <strong>".$condition->getwindSpeed() * 1.6." km/h</strong></div>";
				}
					
					echo "<div class=\"pred\"><h3><strong>Vitesse du vent pour la semaine :</strong></h3></div><br></br>";
					$conditions_week = $forecast->getForecastWeek($latitude, $longitude);
					
					$jour = 1;

					foreach($conditions_week as $conditions) 
					{				  
						$checkwind = $conditions->getwindSpeed() * 1.6;
						if ($checkwind >= 8 && $checkwind <= 30)
						{
							echo "<p class=\"green\">Dans ".$jour." jours : ".$checkwind." km/h</p>";			
							$jour += 1;
						}
						else
						{
							echo "<p class=\"red\">Dans ".$jour." jours : ".$checkwind." km/h</p>";			
							$jour += 1;
						}
					}
			?>

			<div class="nothing"></div>
		</div>
	</body>
</html>
