<?php

ini_set('display_errors', 'On');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  include "../includes/db_conf.php";

  $q = $_GET['q'];

  $sql = "SELECT * from movies where name like '%" . $q . "%' limit 3";
  $result = mysqli_query($conn, $sql);
  while($results = mysqli_fetch_assoc($result)) {
    ?>
    <a href="http://dsconlimited.net/movie/movie.php?movie=<?php echo $results['name']; ?>">
      <div class="" style="z-index: 1000; color: black; outline: none">
        <img src="http://dsconlimited.net/dsconlimitedmovies/<?php echo $results['cover']; ?>" width=30 height=30 style="border: solid transparent; border-radius: 7px"><?php echo $results['name']; ?>
        <br>
          <span style="font-size: 0.7em;line-height: 0px;font-weight: lighter;"><?php echo $results['overview']; ?></span>

      </div>
    </a>
    <?php
  }
}

 ?>
