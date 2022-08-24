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

$sql = "SELECT * FROM `test_unique` WHERE submit_date >= DATE_SUB(NOW(), INTERVAL 1 HOUR) group by test_id ORDER BY `test_type` DESC, `llr` DESC";
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
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 mb-3 text-center">
                <a href="./index.php" class="display-4">Tracked Patches</a>
            </div>
            <div class="col-12 mb-3">
                <input class="form-control" type="text" id="filter-table" placeholder="Filter by ID, author or branch name">
            </div>
            <div class="col-12 mb-3 table-responsive">
                <table class="table table-sm table-hover" id="patches-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Author</th>
                            <th>Branch</th>
                            <th>LLR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // output data of each row
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?= $row["test_id"] ?></td>
                                    <td><?= $row["test_user"] ?></td>
                                    <td>
                                        <a href="./tracker.php?test_id=<?= $row['test_id'] ?>"><?= $row["test_branch"] ?>
                                    </td>
                                    <td><?= ($row["test_type"] === "1") ? round($row["llr"], 2) : "" ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
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
<script>
document.getElementById('filter-table').addEventListener('keyup', filterTable, false);

function filterTable(event) {
    const filter = event.target.value.toUpperCase();
    const rows = document.getElementById("patches-table").rows;

    for (let i = 1; i < rows.length; i++) {
        const idCol = rows[i].cells[0].textContent.toUpperCase();
        const authorCol = rows[i].cells[1].textContent.toUpperCase();
        const branchCol = rows[i].cells[2].textContent.toUpperCase();
        if (idCol.indexOf(filter) > -1 || authorCol.indexOf(filter) > -1 || branchCol.indexOf(filter) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}
</script>

</html>
