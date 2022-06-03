<?php
include("includes/config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");




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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <script src="assets/js/script.js"></script>
</head>

<body>

  <script>
    // let audioElement = new Audio();
    // audioElement.setTrack("assets/music/bensound-anewbeginning.mp3");
    // audioElement.audio.play();
  </script>

  <main id="mainContainer">

    <section id="topContainer">

      <?php include("includes/navbar.php") ?>

      <div id="mainViewContainer">
        <div id="mainContent">