
<?php
session_start();
include "pdo.php";
require "functions.php";

$sql = "SELECT profile_id, headline, first_name, last_name FROM Profile";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<div class="container">
<h1>Santos Hernandez's Resume Registry</h1>
<?php
if ( isset($_SESSION['success']) ) {
    echo "<p>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']);
}
?>

<?php
if ( isset($_SESSION["user_id"]) && isset($_SESSION["name"]) ) {
    echo '<p><a href="logout.php">Logout</a></p>';
} else {
    echo '<p><a href="login.php">Please log in</a></p>';
}
echo '<table border="1">';
echo "<tr><th>Name</th><th>Headline</th><th>Action</th><tr>";
if ( ! $rows === FALSE ) {
      foreach ($rows as $row ) {
        echo '<tr>';
        echo '<td><a href="view.php?profile_id=' . $row['profile_id'] . '">';
        echo htmlentities($row['first_name']) . " " . htmlentities($row["last_name"]);
        echo '</a></td>';
        echo '<td>'.htmlentities($row["headline"]).'</td>';
        echo '<td><a href="edit.php?profile_id=' . htmlentities($row['profile_id']) . '">';
        echo 'Edit ' . "</a>";
        echo '<a href="delete.php?profile_id=' . htmlentities($row['profile_id']) . '">';
        echo 'Delete' . "</a></td>";
        echo '</tr>';
      }
}
echo "</table>";
if ( isset($_SESSION["user_id"]) && isset($_SESSION["name"]) ) {
    echo '<a href="add.php" label="Add New Entry">Add New Entry</a></p>';
}
?>

<p>
<b>Note:</b> Your implementation should retain data across multiple
logout/login sessions.  This sample implementation clears all its
data periodically - which you should not do in your implementation.
</p>
</div>
</body>
</html>
