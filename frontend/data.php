<?php
$servername = "localhost";
$username = "stockfish";
$password = "REMOVED";
$dbname = "stockfish";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['test_id'])) {
    die("Please provide a test_id");
}

$sql = "SELECT * FROM `tests` WHERE `test_id` = '" . $conn->real_escape_string($_GET['test_id']) . "' ORDER BY submit_id DESC LIMIT 25000";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo $row["total"] . "," . $row["wins"] . "," . $row["losses"] . "," . $row["draws"] . "," . $row["llr"] . "," . round($row["elo"], 3) . "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
