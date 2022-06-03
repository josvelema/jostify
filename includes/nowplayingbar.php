<?php

$songQuery = mysqli_query($con, "SELECT id from songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

while ($row = mysqli_fetch_array($songQuery)) {
  array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);

?>

<script>
  $(document).ready(function() {
    currentPlaylist = <?php echo $jsonArray; ?>;
    audioElement = new Audio();
    setTrack(currentPlaylist[0], currentPlaylist, false);


  });

  function setTrack(trackId, newPlaylist, play) {

    $.post("includes/handlers/ajax/getSongJSON.php", {
      songId: trackId
    }, function(data) {

      var track = JSON.parse(data);

      $(".trackName span").text(track.title);

      $.post("includes/handlers/ajax/getArtistJSON.php", {
        artistId: track.artist
      }, function(data) {
        var artist = JSON.parse(data);

        $(".artistName span").text(artist.name);
      });


      audioElement.setTrack(track.path);
      audioElement.play();
    });

    if (play == true) {
      audioElement.play();
    }
  }



  function playSong() {
    audioElement.play();
    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
  }


  function pauseSong() {
    $(".controlButton.pause").hide();
    $(".controlButton.play").show();
    audioElement.pause();
  }
</script>



<footer id="nowPlayingBarContainer">
  <div id="nowPlayingBar">

    <div id="nowPlayingLeft">
      <div class="content">

        <span class="albumLink">
          <img src="//unsplash.it/200/200" alt="" class="albumArtwork">
        </span>

        <div class="trackInfo">
          <span class="trackName">
            <span></span>
          </span>
          <span class="artistName">
            <span></span>
          </span>
        </div>

      </div>
    </div>

    <div id="nowPlayingCenter">
      <div class="content playerControls">
        <div class="buttons">
          <button class="controlButton shuffle" title="shuffle button">
            <img src="assets/svg/arrows-shuffle-2.svg" alt="shuffle">
          </button>
          <button class="controlButton previous" title="previous button">
            <img src="assets/svg/player-skip-back.svg" alt="previous">
          </button>
          <button class="controlButton play" title="play button">
            <img src="assets/svg/player-play.svg" alt="play" onclick="playSong()">
          </button>
          <button class="controlButton pause" title="pause button" style="display: none;" onclick="pauseSong()">
            <img src="assets/svg/player-pause.svg" alt="pause">
          </button>
          <button class="controlButton next" title="next button">
            <img src="assets/svg/player-skip-forward.svg" alt="next">
          </button>
          <button class="controlButton repeat" title="repeat button">
            <img src="assets/svg/repeat.svg" alt="repeat">
          </button>
          <!-- <button class="controlButton shuffle" title="shuffle button">
                <img src="assets/svg/" alt="">
              </button> -->

        </div>

        <div class="playbackBar">
          <span class="progressTime current">
            0.00
          </span>
          <div class="progressBar">
            <div class="progressBarBg">
              <div class="progress"></div>
            </div>
          </div>
          <span class="progressTime remaining">
            0.00
          </span>
        </div>

      </div>
    </div>

    <div id="nowPlayingRight">

      <div class="volumeBar">
        <button class="controlButton volume" title="volume button">
          <img src="assets/svg/volume.svg" alt="Volume">
        </button>

        <div class="progressBar">
          <div class="progressBarBg">
            <div class="progress"></div>
          </div>
        </div>

      </div>

    </div>

  </div>
</footer>