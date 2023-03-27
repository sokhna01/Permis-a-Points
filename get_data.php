<?php
// connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Permisapoints";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// retrieve the data based on the numeroP parameter
$numeroP = $_GET["numeroP"];

$stmt = mysqli_prepare($conn, "SELECT * FROM Automobilistes WHERE numeroPermis = ?");
mysqli_stmt_bind_param($stmt, "s", $numeroP);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// build a JSON response
$data = array();
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }
  $nbPoints = $data['nbPoints'];
}
$response = array("data" => $data);
echo json_encode($response);

// close the database connection
mysqli_close($conn);
?>
