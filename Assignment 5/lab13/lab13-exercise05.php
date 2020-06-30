<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <title>Exercise 13-5 Inheritance</title>

   <!-- Latest compiled and minified Bootstrap Core CSS -->
   <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header>
<h1>A List of Vehicles</h1>
</header>


<div class='container'>
<?php

ini_set("display_errors",1);
date_default_timezone_set('GMT');

include_once("Vehicle.class.php");
$allVehicles	=	array(
			new	Vehicle("Ford",	"Model-T",	"Gas","30"),
			new	LandVehicle("Ford",	"Prius",	"Hybrid","130",4),
			new	WaterVehicle("White	Star	Line",	"titanic",	"Steam","24",3327,1178),
			new	LandVehicle("Honda",	"CR-V",	"Gas","165",4),
			new	WaterVehicle("Cunard	Line",	"Queen	Mary	2",	"Diesel", "30", 2620, 2620),
			new	LandVehicle("Mercedes-Benz",	"Actros",	"Diesel","140",8)
);
foreach($allVehicles	as	$v) {
			echo	$v->getDistanceOverTime(10);
}

?>
</div>

</body>
</html>
