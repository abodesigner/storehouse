<?php

    /*
    ===================================================
    == Items Page
    ===================================================
    */

    ob_start(); //Output Buffering start
    session_start();
    $pageTitle = 'Items';

    if(isset($_SESSION['Username'])){
        include 'init.php';
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        if ($do == 'Manage'){
            // Fetch all items from database.
            $stmt = $con->prepare("SELECT
                                        items.*,
                                        categories.name AS Category_Name,
                                        users.Username
                                    FROM
                                        items
                                    INNER JOIN
                                        categories
                                    ON
                                        categories.ID = items.Cat_ID
                                    INNER JOIN
                                        users
                                    ON
                                        users.UserID = items.Member_ID");
            $stmt->execute();
            $items = $stmt->fetchAll();
            ?>
            <h1 class="text-center">Manage Items</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table table table-bordered table-hover">
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Added Date</th>
                            <th>Category</th>
                            <th>Username</th>
                            <th>Control</th>
                        </tr>
                        <?php
                            foreach ($items as $item) {
                                echo "<tr>";
                                    echo "<td>" . $item['Item_ID']      . "</td>";
                                    echo "<td>" . $item['Name']         . "</td>";
                                    echo "<td>" . $item['Description']  . "</td>";
                                    echo "<td>" . $item['Price']        . "</td>";
                                    echo "<td>" . $item['Add_Date']     . "</td>";
                                    echo "<td>" . $item['Category_Name']. "</td>";
                                    echo "<td>" . $item['Username']     . "</td>";
                                    echo "<td>
                                        <a href='items.php?do=Edit&itemid="   . $item['Item_ID'] . "' class='btn btn-success'><i class='fas fa-pen'></i>Edit</a>
                                        <a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='far fa-trash-alt'></i> Delete </a>";

                                        if($item['Approve'] == 0){
                                            echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "
                                            'class='btn btn-info activate'><i class='fas fa-check'></i>Approve</a>";
                                        }
                                    echo "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
                <a href='items.php?do=Add' class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i>New Item<a>
            </div>

        <?php } elseif ($do == 'Add') { ?>
            <h1 class="text-center">Add New Item</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST">

                    <!-- Start Name field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Name</label>
                        <div class="col-sm-10 col-md-3">
                            <input
                                   type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="Name">
                        </div>
                    </div>
                    <!-- End Name field -->

                    <!-- Start Description field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Description</label>
                        <div class="col-sm-10 col-md-3">
                            <input
                                type="text"
                                name="description"
                                class="form-control"
                                placeholder="Description">
                        </div>
                    </div>
                    <!-- End Description field -->

                    <!-- Start Price field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Price</label>
                        <div class="col-sm-10 col-md-3">
                            <input
                                type="text"
                                name="price"
                                class="form-control"
                                placeholder="Price">
                        </div>
                    </div>
                    <!-- End Price field -->

                    <!-- Start Country_Made field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Country of Origin</label>
                        <div class="col-sm-10 col-md-3">
                            <input
                                type="text"
                                name="country"
                                class="form-control"
                                placeholder="Country of Origin">
                        </div>
                    </div>
                    <!-- End Country_Made field -->

                    <!-- Start Status field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Status</label>
                        <div class="col-sm-10 col-md-3">
                            <select name="status">
                                <option value="0">..</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Status field -->

                    <!-- Start Members field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Member</label>
                        <div class="col-sm-10 col-md-3">
                            <select name="member">
                                <option value="0">..</option>
                                <?php
                                    $st = $con->prepare("SELECT * FROM users");
                                    $st->execute();
                                    $users = $st->fetchAll();
                                    foreach ($users as $user) {
                                        echo "<option value='". $user['UserID'] ."'>" . $user['Username'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Members field -->

                    <!-- Start Categories field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Category</label>
                        <div class="col-sm-10 col-md-3">
                            <select name="category">
                                <option value="0">..</option>
                                <?php
                                    $stm = $con->prepare("SELECT * FROM categories");
                                    $stm->execute();
                                    $categories = $stm->fetchAll();
                                    foreach ($categories as $cat) {
                                        echo "<option value='". $cat['ID'] ."'>" . $cat['Name'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Categories field -->

                    <!-- Start Submit Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" name="submit" value="Add Item" class="btn btn-primary btn-sm">
                        </div>
                    </div>
                    <!-- End Submit Button -->
                </form>
            </div>

        <?php } elseif ($do == 'Insert') {

          //Check if the item come from post request method
          if($_SERVER['REQUEST_METHOD'] == 'POST'){

              echo "<h1 class='text-center'>Insert Item</h1>";
              echo "<div class='container'>";

              // Get Variables from form to insert them in database
              $name     = $_POST['name'];
              $desc     = $_POST['description'];
              $price    = $_POST['price'];
              $country  = $_POST['country'];
              $status   = $_POST['status'];
              $member   = $_POST['member'];
              $cat      = $_POST['category'];

              // Validate the form
              $FormErrors = array();
                if(empty($name)){
                    $FormErrors[] = "Name can't be <strong>empty</strong>";
                }

              if(empty($desc)){
                  $FormErrors[] = "Description can't be <strong>empty</strong>";
              }

              if(empty($price)){
                  $FormErrors[] = "Price can't be <strong>empty</strong>";
              }

              if(empty($country)){
                  $FormErrors[] = "Country can't be <strong>empty</strong>";
              }

              if($status == 0){
                  $FormErrors[] = "You must choose one <strong>status</strong>";
              }

              if($member == 0){
                  $FormErrors[] = "You must choose one <strong>member</strong>";
              }

              if($cat == 0){
                  $FormErrors[] = "You must choose one <strong>category</strong>";
              }
              // Loop into Errors Array & echo it
              foreach($FormErrors as $err) {
                  echo "<div class='alert alert-danger'>" . $err . '</div>';
              }
              // Check if there are no errors Proceed to Update operation
              if(empty($FormErrors)){
                // Insert New Item data into the database
                $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID)
                                       VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)");
                        $stmt->execute(array(
                            'zname'    => $name,
                            'zdesc'    => $desc,
                            'zprice'   => $price,
                            'zcountry' => $country,
                            'zstatus'  => $status,
                            'zcat'     => $cat,
                            'zmember'  => $member
                        ));

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " item inserted successfully</div>";

                redirectHome($theMsg,'back');
              }

          } else{
              echo "<div class='container'>";
                  // Open the Insert Page directly
                  $theMsg = "<div class='alert alert-danger'>You can not browse this page</div>";
                  redirectHome($theMsg,'back');
              echo "</div>";
          }
          echo "</div>";

        } elseif ($do == 'Edit') {

            // Check if the itemId From GET REGUEST is number
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :  0;

            $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID=?");
            $stmt->execute(array($itemid));
            $item = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($count > 0) { ?>
                <h1 class="text-center">Edit Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST">

                        <!-- Create input field hidden to save the itemid -->
                        <input type="hidden" name="itemid" value="<?php echo $itemid ?>">

                        <!-- Start Name field -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Name</label>
                            <div class="col-sm-10 col-md-3">
                                <input
                                       type="text"
                                       name="name"
                                       class="form-control"
                                       placeholder="Name"
                                       value="<?php echo $item['Name']?>">
                            </div>
                        </div>
                        <!-- End Name field -->

                        <!-- Start Description field -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Description</label>
                            <div class="col-sm-10 col-md-3">
                                <input
                                    type="text"
                                    name="description"
                                    class="form-control"
                                    placeholder="Description"
                                    value="<?php echo $item['Description']?>">
                            </div>
                        </div>
                        <!-- End Description field -->

                        <!-- Start Price field -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Price</label>
                            <div class="col-sm-10 col-md-3">
                                <input
                                    type="text"
                                    name="price"
                                    class="form-control"
                                    placeholder="Price"
                                    value="<?php echo $item['Price']?>">
                            </div>
                        </div>
                        <!-- End Price field -->

                        <!-- Start Country_Made field -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Country of Origin</label>
                            <div class="col-sm-10 col-md-3">
                                <input
                                    type="text"
                                    name="country"
                                    class="form-control"
                                    placeholder="Country of Origin"
                                    value="<?php echo $item['Country_Made']?>">
                            </div>
                        </div>
                        <!-- End Country_Made field -->

                        <!-- Start Status field -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Status</label>
                            <div class="col-sm-10 col-md-3">
                                <select name="status">
                                    <option value="1" <?php if( $item['Status'] == 1 ) { echo 'selected'; } ?>>New</option>
                                    <option value="2" <?php if( $item['Status'] == 2 ) { echo 'selected'; } ?>>Like New</option>
                                    <option value="3" <?php if( $item['Status'] == 3 ) { echo 'selected'; } ?>>Used</option>
                                    <option value="4" <?php if( $item['Status'] == 4 ) { echo 'selected'; } ?>>Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- End Status field -->

                        <!-- Start Members field -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Member</label>
                            <div class="col-sm-10 col-md-3">
                                <select name="member">
                                    <option value="0">..</option>
                                    <?php
                                        $st = $con->prepare("SELECT * FROM users");
                                        $st->execute();
                                        $users = $st->fetchAll();
                                        foreach ($users as $user) {
                                            echo "<option value='". $user['UserID'] ."'";
                                            if($item['Member_ID']== $user['UserID']){echo 'selected';}
                                            echo ">" . $user['Username'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Members field -->

                        <!-- Start Categories field -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Category</label>
                            <div class="col-sm-10 col-md-3">
                                <select name="category">
                                    <option value="0">..</option>
                                    <?php
                                        $stm = $con->prepare("SELECT * FROM categories");
                                        $stm->execute();
                                        $categories = $stm->fetchAll();
                                        foreach ($categories as $cat) {
                                            echo "<option value='". $cat['ID'] ."'";
                                            if ($item['Cat_ID']==$cat['ID']){echo 'selected';}
                                            echo ">" . $cat['Name'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Categories field -->

                        <!-- Start Submit Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" name="submit" value="Save" class="btn btn-info btn-lg">
                            </div>
                        </div>
                        <!-- End Submit Button -->
                    </form>

                    <?php  // Fetch all comments from database.
                    $stmt = $con->prepare("SELECT
                                              comments.*,users.Username AS Member
                                          FROM
                                              comments
                                          INNER JOIN
                                              users
                                          ON users.UserID = comments.user_id
                                          WHERE item_id=?");
                    $stmt->execute(array($itemid));
                    $rows = $stmt->fetchAll();

                    //check if no data i database
                    ?>

                    <h1 class="text-center">Manage Comments</h1>
                    <div class="table-responsive">
                      <table class="main-table table table-bordered table-hover">
                          <tr>
                              <th>Comment</th>
                              <th>Username</th>
                              <th>Added Date</th>
                              <th>Control</th>
                          </tr>
                          <?php
                              foreach ($rows as $row) {
                                  echo "<tr>";
                                      echo "<td>" . $row['Comment'] . "</td>";
                                      echo "<td>" . $row['Member'] . "</td>";
                                      echo "<td>" . $row['Comment_date'] . "</td>";
                                      echo "<td>
                                              <a href='comments.php?do=Edit&cid="   . $row['C_ID'] . "' class='btn btn-success'><i class='fas fa-pen'></i>Edit</a>
                                              <a href='comments.php?do=Delete&cid=" . $row['C_ID'] . "' class='btn btn-danger confirm'><i class='far fa-trash-alt'></i> Delete </a>";

                                      if($row['Status'] == 0){
                                          echo "<a href='comments.php?do=Approve&cid=" . $row['C_ID'] . "'
                                          class='btn btn-info activate'><i class='fas fa-check'></i> Approve</a>";
                                      }

                                      echo "</td>";
                                  echo "</tr>";
                              }
                          ?>
                      </table>
                    </div>

                  </div>

            <?php } else {

                    echo "<div class='container'>";
                        $theMsg = "<div class='alert alert-danger'>There is no ID with this number</div>";
                        redirectHome($theMsg);
                    echo "</div>";
                }
        } elseif ($do == 'Update') {

            echo "<h1 class='text-center'>Update Item</h1>";

            echo "<div class='container'>";
                //Check if the item come from post request method
                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    // Get variables form to insert in database while clicking in save btn in edit page
                    $id      = $_POST['itemid'];
                    $name    = $_POST['name'];
                    $desc    = $_POST['description'];
                    $price   = $_POST['price'];
                    $country = $_POST['country'];
                    $status  = $_POST['status'];
                    $cat     = $_POST['category'];
                    $member  = $_POST['member'];


                    // Validate the form
                    $FormErrors = array();
                      if(empty($name)){
                          $FormErrors[] = "Name can't be <strong>empty</strong>";
                      }

                    if(empty($desc)){
                        $FormErrors[] = "Description can't be <strong>empty</strong>";
                    }

                    if(empty($price)){
                        $FormErrors[] = "Price can't be <strong>empty</strong>";
                    }

                    if(empty($country)){
                        $FormErrors[] = "Country can't be <strong>empty</strong>";
                    }

                    if($status == 0){
                        $FormErrors[] = "You must choose one <strong>status</strong>";
                    }

                    if($member == 0){
                        $FormErrors[] = "You must choose one <strong>member</strong>";
                    }

                    if($cat == 0){
                        $FormErrors[] = "You must choose one <strong>category</strong>";
                    }
                    // Loop into Errors Array & echo it
                    foreach($FormErrors as $err) {
                        echo "<div class='alert alert-danger'>" . $err . '</div>';
                    }
                    // Check if there are no errors Proceed to Update operation
                    if(empty($FormErrors)){

                        // Update the database with these information
                        $stmt = $con->prepare("UPDATE
                                                    items
                                               SET
                                                    Name = ?,
                                                    Description = ?,
                                                    Price = ?,
                                                    Country_Made = ?,
                                                    Status = ?,
                                                    Cat_ID = ?,
                                                    Member_ID = ?

                                               WHERE
                                                    Item_ID = ? ");

                        $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $id));

                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " item updated successfully</div>";
                        redirectHome($theMsg,'back');
                    }
                } else{

                    echo "<div class='container'>";
                        $theMsg = "<div class='alert alert-danger'>Sorry, you can not view this page directly</div>";
                        redirectHome($theMsg,'back');
                    echo "</div>";

                }
            echo "</div>";

        } elseif ($do == 'Delete') { // Delete Item Page
            echo "<h1 class='text-center'>Delete Item</h1>";
            echo "<div class='container'>";
                // Check if the itemId From GET REGUEST is number
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :  0;

                $check = checkItem("Item_ID", "items", $itemid);

                //If there is Id
                if ($check > 0) {
                    $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zitem");
                    $stmt->bindParam(":zitem", $itemid);
                    $stmt->execute();

                    // Success Msg
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " item deleted successfully</div>";
                    redirectHome($theMsg,'back');
                    } else {

                    echo "<div class='container'>";
                        $theMsg = "<div class='alert alert-danger'> This Id not exist </div>";
                        redirectHome($theMsg);
                    echo "</div>";
                }
            echo "</div>";
        } elseif ($do == 'Approve') {
            echo "<h1 class='text-center'>Approve Item</h1>";
            echo "<div class='container'>";
                // Check if the itemId From GET REQUEST is number
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :  0;

                $check = checkItem("Item_ID", "items", $itemid);

                //If there is Id
                if ($check > 0) {
                    $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
                    $stmt->execute(array($itemid));

                    // Success Msg
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " item approved successfully</div>";
                    redirectHome($theMsg,'back');
                    } else {

                    echo "<div class='container'>";
                        $theMsg = "<div class='alert alert-danger'> This Id not exist </div>";
                        redirectHome($theMsg);
                    echo "</div>";
                }
            echo "</div>";
        }

        include $tpl . 'footer.inc.php';

    } else {
        header('Location: index.php');
        exit();
    }

    ob_end_flush();

?>
