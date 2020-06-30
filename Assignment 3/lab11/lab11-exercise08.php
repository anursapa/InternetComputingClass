<?php
   // function definition can go here
   function convertUnits($startVal, $startUnits, $endUnits) {
     $mlToOz = 0.033814;
     $mlToCup = 0.00422675;
     if ($endUnits=="cups"){
       return $startVal*$mlToCup;
     } else{
       return $startVal*$mlToOz;
     }
}
?>
<html>
<head>
<title>Exercise 8-8</title>
</head>
<body>
<h1>Making and using functions</h1>


<table border=1>
<tr>
  <th>milliliters</th><th>Cups</th><th>Ounces</th>
<?php
for($i=50;$i<=1000;$i+=50){
  echo "<tr>";
  echo "<td>$i</td>";
// replace the ??? with the calls to convertUnits function
  echo "<td>" . number_format(convertUnits($i,"ml","cups"),2) . "</td>";
  echo "<td>" . number_format(convertUnits($i,"ml","oz"),2) . "</td>";
  echo "</tr>";
}
?>
</tr>
</table>


</body>
</html>
