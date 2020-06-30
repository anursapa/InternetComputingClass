<?php
/*
   Represents a single travel photo
 */
class TravelPhoto{
  private $date;
  private $fileName;
  private $description;
  private $title;
  private $latitude;
  private $longtitude;
  private $ID;
  public static $photoID=0;
  function __construct($fileName, $title, $description, $latitude,$longtitude){
    $this->fileName = $fileName;
    $this->title = $title;
    $this->description = $description;
    $this->latitude = $latitude;
    $this->longtitude = $longtitude;
    self::$photoID++;
  }
  public function __toString(){
    return '<img src="'.$this->fileName.'" alt="'.$this->description.'" title="'.$this->description.'">';
  }
}

?>
