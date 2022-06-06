<?php
include("includes/includedFiles.php");

if (isset($_GET['term'])) {
  $term = urldecode($_GET['term']);
} else {
  $term = "";
}


?>
<section class="searchContainer">
  <h4>Search for an artist, album or song</h4>
  <input type="text" name="term" class="searchInput" value="<?php echo $term; ?>" placeholder="start typing.." onfocus="var val=this.value; this.value=''; this.value= val;" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
</section>

<script>
  $(function() {
    
    $(".searchInput").focus();

    $(".searchInput").keyup(function() {
      clearTimeout(timer);

      timer = setTimeout(function() {
        let val = $(".searchInput").val();
        openPage("search.php?term=" + val);
      }, 2000);
    })
  })
</script>

<?php if($term == "") exit(); ?>


<section class="trackListContainer borderBottom">
  <h2>Songs</h2>
  <ul class="trackList">


    <?php
    $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%'");

    if(mysqli_num_rows($songsQuery) == 0) {
      echo "<span class='noResults'>No songs found matching ' " . $term . " '</span>";
    } 

    $songIdArray = array();
    $i = 1;

    while ($row = mysqli_fetch_array(($songsQuery))){
      if ($i > 15) {
        break;
      }

      array_push($songIdArray,$row['id']);

      $albumSong = new Song($con, $row['id']);

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
      var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
      tempPlaylist = JSON.parse(tempSongIds);
    </script>

  </ul>
</section>


<section class="artistContainer borderBottom">
  <h2>
    Artists
  </h2>

  <?php 
    $artistQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$term%'");
    if(mysqli_num_rows($artistQuery) == 0) {
      echo "<span class='noResults'>No artists found matching ' " . $term . " '</span>";
    } 
  
    while ($row = mysqli_fetch_array(($artistQuery))){
      $artistFound = new Artist ($con , $row['id']);

      echo '
        <div class="searchResultRow">
          <div class="artistName">
            <span role="link" tabindex="0" onclick="openPage(\'artist.php?id='. $artistFound->getId() .'\')">
            '
              . $artistFound->getName() .
            '
            </span>
          </div>
        </div>
      ';
    }
  
  ?>
</section>

<section class="gridViewContainer">
  <h2>Albums</h2>
  <?php
  $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$term%' ");

  if(mysqli_num_rows($albumQuery) == 0) {
    echo "<span class='noResults'>No albums found matching ' " . $term . " '</span>";
  } 


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

