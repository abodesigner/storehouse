<?php
    /*
    ===================================================
    == Categories Page
    ===================================================
    */
    ob_start(); //Output Buffering start
    session_start();
    $pageTitle = 'Categories';
    if(isset($_SESSION['Username'])){
        include 'init.php';
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        if ($do == 'Manage'){
            $sort = 'ASC';
            $sort_arr = array('ASC','DESC');
            if( isset($_GET['sort']) && in_array($_GET['sort'], $sort_arr)){
                $sort = $_GET['sort'];
            }
            $stmt2 = $con->prepare("SELECT * FROM categories WHERE Parent = 0 ORDER BY Ordering $sort");
            $stmt2->execute();
            $categoriesList = $stmt2->fetchAll(); ?>

            <h1 class="text-center">Manage Categories</h1>
            <div class="container categories">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Manage Categories
                        <div class="option pull-right">
                            <i class="fas fa-sort"></i> Ordering:
                            [<a class="<?php if($sort == 'ASC') { echo 'active'; }?>" href="?sort=ASC"><i class="fas fa-long-arrow-alt-up"></i>ASC</a>
                            <a class="<?php if($sort == 'DESC') { echo 'active'; }?>" href="?sort=DESC"><i class="fas fa-long-arrow-alt-down"></i>DESC</a>]
                            <i class="fas fa-eye"></i>View:
                            [<span class="active" data-view="full">Full</span> |
                            <span data-view="classic">Classic</span>]
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                            foreach ($categoriesList as $cat) {
                                echo "<div class='cat'>";
                                    echo "<div href='#' class='hidden-buttons'>";
                                        echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-info'><i class='fas fa-pen'></i>Edit</a>";
                                        echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fas fa-minus-circle'></i>Delete</a>";
                                    echo "</div>";
                                    echo '<h3>'. $cat['Name'] . '</h3>';

                                    echo "<div class='full-view'>";
                                        echo '<p>';
                                          if(empty($cat['Description'])){echo 'This Category has no description';} else {echo $cat['Description'];}
                                        echo '</p>';
                                        if($cat['Visibility'] == 1){ echo "<span class='general sp-visibilty'><i class='fas fa-eye-slash'></i>Hidden</span>"; }
                                        if($cat['Allow_Comment'] == 1){ echo "<span class='general sp-commenting'><i class='fas fa-times'></i>Disabled Comment</span>"; }
                                        if($cat['Allow_Ads'] == 1){ echo "<span class='general sp-ads'><i class='fas fa-ban'></i>No Ads</span>"; }

                                        // Get the Child category
                                        $child_categories = getAllRecords("*", "categories", "WHERE Parent = {$cat['ID']}", "", "ID","ASC");
                                          if (!empty($child_categories)) {
                                            echo "<h5 class='child-head'>Child Categories :</h5>";
                                            echo "<ul class='list-unstyled child-cats'>";
                                              foreach ($child_categories as $c) {
                                                echo "<li class='child-link'>";
                                                  echo "<a href='categories.php?do=Edit&catid=" . $c['ID'] . "'>". $c['Name'] . "</a>";
                                                  echo " <a href='categories.php?do=Delete&catid=" . $c['ID'] . "' class='show-delete confirm'>Delete</a>";
                                                echo "</li>";
                                              }
                                            echo "</ul>";
                                            }
                                    echo "</div>";
                                echo "</div>";
                                echo "<hr>";
                                  }

                    ?>
                    </div>
                </div>
                <a href="categories.php?do=Add" class="btn btn-primary"><i class="fas fa-plus"></i>New Category</a>
            </div>

        <?php } elseif ($do == 'Add') { // Add Html Code ?>

            <h1 class="text-center">Add New Category</h1>

            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST">
                    <!-- Start Name field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Name</label>
                        <div class="col-sm-10 col-md-3">
                            <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Category Name">
                        </div>
                    </div>
                    <!-- End Name field -->
                    <!-- Start Description field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Description</label>
                        <div class="col-sm-10 col-md-3 field">
                            <input type="text" name="description" class="form-control" placeholder="Describe Category">
                        </div>
                    </div>
                    <!-- End Description field -->
                    <!-- Start Category Type -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Have Parent</label>
                        <div class="col-sm-10 col-md-3">
                            <select class="" name="parent">
                            <option value="0">None</option>
                            <?php
                                $categories = getAllRecords("*", "categories", "where Parent = 0", "", "ID", "ASC");
                                foreach ($categories as $cat) {
                                    echo "<option value='". $cat['ID'] ."'>" . $cat['Name'] . "</option>";
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Category Type -->

                    <!-- Start Ordering field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Ordering</label>
                        <div class="col-sm-10 col-md-3">
                            <input type="number" name="ordering" class="form-control" placeholder="Arrange your category">
                        </div>
                    </div>
                    <!-- End Ordering field -->
                    <!-- Start Visibility field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Visible</label>
                        <div class="col-sm-10 col-md-3">
                            <div>
                                <input id="v-yes" type="radio" name="visibility" value="0" checked>
                                <label for="v-yes">Yes</label>
                            </div>
                            <div>
                                <input id="v-no" type="radio" name="visibility" value="1">
                                <label for="v-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Visibility field -->
                    <!-- Start Commenting field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Allow Commenting</label>
                        <div class="col-sm-10 col-md-3">
                            <div>
                                <input id="c-yes" type="radio" name="commenting" value="0" checked>
                                <label for="c-yes">Yes</label>
                            </div>
                            <div>
                                <input id="c-no" type="radio" name="commenting" value="1">
                                <label for="c-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Commenting field -->
                    <!-- Start Ads field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Allow Ads</label>
                        <div class="col-sm-10 col-md-3">
                            <div>
                                <input id="a-yes" type="radio" name="ads" value="0" checked>
                                <label for="a-yes">Yes</label>
                            </div>
                            <div>
                                <input id="a-no" type="radio" name="ads" value="1">
                                <label for="a-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Ads field -->
                    <!-- Start Submit Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
                        </div>
                    </div>
                    <!-- End Submit Button -->
                </form>
            </div>

        <?php

        } elseif ($do == 'Insert') {

            //Check if th user come from post request method
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo "<h1 class='text-center'>Insert Page</h1>";
                echo "<div class='container'>";

                // Get Variables from form to insert them in database
                $name     = $_POST['name'];
                $desc     = $_POST['description'];
                $parent   = $_POST['parent'];
                $order    = $_POST['ordering'];
                $visible  = $_POST['visibility'];
                $comment  = $_POST['commenting'];
                $ads      = $_POST['ads'];

                // Check if name is not Empty
                if(!empty($name)){
                    //Check if Category's name exist in database
                    $check = checkItem("Name", "categories", $name);
                        if($check === 1 ){
                            $theMsg = '<div class="alert alert-danger">Sorry, This Name already exists</div>';
                            redirectHome($theMsg,'back');
                        } else {
                        // Insert Category data into the database
                        $stmt = $con->prepare("INSERT INTO
                                                      categories(Name, Description, Parent, Ordering, Visibility, Allow_Comment, Allow_Ads)
                                                      VALUES ( :zname, :zdesc, :zparent, :zorder, :zvisible, :zcomment, :zads )");
                                $stmt->execute(array(
                                    'zname'    => $name,
                                    'zdesc'    => $desc,
                                    'zparent'  => $parent,
                                    'zorder'   => $order,
                                    'zvisible' => $visible,
                                    'zcomment' => $comment,
                                    'zads'     => $ads
                                ));
                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " member inserted successfully</div>";
                        redirectHome($theMsg,'back');
                    }
                } else {
                    echo "<div class='container'>";
                        // Open the Insert Page directly
                        $theMsg = "<div class='alert alert-danger'>You can not browse this page</div>";
                        redirectHome($theMsg,'back');
                    echo "</div>";
                }
            echo "</div>";
        }
        } elseif ($do == 'Edit') {

            // Check if the category id From GET REGUEST is number
            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :  0;

            $stmt = $con->prepare("SELECT * FROM categories WHERE ID=?");
    		$stmt->execute(array($catid));
    		$cat = $stmt->fetch();
    		$count = $stmt->rowCount();

            if ($count > 0) { ?>
                <h1 class="text-center">Edit Category</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST">
                        <!-- Create input field hidden to save the catid -->
                        <input type="hidden" name="catid" value="<?php echo $catid ?>">
                        <!-- Start Name field -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Name</label>
                            <div class="col-sm-10 col-md-3">
                                <input type="text" name="name" class="form-control" placeholder="Category Name" value="<?php echo $cat['Name']?>">
                            </div>
                        </div>
                        <!-- End Name field -->
                        <!-- Start Description field -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Description</label>
                            <div class="col-sm-10 col-md-3 field">
                                <input type="text" name="description" class="form-control" placeholder="Describe Category" value="<?php echo $cat['Description']?>">
                            </div>
                        </div>
                        <!-- End Description field -->
                        <!-- Start Category Type -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Have Parent </label>
                            <div class="col-sm-10 col-md-3">
                                <select class="" name="parent">
                                <option value="0">None</option>
                                <?php
                                    $categories = getAllRecords("*", "categories", "where Parent = 0", "", "ID", "ASC");
                                    foreach ($categories as $c) {
                                        echo "<option value='". $c['ID'] ."'";

                                          if($cat['Parent'] == $c['ID']){ echo " selected"; }

                                        echo ">" . $c['Name'] . "</option>";
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Category Type -->
                        <!-- Start Ordering field -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Ordering</label>
                            <div class="col-sm-10 col-md-3">
                                <input type="number" name="ordering" class="form-control" placeholder="Arrange your category" value="<?php echo $cat['Ordering']?>">
                            </div>
                        </div>
                        <!-- End Ordering field -->
                        <!-- Start Visibility field -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Visible</label>
                            <div class="col-sm-10 col-md-3">
                                <div>
                                    <input id="v-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0) {echo 'checked';}?> />
                                    <label for="v-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="v-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility'] == 1) {echo 'checked';}?> />
                                    <label for="v-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- End Visibility field -->
                        <!-- Start Commenting field -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Allow Commenting</label>
                            <div class="col-sm-10 col-md-3">
                                <div>
                                    <input id="c-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0) {echo 'checked';}?>>
                                    <label for="c-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="c-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1) {echo 'checked';}?>>
                                    <label for="c-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- End Commenting field -->
                        <!-- Start Ads field -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">Allow Ads</label>
                            <div class="col-sm-10 col-md-3">
                                <div>
                                    <input id="a-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0) {echo 'checked';}?>>
                                    <label for="a-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="a-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1) {echo 'checked';}?>>
                                    <label for="a-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- End Ads field -->
                        <!-- Start Submit Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" name="submit" value="Save" class="btn btn-primary">
                            </div>
                        </div>
                        <!-- End Submit Button -->
                    </form>
                </div>

            <?php } else {

                    echo "<div class='container'>";
                        $theMsg = "<div class='alert alert-danger'>There is no ID with this number</div>";
                        redirectHome($theMsg);
                    echo "</div>";
                }
        } elseif ($do == 'Update') {
            echo "<h1 class='text-center'>Update Category</h1>";
            echo "<div class='container'>";
                //Check if th user come from post request method
                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    // Get Variables from form to insert them in database
                    $id      = $_POST['catid'];
                    $name    = $_POST['name'];
                    $desc    = $_POST['description'];
                    $parent  = $_POST['parent'];
                    $order   = $_POST['ordering'];
                    $visible = $_POST['visibility'];
                    $comment = $_POST['commenting'];
                    $ads     = $_POST['ads'];

                    // Update the database with these information
                    $stmt = $con->prepare("UPDATE
                                                categories
                                           SET
                                                Name = ?,
                                                Description = ?,
                                                Parent = ?,
                                                Ordering = ?,
                                                Visibility = ?,
                                                Allow_Comment = ?,
                                                Allow_Ads = ?
                                           WHERE
                                                ID = ? ");

                    $stmt->execute(array($name, $desc, $parent, $order, $visible, $comment, $ads, $id));

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " category updated successfully</div>";
                    redirectHome($theMsg,'back');

                } else{

                    echo "<div class='container'>";
                        $theMsg = "<div class='alert alert-danger'>Sorry, you can not view this page directly</div>";
                        redirectHome($theMsg,'back');
                    echo "</div>";

                }
            echo "</div>";

        } elseif ($do == 'Delete') {
            echo "<h1 class='text-center'>Delete Category</h1>";
            echo "<div class='container'>";
                // Check if the catId From GET REGUEST is number
                $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :  0;

                $check = checkItem("ID", "categories", $catid);

                //If there is Id
                if ($check > 0) {
                    $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");
                    $stmt->bindParam(":zid", $catid);
                    $stmt->execute();

                    // Success Msg
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " category deleted successfully</div>";
                    redirectHome($theMsg, 'back');
                    } else {

                    echo "<div class='container'>";
                        $theMsg = "<div class='alert alert-danger'> This Category not exist </div>";
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
