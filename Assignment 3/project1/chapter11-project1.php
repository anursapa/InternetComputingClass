<?php
include "rainbowIterator.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <title>Chapter 11</title>
    <style>
        main {
           position: relative;
        }
        span {
            height: 40px;
            width: 40px;
            border: solid black 1px;
            margin:1px;
            display: inline-block;
        }
    </style>
</head>
<body>
<main>
<!-- insert your code here -->
<?php

echo "<h1>Using Iterator: $iterator</h1>";
$red=0;
$green=0;
$blue=0;
$zindex=0;
$left=5;
$top=0;

for($red=0; $red<=255; $red+=$iterator){
  $top+=1;
  $left+=5;
  for($green=0; $green<=255; $green+=$iterator){
    for($blue=0; $blue<=255; $blue+=$iterator){

      $top+=1;
      if($red>255){
        $left=0;
        $left+=10;
      }
      if ($green>255){
        $top=0;
        $top+= 10;
      }
      $zindex+=1;



      $hexRed = sprintf('%02x', $red);
      $hexGreen = sprintf('%02x', $green);
      $hexBlue = sprintf('%02x', $blue);

      echo "<span style=\"background-color: rgb($red, $green, $blue); position:relative; top:$top"."px; left:$left"."px; z-index:$zindex;\" title=\"#$hexRed$hexGreen$hexBlue\"></span>";

    }
  }
}

?>

</main>
</body>
</html>
