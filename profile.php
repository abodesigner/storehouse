  <?php
  	session_start();
    $pageTitle = 'Profile';
  	include 'init.php';

    if(isset($_SESSION['user'])){
      // print_r($_SESSION);
      $getUserStm = $con->prepare("SELECT * FROM users WHERE Username = ?");
      $getUserStm->execute(array($sessionUser));
      $info = $getUserStm->fetch();

      $userid = $info['UserID'];
  ?>
      <h1 class="text-center">MY PROFILE</h1>
      <div class="information block">
        <div class="container">
          <div class="panel panel-primary">
            <div class="panel-heading">My Information</div>
            <div class="panel-body">
              <ul class="basic-info">
                <li>
                  <i class="fas fa-lock-open"></i>
                  <span>Name</span>: <?php echo $info['Username']; ?>
                </li>
                <li>
                  <i class="fas fa-envelope"></i>
                  <span>Email</span>: <?php echo $info['Email'];?>
                </li>
                <li>
                  <i class="fas fa-calendar-alt"></i>
                  <span>Registered Date</span>: <?php echo $info['Date'] ?>
                </li>
                <li>
                  <i class="fas fa-heart"></i>
                  <span>Favourite Categories</span>: <?php echo $userid; ?>
                </li>
              </ul>
              <a href="#" class="btn btn-danger">
                Edit Profile
              </a>
            </div>
          </div>
        </div>
      </div>

      <div id="my-items" class="my-ads block">
        <div class="container">
          <div class="panel panel-primary">
            <div class="panel-heading">My Items</div>
            <div class="panel-body">
            <?php
              $myItems = getAllRecords("*", "items", "WHERE Member_ID={$userid}", "AND Approve = 1", 'Item_ID','ASC');

              // $listItems = getItems('Member_ID', $userid, 1);
              if(!empty($myItems)){
                echo "<div class='row'>";
                  foreach ($myItems as $item) {
                  echo "<div class='col-md-3 col-sm-6'>";
                      echo "<div class='thumbnail item-box'>";
                          if($item['Approve'] == 0){ echo "<span class='approve-status'>waiting approved</span>"; }
                          echo "<span class='price-tag'>$" . $item['Price'] . "</span>";
                          echo "<img class='img-responsive' src='https://via.placeholder.com/350x150' alt='testImg' />";
                          echo "<div class='caption'>";
                            echo "<h3><a href='item-details.php?itemid=". $item['Item_ID'] ."'>" . $item['Name'] . "</a></h3>";
                            echo "<p>" . $item['Description'] . "</p>";
                            echo "<div class='date'>" .  $item['Add_Date'] . "</div>";
                          echo "</div>";
                      echo "</div>";
                  echo "</div>";
                  }
                echo "</div>";
            } else {
              echo "There is no Ads to show, Create <a href='newItem.php'>New Item</a>";
            }
            ?>
            </div>
          </div>
        </div>
      </div>

      <div id="my-comments" class="my-comments block">
        <div class="container">
          <div class="panel panel-primary">
            <div class="panel-heading">My Comments</div>
            <div class="panel-body">
              <?php
                  $myComments = getAllRecords("Comment", "comments", "where user_id= $userid", "", "Item_ID");
                  if(!empty($myComments)){
                    foreach ($myComments as $comment) {
                      echo "<p>" . $comment['Comment'] . "</p>";
                    }
                  } else {
                    echo "There is no comments to show";
                  }
              ?>
            </div>
          </div>
        </div>
      </div>

      <?php
        } else {
          header('Location: login.php');
          exit();
        }

        include $tpl . 'footer.inc.php';
  ?>
