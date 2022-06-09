<?php

include("includes/includedFiles.php");


?>

<section class="entityInfo">
  <div class="centerSection">
    <div class="userInfo">
      <h1>
        <?php echo $userLoggedIn->getNames(); ?>
      </h1>
    </div>
  </div>

  <div class="buttonItems">
    <button class="button" onclick="openPage('updateDetails.php')">
      User Details
    </button>
    <button class="button"onclick="logOut()">
      Log out
    </button>
  </div>
</section>