<?php 
include("../../config.php");

if(isset($_POST['playlistId'])) {

$deleteId = $_POST['playlistId'];

  $playlistQuery = mysqli_query($con, "DELETE FROM playlists WHERE id='$deleteId'");
  $songsQuery = mysqli_query($con, "DELETE FROM playlistSongs WHERE playlistId='$deleteId'");


} else {

  echo "playlist id not passed in";

}



?>
