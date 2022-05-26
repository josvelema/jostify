<?php
include("includes/handlers/register-handler.php");
include("includes/handlers/login-handler.php");


 ?>



<html>

<head>
  <title>Welcome to Slotify!</title>
</head>

<body>

  <div id="inputContainer">
    <form id="loginForm" action="register.php" method="POST">
      <h2>Login to your account</h2>
      <p>
        <label for="loginUsername">Username</label>
        <input id="loginUsername" name="loginUsername" type="text" placeholder="Jos" required>
      </p>
      <p>
        <label for="loginPassword">Password</label>
        <input id="loginPassword" name="loginPassword" type="password" required>
      </p>

      <button type="submit" name="loginButton">LOG IN</button>

    </form>
    <form id="registerForm" action="register.php" method="POST">
      <h2>Create your free account</h2>
      <p>
        <label for="username">Username</label>
        <input id="username" name="username" type="text" placeholder="Jos" required>
      </p>
      <p>
        <label for="firstname">First Name</label>
        <input id="firstname" name="firstName" type="text" placeholder="Jos" required>
      </p>
      <p>
        <label for="lastname">Last Name/label>
          <input id="lastname" name="lastName" type="text" placeholder="Velema" required>
      </p>
      <p>
        <label for="email">E-mail</label>
        <input id="email" name="email" type="email" placeholder="Jos@codette.net" required>
      </p>
      <p>
        <label for="email2">Confirm E-mail</label>
        <input id="email2" name="email2" type="text" placeholder="Jos@codette.net" required>
      </p>
      <p>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" placeholder="your password" required>
      </p>
      <p>
        <label for="password2">Confirm Password</label>
        <input id="password2" name="password2" type="password" placeholder="confirm your password" required>
      </p>

      <button type="submit" name="registerButton">REGISTER</button>

    </form>
  </div>

</body>

</html>