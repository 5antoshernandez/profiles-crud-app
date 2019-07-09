<?php
require "pdo.php";
include_once "functions.php";
session_start();

checklogin();

if ( isset($_POST["cancel"]) ) {
  header("Location: index.php");
  return;
}

if ( isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email"])
      && isset($_POST["headline"]) && isset($_POST["summary"]) ) {
        if ( (strlen($_POST["first_name"]) > 0) && (strlen($_POST["last_name"]) > 0)  &&
            (strlen($_POST["summary"]) > 0) && (strlen($_POST["headline"]) > 0) ) {

          $stmt = $pdo->prepare('INSERT INTO Profile
            (user_id, first_name, last_name, email, headline, summary)
            VALUES ( :uid, :fn, :ln, :em, :he, :su)');

          $stmt->execute(array(
            ':uid' => $_SESSION['user_id'],
            ':fn' => $_POST['first_name'],
            ':ln' => $_POST['last_name'],
            ':em' => $_POST['email'],
            ':he' => $_POST['headline'],
            ':su' => $_POST['summary'])
          );
          $_SESSION['success'] = "Your profile has been added.";
          header("Location: index.php");
          return;
      } else {
        $_SESSION["error"] = "All fields are required";
        header("Location: add.php");
        return;
      }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Santos Hernandez's Profile Add</title>
<!-- bootstrap.php - this is HTML -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
    crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Adding Profile for
  <?php
  if ( isset($_SESSION["name"]) ) {
    echo htmlentities($_SESSION["name"]);
  }
  ?></h1>
  <?php
    if ( isset($_SESSION['error']) ) {
      echo $_SESSION['error'];
      unset($_SESSION['error']);
  }
  ?>
<form method="post">
<p>First Name:
<input type="text" name="first_name" size="60"/></p>
<p>Last Name:
<input type="text" name="last_name" size="60"/></p>
<p>Email:
<input type="text" name="email" size="30"/></p>
<p>Headline:<br/>
<input type="text" name="headline" size="80"/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80"></textarea>
<p>
<input type="submit" value="Add New Entry">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</div>
</body>
</html>
