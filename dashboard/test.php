<?php

ini_set('display_errors', 1);

include '../includes/stats_db.php';

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

$username = "fabian";

$datearray = $userdataarray = array();

$sql = "SELECT DAY(date) AS Day, data FROM internetusage WHERE username = '" . $username . "' ORDER BY id DESC LIMIT 7";
$results = mysqli_query($conn, $sql);
while ($userdata = mysqli_fetch_assoc($results)) {
  $day = $userdata['Day'];
  $data = $userdata['data'];

  array_push($datearray, $day);
  array_push($userdataarray, $data);
}

$datearray = json_encode($datearray);
$userdataarray = json_encode($userdataarray);

?>

<canvas id="userdata" width="800" height="450"></canvas>

<link rel="stylesheet" href="css/chartjs.min.css">
<script src="js/chartjs.min.js" charset="utf-8"></script>

<script>
  new Chart(document.getElementById("line-chart"), {
    type: 'line',
    data: {
      labels: <?php echo $datearray; ?>,
      datasets: [{
        data: <?php echo $userdataarray; ?>,
        label: "Africa",
        borderColor: "#3e95cd",
        fill: false
      }]
    },
    options: {
      title: {
        display: true,
        text: 'World population per region (in millions)'
      }
    }
  });
</script>