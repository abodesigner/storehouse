<?php
  ob_start();
  session_start();
    $pageTitle = 'Create New Item';
    include 'init.php';
    if(isset($_SESSION['user'])){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        die(print_r($_POST));

      }
?>
    <h1 class="text-center"><?php echo $pageTitle ?></h1>
    <div class="create-ad block">
      <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading"><?php echo $pageTitle ?></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-8">
                <!-- Start Ad Form -->
                <form class="form-horizontal main-form" action="<?php echo $_SERVER[PHP_SELF]; ?>" method="POST">
                    <!-- Start Name field -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="">Name</label>
                        <div class="col-sm-10 col-md-9">
                            <input type="text" name="name" class="form-control live" placeholder="Name" data-class=".live-title"/>
                        </div>
                    </div>
                    <!-- End Name field -->
                    <!-- Start Description field -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="">Description</label>
                        <div class="col-sm-10 col-md-9">
                            <input type="text" name="description" class="form-control live" placeholder="Description" data-class=".live-desc"/>
                        </div>
                    </div>
                    <!-- End Description field -->

                    <!-- Start Price field -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="">Price</label>
                        <div class="col-sm-10 col-md-9">
                            <input type="text" name="price" class="form-control live" placeholder="Price" data-class=".live-price"/>
                        </div>
                    </div>
                    <!-- End Price field -->

                    <!-- Start Country_Made field -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="">Country of Origin</label>
                        <div class="col-sm-10 col-md-9">
                            <input type="text" name="country" class="form-control" placeholder="Country of Origin"/>
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
                        <div class="col-sm-offset-3 col-sm-9">
                            <input type="submit" name="submit" value="Add Item" class="btn btn-primary btn-sm"/>
                        </div>
                    </div>
                    <!-- End Submit Button -->
                </form>
                <!-- End Ad Form -->
              </div>

              <!-- Start Ad Template -->
              <div class="col-md-4">
                <div class='thumbnail item-box live'>
                    <span class='price-tag'>
                      $<span class="live-price"></span>
                    </span>
                    <img class='img-responsive' src='themes/images/bike.jpeg' alt='bike'>
                    <div class='caption'>
                      <h3 class="live-title">Title</h3>
                      <p class="live-desc">Description</p>
                    </div>
                </div>
              </div>
              <!-- End Ad Template -->
            </div>
            <!-- Start Looping through Errors -->
            <?php
              if (!empty($formErrors)){
                foreach ($formErrors as $err) {
                  echo "<div class='alert alert-danger'> " . $err . "</div>";
                }
              }

            ?>
            <!-- End Looping through Errors -->
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

      ob_end_flush();
?>
