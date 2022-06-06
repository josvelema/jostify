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
    let newPlaylist = <?php echo $jsonArray; ?>;
    audioElement = new Audio();
    setTrack(newPlaylist[0], newPlaylist, false);
    updateVolumeProgressBar(audioElement.audio);

    $("#nowPlayingBarContainer").on("mousedown mousemove", function(e) {
      e.preventDefault();
    })



    $(".playbackBar .progressBar").mousedown(function() {
      mouseDown = true;

    })

    $(".playbackBar .progressBar").mousemove(function(e) {
      if (mouseDown) {
        timeFromOffset(e, this)
      }

    })

    $(".playbackBar .progressBar").mouseup(function(e) {

      timeFromOffset(e, this)

    })


    $(".volumeBar .progressBar").mousedown(function() {
      mouseDown = true;

    })

    $(".volumeBar .progressBar").mousemove(function(e) {
      if (mouseDown) {
        let percentage = e.offsetX / $(this).width();

        if (percentage >= 0 && percentage <= 1) {
          audioElement.audio.volume = percentage;
        }


      }

    })

    $(".volumeBar .progressBar").mouseup(function(e) {

      let percentage = e.offsetX / $(this).width();

      if (percentage >= 0 && percentage <= 1) {
        audioElement.audio.volume = percentage;
      }



    })


    $(document).mouseup(function() {
      mouseDown = false;
    })

  });

  function timeFromOffset(mouse, progressBar) {
    let percentage = mouse.offsetX / $(progressBar).width() * 100;
    let seconds = audioElement.audio.duration * (percentage / 100);
    audioElement.setTime(seconds)

  }

  function prevSong() {
    if (audioElement.audio.currentTime >= 3 || currentIndex == 0) {
      audioElement.setTime(0)
    } else {
      currentIndex--;
      setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    }
  }


  function nextSong() {
    if (repeat) {
      audioElement.setTime(0);
      playSong();
      return;
    }


    if (currentIndex == currentPlaylist.length - 1) {
      currentIndex = 0;
    } else {
      currentIndex++;
    }
    // let trackToPlay = currentPlaylist[currentIndex];
    let trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];

    setTrack(trackToPlay, currentPlaylist, true);
  }

  function setRepeat() {
    repeat = !repeat;
    let imageName = repeat ? "repeat.svg" : "repeat-off.svg";
    $(".controlButton.repeat img").attr("src", "assets/svg/" + imageName);
  }

  function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;

    let imageName = audioElement.audio.muted ? "volume-off.svg" : "volume.svg";
    $(".controlButton.volume img").attr("src", "assets/svg/" + imageName);

  }


  function setShuffle() {
    shuffle = !shuffle;


    let imageName = shuffle ? "arrows-shuffle-2.svg" : "arrows-right.svg";
    $(".controlButton.shuffle img").attr("src", "assets/svg/" + imageName);

    if (shuffle) {
      shuffleArray(shufflePlaylist);
      currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
    } else {
      currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);

    }

  }

  function shuffleArray(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
      j = Math.floor(Math.random() * (i + 1));
      x = a[i];
      a[i] = a[j];
      a[j] = x;
    }
    return a;
  }


  function setTrack(trackId, newPlaylist, play) {

    if (newPlaylist != currentPlaylist) {
      currentPlaylist = newPlaylist;
      shufflePlaylist = currentPlaylist.slice();
      shuffleArray(shufflePlaylist);
    }

    if (shuffle) {
      currentIndex = shufflePlaylist.indexOf(trackId);
    } else {
      currentIndex = currentPlaylist.indexOf(trackId);

    }

    pauseSong();

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

      $.post("includes/handlers/ajax/getAlbumJSON.php", {
        albumId: track.album
      }, function(data) {
        var album = JSON.parse(data);

        $(".albumLink img").attr("src", album.artworkPath);
      });


      audioElement.setTrack(track);

      if (play == true) {
        playSong();

      }
    });

  }



  function playSong() {
    if (audioElement.audio.currentTime == 0) {
      $.post("includes/handlers/ajax/updatePlays.php", {
        songId: audioElement.currentlyPlaying.id
      });
    }

    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play();
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
          <img src="" alt="" class="albumArtwork">
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
          <button class="controlButton shuffle" title="shuffle button" onclick="setShuffle()">
            <img src="assets/svg/arrows-shuffle-2.svg" alt="shuffle">
          </button>
          <button class="controlButton previous" title="previous button" onclick="prevSong()">
            <img src="assets/svg/player-skip-back.svg" alt="previous">
          </button>
          <button class="controlButton play" title="play button">
            <img src="assets/svg/player-play.svg" alt="play" onclick="playSong()">
          </button>
          <button class="controlButton pause" title="pause button" style="display: none;" onclick="pauseSong()">
            <img src="assets/svg/player-pause.svg" alt="pause">
          </button>
          <button class="controlButton next" title="next button">
            <img src="assets/svg/player-skip-forward.svg" alt="next" onclick="nextSong()"">
          </button>
          <button class=" controlButton repeat" title="repeat button" onclick="setRepeat()">
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
        <button class="controlButton volume" title="volume button" onclick="setMute()">
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