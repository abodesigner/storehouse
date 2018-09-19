<?php include 'init.php'; ?>
    <div class="container">

      <div class="row">
      <?php
      if(isset($_GET['tagtitle'])){
        $tag = $_GET['tagtitle'];
        echo "<h1 class='text-center'>" . $tag . "</h1>";

        $TagItems = getAllRecords('*', 'items', "where Tags like '%$tag%'", "AND Approve = 1", "Item_ID");
          foreach($TagItems as $item) {
            echo "<div class='col-md-3 col-sm-6'>";
              echo "<div class='thumbnail item-box'>";
                echo "<span class='price-tag'>" . $item['Price'] . "</span>";
                echo "<img class='img-responsive' src='https://via.placeholder.com/350x150' alt='testImg' />";
                  echo "<div class='caption'>";
                    echo "<h3><a href='item-details.php?itemid=". $item['Item_ID'] ."'>" . $item['Name'] . "</a></h3>";
                    echo "<p>" . $item['Description'] . "</p>";
                    echo "<div class='date'>Date: " . $item['Add_Date'] . "</div>";
                  echo "</div>";
                echo "</div>";
              echo "</div>";
            }
        } else {
          echo "Error ... you can't view this page directly";
        }


      ?>
      </div>
    </div>


<?php include $tpl . 'footer.inc.php';?>
