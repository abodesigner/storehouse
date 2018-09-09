    <?php

    ob_start(); //Output Buffering Start

    session_start();
    $pageTitle = 'Members';
    if(isset($_SESSION['Username'])){
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == 'Manage'){ // Manage Members Page

            $query = '';

            if(isset($_GET['page']) && $_GET['page'] == 'Pending' ){
                $query = 'AND RegStatus = 0';
            }
            // Fetch all s from database.
            $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");
            $stmt->execute();
            $rows = $stmt->fetchAll();

            if(!empty($rows)){


            ?>
            <h1 class="text-center">Manage Members</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table table table-bordered table-hover">
                        <tr>
                            <th>#ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Full Name</th>
                            <th>Registered Date</th>
                            <th>Control</th>
                        </tr>
                        <?php
                            foreach ($rows as $row) {
                                echo "<tr>";
                                    echo "<td>" . $row['UserID'] . "</td>";
                                    echo "<td>" . $row['Username'] . "</td>";
                                    echo "<td>" . $row['Email'] . "</td>";
                                    echo "<td>" . $row['FullName'] . "</td>";
                                    echo "<td>" . $row['Date'] . "</td>";

                                    echo "<td>
                                            <a href='members.php?do=Edit&userid="   . $row['UserID'] . "' class='btn btn-success'><i class='fas fa-pen'></i>Edit</a>
                                            <a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='far fa-trash-alt'></i> Delete </a>";

                                    if($row['RegStatus'] == 0){
                                        echo "<a href='members.php?do=Activate&userid=" . $row['UserID'] . "'
                                        class='btn btn-info activate'><i class='fas fa-check'></i> Activate</a>";
                                    }

                                    echo "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
                <a href='members.php?do=Add' class="btn btn-primary"><i class="fas fa-plus-circle"></i>New Member<a>
            </div>
        <?php } else {
            echo "<div class='container'>";
                echo "<div class='alert alert-danger'>There is no members to show</div>";
                echo "<a href='members.php?do=Add' class='btn btn-primary btn-sm'><i class='fas fa-plus-circle'></i>New Member<a>";
            echo "<div>";
        }?>

        <?php } elseif ($do == 'Add') { // Add Page     ?>
            <h1 class="text-center">Add New User</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST">

                    <!-- Start Username field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Username</label>
                        <div class="col-sm-10 col-md-3">
                            <input type="text" name="username" class="form-control" autocomplete="off" required placeholder="Enter Username">
                        </div>
                    </div>
                    <!-- End Username field -->
                    <!-- Start Password field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Password</label>
                        <div class="col-sm-10 col-md-3 field">
                            <input type="password" name="password" class="password form-control" autocomplete="new-password" required placeholder="Enter Password">
                            <i class="show-pass far fa-eye"></i>
                        </div>
                    </div>
                    <!-- End Password field -->
                    <!-- Start Email field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Email</label>
                        <div class="col-sm-10 col-md-3">
                            <input type="email" name="email" class="form-control"  autocomplete="off" required placeholder="Enter Email">
                        </div>
                    </div>
                    <!-- End Email field -->
                    <!-- Start Fullname field -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="">Fullname</label>
                        <div class="col-sm-10 col-md-3">
                            <input type="text" name="fullname" class="form-control" autocomplete="off" required placeholder="Enter Fullname">
                        </div>
                    </div>
                    <!-- End Fullname field -->
                    <!-- Start Submit Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" name="submit" value="Add User" class="btn btn-primary">
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
                    $user  = $_POST['username'];
                    $pass  = $_POST['password'];
                    $email = $_POST['email'];
                    $name  = $_POST['fullname'];
                    $hashPass = sha1($_POST['password']);

                    // Validate the form
                    $FormErrors = array();
                    if(empty($user)){
                        $FormErrors[] = "Username can't be <strong>empty</strong>";
                    }

                    if(strlen($user) < 4){
                        $FormErrors[] = "<div class='alert alert-danger'>Username can't be <strong>less than 4</strong>";
                    }

                    if(strlen($user) > 20){
                        $FormErrors[] = "Username can't be <strong>more than 20</strong>";
                    }

                    if(empty($email)){
                        $FormErrors[] = "Email can't be <strong>empty</strong>";
                    }

                    if(empty($pass)){
                        $FormErrors[] = "Password can't be <strong>empty</strong>";
                    }

                    if(empty($name)){
                        $FormErrors[] = "Name can't be <strong>empty</strong>";
                    }
                    // Loop into Errors Array & echo it
                    foreach($FormErrors as $err) {
                        echo "<div class='alert alert-danger'>" . $err . '</div>';
                    }
                    // Check if there are no errors Proceed to Update operation
                    if(empty($FormErrors)){

                        //check if Username exist in database
                        $check = checkItem("Username", "users", $user);
                            if($check === 1 ){
                            $theMsg = '<div class="alert alert-danger">Sorry, This Username already exists</div>';
                            redirectHome($theMsg,'back');
                        } else {
                            // Insert New User data into the database
                            $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName, RegStatus, Date)
                                                   VALUES(:zuser,:zpass,:zmail,:zname, 1, now())");
                                    $stmt->execute(array(
                                        'zuser' => $user,
                                        'zpass' => $hashPass,
                                        'zmail' => $email,
                                        'zname' => $name,
                                    ));

                            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " member inserted successfully</div>";
                            redirectHome($theMsg,'back');
                        }
                    }

                } else{

                    echo "<div class='container'>";
                        // Open the Insert Page directly
                        $theMsg = "<div class='alert alert-danger'>You can not browse this page</div>";
                        redirectHome($theMsg,'back');
                    echo "</div>";
                }
                echo "</div>";
            } elseif ($do == 'Edit') { // Edit Page

            // Check if the userId From GET REGUEST is number
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :  0;

            $stmt = $con->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1");
    		$stmt->execute(array($userid));
    		$row = $stmt->fetch();
    		$count = $stmt->rowCount();

            if ($count > 0) { ?>
                <h1 class="text-center">Edit Page</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST">
                        <!-- Create input field hidden to save the userid -->
                        <input type="hidden" name="userid" value="<?php echo $userid ?>">
                        <!-- Start Username field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label" for="">Username</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required>
                            </div>
                        </div>
                        <!-- End Username field -->
                        <!-- Start Password field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label" for="">Password</label>
                            <div class="col-sm-10 col-md-6 field">
                                <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>">
                                <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave empty if you don not change it">
                            </div>
                        </div>
                        <!-- End Password field -->
                        <!-- Start Email field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label" for="">Email</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" autocomplete="off" required>
                            </div>
                        </div>
                        <!-- End Email field -->
                        <!-- Start Fullname field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label" for="">Fullname</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="fullname" class="form-control" value="<?php echo $row['FullName'] ?>" autocomplete="off" required>
                            </div>
                        </div>
                        <!-- End Fullname field -->
                        <!-- Start Submit Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" name="submit" value="Save" class="btn btn-info btn-lg">
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
            }  elseif ($do == 'Update') { // Update Page
                echo "<h1 class='text-center'>Update Page</h1>";
                echo "<div class='container'>";
                    //Check if th user come from post request method
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){

                        // Get Variables from form to insert them in database
                        $id    = $_POST['userid'];
                        $user  = $_POST['username'];
                        $email = $_POST['email'];
                        $name  = $_POST['fullname'];

                        // // Password Change
                        $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

                        // Validate the form
                        $FormErrors = array();

                        if(empty($user)){
                            $FormErrors[] = "Username can't be <strong>empty</strong>";
                        }

                        if(strlen($user) < 4){
                            $FormErrors[] = "<div class='alert alert-danger'>Username can't be <strong>less than 4</strong>";
                        }

                        if(strlen($user) > 20){
                            $FormErrors[] = "Username can't be <strong>more than 20</strong>";
                        }

                        if(empty($email)){
                            $FormErrors[] = "Email can't be <strong>empty</strong>";
                        }

                        if(empty($name)){
                            $FormErrors[] = "Name can't be <strong>empty</strong>";
                        }

                        // Loop into Errors Array & echo it
                        foreach($FormErrors as $err) {
                            echo  "<div class='alert alert-danger'>" . $err . '</div>';
                        }

                        // Check if there are no errors Proceed to Update operation
                        if(empty($FormErrors)){

                            $st2 = $con->prepare("SELECT * FROM users WHERE Username=? AND UserID!=?");
                            $st2->execute(array($user,$id));
                            $count = $st2->rowCount();
                            if ($count == 1) {
                                echo "<div class='container'>";
                                    $theMsg = "<div class='alert alert-danger'>Sorry, This Username is exist</div>";
                                    redirectHome($theMsg,'back');
                            } else {
                                // Update the database with these information
                                $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ? ");
                                $stmt->execute(array($user, $email, $name, $pass, $id));

                                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . "member updated successfully</div>";
                                redirectHome($theMsg,'back');
                            }



                        }
                    } else{

                        echo "<div class='container'>";
                            $theMsg = "<div class='alert alert-danger'>Sorry, you can not view this page directly</div>";
                            redirectHome($theMsg,'back');
                        echo "</div>";

                    }
                echo "</div>";

            } elseif ($do == 'Delete') { //Delete Members
                echo "<h1 class='text-center'>Delete Page</h1>";
                echo "<div class='container'>";
                    // Check if the userId From GET REGUEST is number
                    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :  0;

                    $check = checkItem("userid", "users", $userid);

                    //If there is Id
                    if ($check > 0) {
                        $stmt = $con->prepare("DELETE FROM users WHERE userid = :zuser");
                        $stmt->bindParam(":zuser", $userid);
                        $stmt->execute();

                        // Success Msg
                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " member deleted successfully</div>";
                        redirectHome($theMsg, 'back');
                        } else {

                        echo "<div class='container'>";
                            $theMsg = "<div class='alert alert-danger'> This Id not exist </div>";
                            redirectHome($theMsg);
                        echo "</div>";
                    }
                echo "</div>";

            } elseif($do == 'Activate') { //Activate Members Page
                echo "<h1 class='text-center'>Activate Page</h1>";
                echo "<div class='container'>";
                    // Check if the userId From GET REGUEST is number
                    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :  0;

                    $check = checkItem("userid", "users", $userid);

                    //If there is Id
                    if ($check > 0) {
                        $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
                        $stmt->execute(array($userid));

                        // Success Msg
                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " member activated successfully</div>";
                        redirectHome($theMsg);
                        } else {

                        echo "<div class='container'>";
                            $theMsg = "<div class='alert alert-danger'> This Id not exist </div>";
                            redirectHome($theMsg);
                        echo "</div>";
                    }
                echo "</div>";

            }

        include $tpl . 'footer.inc.php';

    } else{

    header('Location: index.php');

    exit();

    ob_end_flush();
}
