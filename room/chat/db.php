<?php
// getting config file
require("db-config.php");

// Create connection
$con=mysqli_connect(SQL_HOST,SQL_USER,SQL_PASS,SQL_DB);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else {
echo "";
}
?>
