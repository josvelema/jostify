<?php
include("includes/config.php");

if (isset($_SESSION['userLoggedIn'])) {
  $userLoggedIn = $_SESSION['userLoggedIn'];
} else {
  header("Location: register.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jostify</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <h1>Jostify</h1>

  <footer id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
      <div id="nowPlayingLeft">

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
              <img src="assets/svg/player-play.svg" alt="play">
            </button>
            <button class="controlButton pause" title="pause button" style="display: none;">
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

      </div>
    </div>
  </footer>
</body>

</html>