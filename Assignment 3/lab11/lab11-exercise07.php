<html>
<head>
<title>Exercise 8-7</title>
</head>
<body>
<h1>Simple Calendar using Loops</h1>

<table border="1">
<tr>
  <th colspan='7'><?php echo date('F'); ?></th>
</tr>
<tr>
  <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
</tr>
<?php
$day = 0;
$dayX = 0;
$dayOne = date("w",mktime(0,0,0,date("n"),1, date("Y")));

while ($day<$dayOne){
  echo "<td></td>";
  $day++;
}

while ($dayX<date('t')) {
 //when we need a new row go ahead.

 if ($day%7==0) {
 echo "</tr><tr>";
 }
 echo "<td>".($dayX+1)."</td>";
 $dayX++;
 $day++;
}
?>

</table>


</body>
</html>
