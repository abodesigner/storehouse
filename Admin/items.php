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

            echo "Welcome Items Page";

        } elseif ($do == 'Add') { ?>

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
              // Loop into Errors Array & echo it
              foreach($FormErrors as $err) {
                  echo "<div class='alert alert-danger'>" . $err . '</div>';
              }
              // Check if there are no errors Proceed to Update operation
              if(empty($FormErrors)){
                // Insert New Item data into the database
                $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country_Made, Status, Add_Date)
                                       VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now())");
                        $stmt->execute(array(
                            'zname'    => $name,
                            'zdesc'    => $desc,
                            'zprice'   => $country,
                            'zcountry' => $name,
                            'zstatus'  => $status
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
            // code...
        } elseif ($do == 'Update') {
            // code...
        } elseif ($do == 'Delete') {
            // code...
        } elseif ($do == 'Approve') {
            // code...
        }

        include $tpl . 'footer.inc.php';

    } else {
        header('Location: index.php');
        exit();
    }

    ob_end_flush();

?>
