<?php
require_once('config.php'); 
try {
   $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
   die( $e->getMessage() );
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Chapter 14</title>

      <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    
    

    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />    

</head>

<body>
    <?php include 'includes/header.inc.php'; ?>
    


    <!-- Page Content -->
    <main class="container">
        <div class="panel panel-default">
          <div class="panel-heading">Filters</div>
          <div class="panel-body">
            <form action="chapter14-project2.php" method="get" class="form-horizontal">
              <div class="form-inline">
              <select name="continent" class="form-control">
                <option value="0">Select Continent</option>
                <?php 
                $sql = 'select * from Continents order by ContinentName';
                $result = $pdo->query($sql);
                while ($row = $result->fetch()) {         
                   echo '<option value="' . $row['ContinentCode'] . '"';
                   if (isset($_GET['continent']) && $row['ContinentCode'] == $_GET['continent']) 
                      echo ' selected ';
                   echo '>';
                   echo $row['ContinentName'];
                   echo '</option>';
                 }
                ?>
              </select>     
              
              <select name="country" class="form-control">
                <option value="0">Select Country</option>
                <?php 
                              $sql = 'select * from Countries where Continent=:id order by CountryName ';
                              $id	=		$_GET['continent'];
                $result = $pdo->prepare($sql);
                $result->bindValue(':id',	$id);
                    $result->execute();
                              while ($row = $result->fetch()) {         
                                 echo '<option value="' . $row['ISO'] . '"';
                                 if (isset($_GET['country']) && $row['ISO'] == $_GET['country']) 
                                    echo ' selected ';
                                 echo '>';
                                 echo $row['CountryName'];
                                 echo '</option>';
                               }
                ?>
              </select>    
              <input type="text"  placeholder="Search title" class="form-control" name=title>
              <button type="submit" class="btn btn-primary">Filter</button>
              </div>
            </form>

          </div>
        </div>     
                                    

		<ul class="caption-style-2">
            <?php 
            
            if (isset($_GET['continent']) && ! empty($_GET['continent']) ) {
              $sql = 'select * from imagedetails where ContinentCode=:id';
              $id	=		$_GET['continent'];
                $result = $pdo->prepare($sql);
                $result->bindValue(':id',	$id);
                    $result->execute();
                while ($row = $result->fetch()) {         
                   echo '<li>
                   <a href="detail.php?id='.$row['ImageID'] .'" class="img-responsive">
                           <img src="images/square-medium/'.$row['Path'] .'" alt="'.$row['Title'] .'">
                           <div class="caption">
                               <div class="blur"></div>
                               <div class="caption-text">
                                   <p>'.$row['Title'] .'</p>
                               </div>
                           </div>
                   </a>
         </li>';
            }}
            else if (isset($_GET['country']) && ! empty($_GET['country'])) {
              $sql = 'select * from imagedetails WHERE CountryCodeISO=:id';
              $id	=		$_GET['continent'];
                $result = $pdo->prepare($sql);
                $result->bindValue(':id',	$id);
                    $result->execute();
                while ($row = $result->fetch()) {         
                   echo '<li>
                   <a href="detail.php?id='.$row['ImageID'] .'" class="img-responsive">
                           <img src="images/square-medium/'.$row['Path'] .'" alt="'.$row['Title'] .'">
                           <div class="caption">
                               <div class="blur"></div>
                               <div class="caption-text">
                                   <p>'.$row['Title'] .'</p>
                               </div>
                           </div>
                   </a>
         </li>';}}
          
            // }
            else if (isset($_GET['title']) && ! empty($_GET['title'])) {
              $sql = 'select * from imagedetails WHERE Title LIKE :id';
              $id	=		'%' . $_GET['title'].'%';
                $result = $pdo->prepare($sql);
                $result->bindValue(':id',	$id);
                    $result->execute();
                while ($row = $result->fetch()) {         
                   echo '<li>
                   <a href="detail.php?id='.$row['ImageID'] .'" class="img-responsive">
                           <img src="images/square-medium/'.$row['Path'] .'" alt="'.$row['Title'] .'">
                           <div class="caption">
                               <div class="blur"></div>
                               <div class="caption-text">
                                   <p>'.$row['Title'] .'</p>
                               </div>
                           </div>
                   </a>
         </li>';}
            }
        else {     
            $sql = 'select * from imagedetails';
                $result = $pdo->query($sql);
                while ($row = $result->fetch()) {         
                   echo '<li>
                   <a href="detail.php?id='.$row['ImageID'] .'" class="img-responsive">
                           <img src="images/square-medium/'.$row['Path'] .'" alt="'.$row['Description'] .'">
                           <div class="caption">
                               <div class="blur"></div>
                               <div class="caption-text">
                                   <p>'.$row['Title'] .'</p>
                               </div>
                           </div>
                   </a>
         </li>';
                 }
                }
            /* display list of images ... sample below ... replace ???? with field data
           
			   <li>
                  <a href="detail.php?id=????" class="img-responsive">
                          <img src="images/square-medium/????" alt="????">
                          <div class="caption">
                              <div class="blur"></div>
                              <div class="caption-text">
                                  <p>????</p>
                              </div>
                          </div>
                  </a>
			  </li>        
          */ ?>
       </ul>       

      
    </main>
    
    <footer>
        <div class="container-fluid">
                    <div class="row final">
                <p>Copyright &copy; 2017 Creative Commons ShareAlike</p>
                <p><a href="#">Home</a> / <a href="#">About</a> / <a href="#">Contact</a> / <a href="#">Browse</a></p>
            </div>            
        </div>
        

    </footer>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>