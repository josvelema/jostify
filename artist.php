<?php include("includes/includedFiles.php");

if (isset($_GET['id'])) {
  $artistId = $_GET['id'];
} else {
  header("Location: index.php");
}

$artist = new Artist($con, $artistId);

?>

<section class="entityInfo borderBottom">

  <div class="centerSection">
    <header class="artistInfo">
      <h1 class="artistName">
        <?php echo $artist->getName(); ?>
      </h1>
      <div class="headerButtons">
        <button class="button green" onclick="playFirstSong()">play</button>
      </div>
    </header>



  </div>


</section>

<section class="trackListContainer borderBottom">
  <h2>Songs</h2>
  <ul class="trackList">


    <?php
    $songIdArray = $artist->getSongIds();
    $i = 1;
    foreach ($songIdArray as $songId) {
      $albumSong = new Song($con, $songId);

      $albumArtist = $albumSong->getArtist();

      if($i > 5) {
        break;
      }

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
</section>

<section class="gridViewContainer">
  <h2>Albums</h2>
  <?php
  $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId'");

  while ($row = mysqli_fetch_array($albumQuery)) {
    echo "<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
						<img src='" . $row['artworkPath'] . "'>

						<div class='gridViewInfo'>"
      . $row['title'] .
      "</div>
					</span>

				</div>";
  }
  ?>
</section>
