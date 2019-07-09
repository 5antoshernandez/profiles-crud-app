<?php
require "pdo.php";
$profile_id = $_GET['profile_id'];
$sql = "SELECT * FROM Profile WHERE profile_id = :prof_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
  ":prof_id"=>$profile_id)
);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
<title>Santos Hernandez's Resume Registry</title>
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
<h1>Profile Information</h1>
<?php
echo "<p>First Name: " . htmlentities($row['first_name']) . "</p>";
echo "<p>Last Name: " . htmlentities($row['last_name']) . "</p>";
echo "<p>Email: " . htmlentities($row['email']) . "</p>";
echo "<p>Headline: <br/>" . htmlentities($row['headline']) . "</p>";
echo "<p>Summary:<br/>" . htmlentities($row['summary']) . "</p><br />";
?>
<a href="index.php">Done</a>
</body>
</html>
