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

$sql = "SELECT * FROM `test_unique` WHERE submit_date >= DATE_SUB(NOW(), INTERVAL 1 HOUR) group by test_id";
$result = $conn->query($sql);

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
      <div id="header" style="margin:30px auto;">
          <br />
          <center><h3>Tracked Patches</h3></center>
      </div>
     
    <div id="app" style="margin:100px auto;">
         <center>
              <table style="margin-left: 7%; width:20%">
  <tr>
    <th>Author</th>
    <th>Branch</th>
  </tr>
<?php
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    print("<tr>\n<td>".$row["test_user"]."</td>\n");
    print("<td>".'<a href="./tracker.php?test_id='.$row['test_id'].'">'.$row["test_branch"]."</a></td>\n</tr>\n");
  }
}
?>
</table>
      </center>
           
    </div>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hammerjs"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@next"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
</html>
