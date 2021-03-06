<?php

include("includes/includedFiles.php");

?>

<section class="playlistsContainer">
  <div class="gridViewContainer">
    <h2>playlists</h2>

    <div class="buttonItems">
      <button class="button green" onclick="createPlaylist()">new playlist</button>
    </div>


    <?php
    $username = $userLoggedIn->getUsername();
    

    $playlistQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner = '$username' ");

    if (mysqli_num_rows($playlistQuery) == 0) {
      echo "<span class='noResults'>You dont have any playlists yet";
    }


    while ($row = mysqli_fetch_array($playlistQuery)) {
$playlist = new Playlist($con , $row);

      echo "<div class='gridViewItem' role='link' tabindex='0' 
      onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>

      <div class='playlistImage'>
      <img src='assets/svg/playlist.svg'>
      </div>

      <div class='gridViewInfo'>"
        . $playlist->getName() .
        "</div>

				</div>";
    }
    ?>


  </div>

</section>