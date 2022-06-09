<?php
include("../../config.php");

if (!isset($_POST['username'])) {
  echo "error: could not set username";
  exit();
}

if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2']) ) {
  echo "not all passwords have been set";
  exit();
}

if($_POST['oldPassword'] == "" || $_POST['newPassword1'] == ""  || $_POST['newPassword2'] == ""  ) {
  echo "please fill in all fields";
  exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];

$oldMd5 = md5($oldPassword);

$passwordCheck = mysqli_query($con ,"SELECT * FROM users WHERE username='$username' AND password='$oldMd5'");

if(mysqli_num_rows($passwordCheck) != 1) {
  echo "password incorrect!";
  exit();
}

if($newPassword1 != $newPassword2) {
  echo "passwords do not match";
  exit();
}

if (preg_match('/[^A-Za-z0-9]/', $newPassword1)) {
  echo "your password must only contain letters and numbers";
  exit();
}

if(strlen($newPassword1) > 40 || strlen($newPassword1) < 5  ) {
  echo "your password must between 5 and 40 characters";
  exit();
}

$newMd5 = md5($newPassword1);

$updateQuery = mysqli_query($con ,"UPDATE users SET password '$newMd5' WHERE username = '$username'");
echo "Update password succesfull!" ;
exit();

?>