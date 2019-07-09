<?php
require "pdo.php";
include_once "functions.php";
session_start();

checklogin();

$sql_select = "SELECT * FROM Profile WHERE profile_id = :prof_id";
$stmt_select = $pdo->prepare($sql_select);
$stmt_select->execute(array(":prof_id"=>$_GET["profile_id"]));
$row = $stmt_select->fetch(PDO::FETCH_ASSOC);

if ( isset($_POST["cancel"]) ) {
  header("Location: index.php");
  return;
}

if ( isset($_POST['delete']) ) {
  $sql_delete = "DELETE FROM Profile WHERE profile_id = :prof_id";
  $stmt_delete = $pdo->prepare($sql_delete);
  $stmt_delete->execute(array(":prof_id" => htmlentities($_POST['profile_id'])));
  $_SESSION['success'] = "The profile has been deleted.";
  header("Location: index.php");
  return;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Santos Hernandez's Delete</title>
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
<h1>Deleteing Profile</h1>
<form method="post" action="delete.php">
<p>First Name:
<?= htmlentities($row['first_name']) ?></p>
<p>Last Name:
<?= htmlentities($row['last_name']) ?></p>
<input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>"/>
<input type="submit" name="delete" value="Delete">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</div>
</body>
</html>
