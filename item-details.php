<?php
  ob_start();
  session_start();
  $pageTitle = 'Show Item';
  include 'init.php';

  // Check if the itemId From GET REGUEST is number
  $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :  0;
  $stmt = $con->prepare("SELECT
                                items.*,
                                categories.Name,
                                users.Username
                         FROM
                                items
                         INNER JOIN
                                categories
                         ON
                                categories.ID=items.Cat_ID
                         INNER JOIN
                                users
                         ON
                                users.UserID = items.Member_ID
                         WHERE
                                Item_ID=? AND Approve = 1");

  $stmt->execute(array($itemid));
  $count = $stmt->rowCount();
  if($count > 0){
      $item = $stmt->fetch();
      ?>

      <h1 class="text-center"><?php echo $item['Name']; ?></h1>
      <div class="container">
        <div class="row">
            <div class="col-md-2">
              <img src="themes/images/bike.jpeg" alt="bike" class="img-responsive img-thumbnail center-block">
            </div>
            <div class="col-md-10 item-info">
              <h2><?php echo $item['Name']; ?></h2>
              <p><?php echo $item['Description']; ?></p>
              <ul class="list-unstyled">
                <li>
                  <i class="fas fa-calendar-alt"></i>
                  <span>Added Date</span>:<?php echo $item['Add_Date']; ?>
                </li>
                <li>
                  <span>Price</span>: <?php echo '$'. $item['Price']; ?>
                </li>
                <li>
                  <i class="glyphicon glyphicon-map-marker"></i>
                  <span>Made In</span>:<?php echo $item['Country_Made']; ?>
                </li>
                <li>
                  <i class="glyphicon glyphicon-tag"></i>
                  <span>Category</span>:<a href="categories.php?pageid=<?php  echo $item['Cat_ID'] ?> "><?php echo $item['Name']; ?></a>
                </li>
                <li>
                  <i class="glyphicon glyphicon-user"></i>
                  <span>Added By</span>:<a href="#"><?php echo $item['Username']; ?></a>
                </li>
                <li class="tags-items">
                  <i class="glyphicon glyphicon-tag"></i>
                  <span>Tags</span>:
                  <?php

                    // Convert the string into array of string using explode function
                    $allTags = explode("," , $item['Tags']);
                      foreach ($allTags as $tag) {
                          $trimmedtag = str_replace(" ", "", $tag);
                          $lowertag = strtolower($trimmedtag);
                          if(!empty($trimmedtag)){
                              echo "<a href='tags.php?tagtitle={$lowertag}'>" . $tag . "</a>";
                          } else {
                            echo "No Tags";
                          }

                      }


                  ?>

                </li>
              </ul>
            </div>
        </div>
        <hr class="custom-hr">
        <?php if(isset($_SESSION['user'])) {    ?>
          <!-- Start User Comment -->
          <div class="row">
            <div class="col-md-offset-3">
              <div class="user-comment">
                <h3>Add Your Comments</h3>
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID']  ?>" method="POST">
                  <textarea name="comment" class="form-control" placeholder="write comment" required></textarea>
                  <input type="submit" value="Add Comment" class="btn btn-info">
                </form>
                <?php
                      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                        $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                        $userid  = $_SESSION['uid'];
                        $itemid  = $item['Item_ID'];

                        if(!empty($comment)){

                            $stmt = $con->prepare("INSERT INTO
                                                          comments(Comment, Status, Comment_date, item_id, user_id)
                                                   VALUES(:zcomment,0,NOW(),:zitemid,:zuserid)");
                            $stmt->execute(array(
                              'zcomment'=> $comment,
                              'zuserid' => $userid,
                              'zitemid' => $itemid
                            ));

                            if($stmt){

                              echo "<div class='alert alert-success custom-comment'>Comment Added Successfully</div>";
                            }
                        }
                      }
                 ?>
              </div>
            </div>
          </div>
          <!-- End User Comment -->
        <?php } else {
          echo "<a href='login.php'>Login Or Signup</a> to Add comments";
        }?>
        <hr class="custom-hr">
        <?php
            // Fetch all comments from database.
            $stmt = $con->prepare("SELECT
                                      comments.*, users.Username AS Member
                                  FROM
                                      comments
                                  INNER JOIN
                                      users
                                  ON
                                      users.UserID = comments.user_id
                                  WHERE
                                      item_id = ?
                                  ORDER BY
                                      C_ID DESC");
            $stmt->execute(array($item['Item_ID']));
            $commentRows = $stmt->fetchAll();

        ?>

          <?php
          foreach ($commentRows as $com) { ?>
            <div class="user-comments">
              <div class='row'>
                <div class='col-sm-2 text-center'>
                  <img src="themes/images/user.png" alt="user" class="img-responsive img-circle img-thumbnail center-block">
                  <?php echo $com['Member']; ?>
                </div>
                <div class='col-sm-10'>
                  <p class="lead"><?php echo $com['Comment']; ?></p>
                </div>
              </div>
            </div>
            <hr class="custom-hr">
          <?php } ?>
        </div>
      </div>

  <?php  } else {
    echo "<div class='alert alert-danger'>This Item's ID is not exist Or waiting approval</div>";
  }

    include $tpl . 'footer.inc.php';
    ob_end_flush();
?>
