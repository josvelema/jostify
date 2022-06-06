<?php include("includes/includedFiles.php");


if (isset($_GET['id'])) {
  $albumId = $_GET['id'];
} else {
  header("Location: index.php");
}

$album = new Album($con, $albumId);

$artist = $album->getArtist();

// echo $album->getTitle();
// echo $artist->getName();

?>

<div class="entityInfo">

  <div class="leftSection">
    <img src="<?php echo $album->getArtworkPath(); ?>" alt="">
  </div>

  <div class="rightSection">
    <h2><?php echo $album->getTitle(); ?></h2>
    <p>By <?php echo $artist->getName();  ?></p>
    <p><?php echo $album->getNumberOfSongs() . " songs";  ?></p>

  </div>

</div>

<div class="trackListContainer">
  <ul class="trackList">


    <?php
    $songIdArray = $album->getSongIds();
    $i = 1;
    foreach ($songIdArray as $songId) {
      $albumSong = new Song($con, $songId);

      $albumArtist = $albumSong->getArtist();

			echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/svg/player-play.svg'
             onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>


					<div class='trackInfo'>
						<span class='trackName'>" . $albumSong->getTitle() . "</span>
						<span class='artistName'>" . $albumArtist->getName() . "</span>
					</div>

					<div class='trackOptions'>
						<img class='optionsButton' src='assets/svg/dots-vertical.svg'>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $albumSong->getDuration() . "</span>
					</div>


				</li>";

      $i++;
    }

    ?>
<script>
let tempSongIds = '<?php echo json_encode($songIdArray); ?>';
tempPlaylist = JSON.parse(tempSongIds);


</script>

  </ul>
</div>


