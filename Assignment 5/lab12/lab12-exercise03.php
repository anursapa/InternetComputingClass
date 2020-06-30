<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <title>Exercise 12-3 Sorting Arrays</title>

   <!-- Latest compiled and minified Bootstrap Core CSS -->
   <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<header>
</header>

 <div class="container theme-showcase" role="main">
      <div class="jumbotron">
        <h1>Division Leaderboard</h1>
	<p>Sports League</p>
      </div>

      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Score</th>
          </tr>
        </thead>
<?php

$players = array("Jhan Belig" => 189,
                 "Yemenev Baltroy" => 367,
                 "Ilroy Malvi" => 210,
                 "James John" => 121,
                 "Walton Ling" => 368,
                 "Mitch Moore" => 382,
                 "Urslaw Whig" =>422,
                 "Leo M. Toalde" => 192,
                 "Richard Bee" => 281,
                 "Travis Wise" =>182);

asort($players);
$players	=array_reverse($players);
echo "<tbody>";
foreach ($players as $key => $score) {
  echo("<tr><td>" . $key . "</td>");
  echo("<td>" . $score . "</td></tr>");
}
echo "</tbody>";
?>
 </div>
</body>
</html>
