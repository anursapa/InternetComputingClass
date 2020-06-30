<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <title>Exercise 13-1 Creating Classes</title>

   <!-- Latest compiled and minified Bootstrap Core CSS -->
   <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header>
<h1>Weather forecast using classes</h1>
</header>

<div class='container'>
<?php

ini_set("display_errors",1);
date_default_timezone_set('GMT');

include_once("Forecast.class.php");

$today = time();
$oneday = 60*60*24;

$dayOne =	new Forecast (date("d	M,	Y",	$today),73,54,"sunny");
$dayTwo = new Forecast (date("d	M,	Y",	$today+$oneday),81,61,"cloudy");
$dayThree = new Forecast (date("d	M,	Y",	$today+2*$oneday),76,52,"rain");
$dayFour = new Forecast (date("d	M,	Y",	$today+3*$oneday),71,58,"sunny");
$dayFive = new Forecast (date("d	M,	Y",	$today+4*$oneday),74,62,"hot");
$daySix = new Forecast (date("d	M,	Y",	$today+5*$oneday),68,53,"sunny");
$daySeven = new Forecast (date("d	M,	Y",	$today+6*$oneday),72,56,"hot");

$forecast	=	array	();
$forecast[]	=	$dayOne;
$forecast[]	=	$dayTwo;
$forecast[]	=	$dayThree;
$forecast[]	=	$dayFour;
$forecast[]	=	$dayFive;
$forecast[]	=	$daySix;
$forecast[]	=	$daySeven;

foreach($forecast as $oneDay){
  echo $oneDay;
}

?>
</div>
<footer>
		<h3>Record	High:	<?php	echo	Forecast::$allTimeHigh; ?></h3>
		<h3>Record	Low:	<?php	echo	Forecast::$allTimeLow; ?></h3>
</footer>

</body>
</html>
