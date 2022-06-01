<?php
class Artist
{
  private $con;
  private $id;
  private $name;


  public function __construct($con)
  {
    $this->con = $con;
    $this->errorArray = array();
  }
}
