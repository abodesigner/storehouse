<?php
  session_start();
  $pageTitle = 'Create New Item';
  include 'init.php';

  if(isset($_SESSION['user'])){

    if($_SERVER['REQUEST_METHOD']=='POST'){

      $formErrors = array();

      $name     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
      $desc     = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
      $price    = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
      $country  = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
      $status   = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
      $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

      if(strlength($name) < 4){
        $formErrors = "Item name must be 4 chars at least";
      }

      if(strlength($desc) < 10){
        $formErrors = "Item desc must be 10 chars at least";
      }

      if(strlength($country) < 2){
        $formErrors = "Item name must be 2 chars";
      }

      if(empty($price)){
        $formErrors = "Item price must not be empty";
      }

      if(empty($status)){
        $formErrors = "Item status must not be empty";
      }

      if(strlength($category)){
        $formErrors = "Item category must not be empty";
      }
    }

  ?>

    <h1 class="text-center"><?php echo $pageTitle; ?></h1>
    <div class="create-item block">
      <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading"><?php echo $pageTitle; ?></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-8">
                <!-- Start Form -->
                <form class="form-horizontal main-form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                    <!-- Start Name field -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="">Name</label>
                        <div class="col-sm-10 col-md-9">
                            <input
                                   type="text"
                                   name="name"
                                   class="form-control live-name"
                                   placeholder="Name">
                        </div>
                    </div>
                    <!-- End Name field -->

                    <!-- Start Description field -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="">Description</label>
                        <div class="col-sm-10 col-md-9">
                            <input
                                type="text"
                                name="description"
                                class="form-control live-desc"
                                placeholder="Description">
                        </div>
                    </div>
                    <!-- End Description field -->

                    <!-- Start Price field -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="">Price</label>
                        <div class="col-sm-10 col-md-9">
                            <input
                                type="text"
                                name="price"
                                class="form-control live-price"
                                placeholder="Price">
                        </div>
                    </div>
                    <!-- End Price field -->

                    <!-- Start Country_Made field -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="">Country of Origin</label>
                        <div class="col-sm-10 col-md-9">
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
                        <label class="col-sm-3 control-label" for="">Status</label>
                        <div class="col-sm-10 col-md-9">
                            <select name="status">
                                <option value="">..</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Status field -->

                    <!-- Start Categories field -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="">Category</label>
                        <div class="col-sm-10 col-md-9">
                            <select name="category">
                                <option value="">..</option>
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
                        <div class="col-sm-offset-3 col-sm-10">
                            <input type="submit" name="submit" value="Add Item" class="btn btn-primary btn-sm">
                        </div>
                    </div>
                    <!-- End Submit Button -->
                </form>
              </div>
              <div class="col-md-4">
                <div class='thumbnail item-box live-preview'>
                    <span class='price-tag'>0</span>
                    <img class='img-responsive' src='mac.jpeg' alt='mac' />
                    <div class='caption'>
                      <h3>Mac</h3>
                      <p>high super computer</p>
                    </div>
                </div>
              </div>
            </div>
            <!-- Start Looping through errors -->
            <?php

            if(!empty($formErrors)){
              foreach ($formErrors as $err) {
                echo  "<div class='alert alert-danger'>" . $err . "</div>";
              }
            }

            ?>
            <!-- End Looping through errors -->
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
