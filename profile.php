  <?php
  	session_start();
    $pageTitle = 'Profile';
  	include 'init.php';

    if(isset($_SESSION['user'])){

      $getUserStm = $con->prepare("SELECT * FROM users WHERE Username = ?");
      $getUserStm->execute(array($sessionUser));
      $info = $getUserStm->fetch();

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
                  <span>Favourite Categories</span>: <?php echo $info['UserID']; ?>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="my-ads block">
        <div class="container">
          <div class="panel panel-primary">
            <div class="panel-heading">My Ads</div>
            <div class="panel-body">
                <?php
                      $listItems = getItems('Member_ID', $info['UserID']);
                      if(!empty($listItems)){
                        echo "<div class='row'>";
                          foreach ($listItems as $item) {
                          echo "<div class='col-md-3 col-sm-6'>";
                              echo "<div class='thumbnail item-box'>";
                                  echo "<span class='price-tag'>" . $item['Price'] . "</span>";
                                  echo "<img class='img-responsive' src='https://via.placeholder.com/350x150' alt='testImg' />";
                                  echo "<div class='caption'>";
                                    echo "<h3>" . $item['Name'] . "</h3>";
                                    echo "<p>" . $item['Description'] . "</p>";
                                  echo "</div>";
                              echo "</div>";
                          echo "</div>";
                          }
                        echo "</div>";
                    } else {
                      echo "There is no Ads to show, Create <a href='newad.php'>New Ad<a>";
                    }
                ?>
            </div>
          </div>
        </div>
      </div>

      <div class="my-comments block">
        <div class="container">
          <div class="panel panel-primary">
            <div class="panel-heading">My Comments</div>
            <div class="panel-body">
              <?php
              $stmt = $con->prepare("SELECT Comment FROM comments WHERE user_id=?");
              $stmt->execute(array($info['UserID']));
              $comments = $stmt->fetchAll();

              if(!empty($comments)){
                foreach ($comments as $c) {
                  echo "<p>" . $c['Comment'] . "</p>";
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
