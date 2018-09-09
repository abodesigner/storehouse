<?php

ob_start(); //Output Buffering Start

session_start();

$pageTitle = 'Comments';

if(isset($_SESSION['Username'])){

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage'){ // Manage Members Page

        // Fetch all comments from database.
        $stmt = $con->prepare("SELECT
                                  comments.*,items.Name AS Item_Name,users.Username AS Member
                              FROM
                                  comments
                              INNER JOIN
                                  items
                              ON items.Item_ID = comments.item_id
                              INNER JOIN
                                  users
                              ON users.UserID = comments.user_id
                              ORDER BY C_ID DESC");
        $stmt->execute();
        $rows = $stmt->fetchAll();

        if (!empty($rows)) {

        ?>

        <h1 class="text-center">Manage Comments</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table table-bordered table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Comment</th>
                        <th>Username</th>
                        <th>Item Name</th>
                        <th>Added Date</th>
                        <th>Control</th>
                    </tr>
                    <?php
                        foreach ($rows as $row) {
                            echo "<tr>";
                                echo "<td>" . $row['C_ID'] . "</td>";
                                echo "<td>" . $row['Comment'] . "</td>";
                                echo "<td>" . $row['Member'] . "</td>";
                                echo "<td>" . $row['Item_Name'] . "</td>";
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
            echo "<div class='alert alert-danger'>There is no Comments to show</div>";
        echo "<div>";
    }?>

    <?php

      } elseif ($do == 'Edit') { // Edit Page

        // Check if the commentId From GET REQUEST is number
        $cid = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) :  0;

        $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID=?");
        $stmt->execute(array($cid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) { ?>
            <h1 class="text-center">Edit Comment</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                    <!-- Create input field hidden to save the cid -->
                    <input type="hidden" name="cid" value="<?php echo $cid ?>">

                    <!-- Start Comment field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label" for="">Comment</label>
                        <div class="col-sm-10 col-md-6">
                            <textarea name="comment" class="form-control"><?php echo $row['Comment']?></textarea>
                        </div>
                    </div>
                    <!-- End Comment field -->

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
        }  elseif ($do == 'Update') { // Update Comment Page
            echo "<h1 class='text-center'>Update Comment</h1>";
            echo "<div class='container'>";
                //Check if th user come from post request method
                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    // Get Variables from form to insert them in database
                    $cid    = $_POST['cid'];
                    $comment  = $_POST['comment'];

                    // Update the database with these information
                    $stmt = $con->prepare("UPDATE comments SET Comment = ? WHERE C_ID = ? ");
                    $stmt->execute(array($comment, $cid));

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " comment updated successfully</div>";
                    redirectHome($theMsg);

                } else{

                    echo "<div class='container'>";
                        $theMsg = "<div class='alert alert-danger'>Sorry, you can not view this page directly</div>";
                        redirectHome($theMsg,'back');
                    echo "</div>";

                }
            echo "</div>";

        } elseif ($do == 'Delete') { //Delete Comment
            echo "<h1 class='text-center'>Delete Comment</h1>";
            echo "<div class='container'>";
                // Check if the cId From GET REQUEST is number
                $cid = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) :  0;

                $check = checkItem("C_ID", "comments", $cid);

                //If there is Id
                if ($check > 0) {
                    $stmt = $con->prepare("DELETE FROM comments WHERE C_ID = :zcmt");
                    $stmt->bindParam(":zcmt", $cid);
                    $stmt->execute();

                    // Success Msg
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " comment deleted successfully</div>";
                    redirectHome($theMsg,'back');
                    } else {

                    echo "<div class='container'>";
                        $theMsg = "<div class='alert alert-danger'> This Id not exist </div>";
                        redirectHome($theMsg);
                    echo "</div>";
                }
            echo "</div>";

        } elseif($do == 'Approve') { //Approve comments Page
            echo "<h1 class='text-center'>Approve Page</h1>";
            echo "<div class='container'>";
                // Check if the cId From GET REQUEST is number
                $cid = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) :  0;

                $check = checkItem("C_ID", "comments", $cid);

                //If there is Id
                if ($check > 0) {
                    $stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE C_ID = ?");
                    $stmt->execute(array($cid));

                    // Success Msg
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " comment approved successfully</div>";
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

} else{

header('Location: index.php');

exit();

ob_end_flush();
}
