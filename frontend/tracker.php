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

if(!isset($_GET['test_id'])) {
    die("Please provide a test_id");
}
$testid = $_GET['test_id'];

$sql = "SELECT * FROM `test_unique` WHERE `test_id` = '".$conn->real_escape_string ($_GET['test_id'])."' LIMIT 1";
//die($sql);
$result = $conn->query($sql);
$sprt = false;
$sprt60 = false;
$logistic = false;

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $branch = $row["test_branch"];
    $user = $row["test_user"];
    $type = $row["test_type_text"];
    $elo0 = floatval($row["elo0"]);
    if($elo0 <= -0.5) $logistic = true;
    if(strpos($type, "sprt") !== false) $sprt = 1;
    if($sprt && strpos($type, "60") !== false) $sprt60 = 1;
    //echo $row["total"]. "," . $row["wins"]. "," . $row["losses"]. "," . $row["draws"]."," . $row["llr"]."," . round($row["elo"],3). "<br>";
  }
} else {
   $conn->close();
   die("Invalid test_id");
}
//print($user);
$conn->close();
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Patch tracker</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
  </head>
  <body>
      <div id="header">
          <br />
          <br />
          <br />
          <center>Statistics for patch <a href="https://tests.stockfishchess.org/tests/view/<?php print($testid)?>"><?php print($branch); ?></a> by <?php print($user)?></a></center>
      </div>
    <div id="app">
      <div class="container">
        <div class="my-5">
          <form v-on:submit.prevent="getData">
            <div class="row">
            </div>
          </form>
        </div>
        <div class="my-5">
          <canvas id="myChart"></canvas>
        </div>
          
          <div class="input-group" style="justify-content: end;">
                                <button class="btn btn-outline-secondary" type="submit" onclick="resetZoom()">Reset Zoom Level</button>
                            </div>
      </div>
    </div>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hammerjs"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@next"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
  <script src="sprt.js"></script>
  <script id="helper" data-name="<?php
   if($sprt60) echo "sprt60";
   else if($sprt) echo "sprt";
   else echo "nt";
   if($logistic) echo "_log";
?>" src="main.js"></script>
</html>
