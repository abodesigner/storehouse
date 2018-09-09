<?php include 'init.php'; ?>
    <div class="container">
      <h1 class="text-center"><?php echo str_replace('-',' ',$_GET['pagename'])?></h1>
      <div class="row">
        <?php
          $catid = str_replace('-',' ',$_GET['pageid']);
          $listItems = getItems($catid);
              foreach ($listItems as $item) {
              echo "<div class='col-md-4 col-sm-6'>";
                  echo "<div class='thumbnail'>";
                      echo "<img src='https://via.placeholder.com/350x150' alt='testImg' />";
                  echo "</div>";
              echo "</div>";
            }
        ?>
      </div>
    </div>


<?php include $tpl . 'footer.inc.php';?>
