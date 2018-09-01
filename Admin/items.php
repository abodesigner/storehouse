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
                                   required
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
                                required
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
            // code...
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
