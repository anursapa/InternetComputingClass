<html>
<head>
<title>Exercise 8-4</title>
</head>
<body>
<h1>Age calculator</h1>

<?php
$birthday = mktime(0,0,0,6,23,1989); //Jan 15, 2014 00:00:00
$today = time(); // current time in seconds since 1970.
$secondsOld = $today - $birthday;

echo "<p>Time elapsed since " . date("M d, Y",$birthday) . ":</p>";
?>

<ul>
   <li><?php echo number_format($secondsOld); ?> seconds, or </li>
   <li><?php echo number_format($secondsOld/(60*60*24)); ?> days, or </li>
   <li><?php echo number_format($secondsOld/(60*60*24*30.4), 1); ?> months, or </li>
   <li><?php echo number_format($secondsOld/(60*60*24*365.242375), 2); ?> years</li>
</ul>
</body>
</html>
