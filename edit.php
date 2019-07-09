<?php
require "pdo.php";
include_once "functions.php";
session_start();

checklogin();

$profile_id = $_GET["profile_id"];

$sql_select = "SELECT * FROM Profile WHERE profile_id = :prof_id";
$stmt_select = $pdo->prepare($sql_select);
$stmt_select->execute(array(":prof_id"=>$_GET["profile_id"]));
$row = $stmt_select->fetch(PDO::FETCH_ASSOC);

if ( isset($_POST["cancel"]) ) {
  header("Location: index.php");
  return;
}

if ( isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email"])
      && isset($_POST["headline"]) && isset($_POST["summary"]) ) {
        if ( strpos($_POST["email"], "@") === FALSE ) {
            $_SESSION["error"] = "Email address must contain @";
            header("Location: edit.php?profile_id=$profile_id");
            return;
        } else {
          $stmt = $pdo->prepare('UPDATE Profile SET user_id = :uid, first_name = :fn,
            last_name = :ln, email = :em, headline = :he, summary = :su
            WHERE profile_id = :prof_id');

          $stmt->execute(array(
            ':uid' => $_SESSION['user_id'],
            ':fn' => $_POST['first_name'],
            ':ln' => $_POST['last_name'],
            ':em' => $_POST['email'],
            ':he' => $_POST['headline'],
            ':su' => $_POST['summary'],
            ':prof_id' => $_GET['profile_id'])
          );
          $_SESSION['success'] = "Your profile has been updated.";
          header("Location: index.php");
          return;
        }
}


?>

<!DOCTYPE html>
<html>
<head>
<title>Santos Hernandez's Profile Edit</title>
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
<h1>Editing Profile for
  <?php
  if ( isset($_SESSION["name"]) ) {
    echo htmlentities($_SESSION["name"]);
  }
  ?></h1>

<?php
  if ( isset($_SESSION["error"]) ) {
      echo $_SESSION["error"];
      unset($_SESSION["error"]);
  }
?>
<form method="post">
<p>First Name:
<input type="text" name="first_name" value="<?= htmlentities($row['first_name']); ?>" size="60"/></p>
<p>Last Name:
<input type="text" name="last_name" value="<?= htmlentities($row['last_name']); ?>" size="60"/></p>
<p>Email:
<input type="text" name="email" id="email" value="<?= htmlentities($row['email']); ?>" size="30"/></p>
<p>Headline:<br/>
<input type="text" name="headline" value="<?= htmlentities($row['headline']); ?>" size="80"/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80"><?= htmlentities($row['summary']); ?></textarea>
<p>
<input type="submit" value="Save">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</div>
</body>
</html>
