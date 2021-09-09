<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
  header("location: user.php");
  exit;
}

// Include database configuration file
require_once "config.php";

// Assign empty values to variables
$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Check Username
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter Username";
  }
  else {
    $username = trim($_POST["username"]);
  }
  // Check Password
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter Password";
  }
  else {
    $password = trim($_POST["password"]);
  }

  // Validate Username and Password
  if (empty($username_err) && empty($password_err)) {
    try{
      // Prepare a Select statement
      $select = "SELECT username, password FROM user_credentials WHERE username = ?";

      $stmt = $mysql->prepare($select);

      $stmt->execute([$username]);

      if ($stmt->rowCount() == 1) {
        $arr = $stmt->fetch();
        // Check if Password is correct
        if (password_verify($password, $arr["password"])) {
          // Start the Session
          session_start();

          $_SESSION["loggedin"] = true;
          $_SESSION["username"] = $username;

          // Redirect to Profile page
          header("location: user.php");
        }
        else {
          $password_err = "Password is Invalid.";
        }
      }
      else {
        $username_err = "Account with this Username does not exists";
      }

      // Close statement
      $stmt = null;
    }
    catch(PDOException $e) {
      echo "ERROR! ".$e->getMessage();
    }
  }
  // Close Connection
  $mysql = null;
}

?>
