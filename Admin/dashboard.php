<?php

    session_start();

    if(isset($_SESSION['Username'])){

        $pageTitle = 'Dashboard';

        include 'init.php';

        /* Start Dashboard Page */

        $numUsers = 5; // Number of latest Users
        $latestRegisterdUsers = getLatest("*","users", "Username", $numUsers); //Latest Users Array

        $numItems = 5;
        $currentItems = getLatest("*","items", "Name", $numItems); //Latest Items Array

        ?>

        <div class="wrapper">
            <div class="container">
                <h1 class="text-center">Dashboard</h1>
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat st-members">
                            <i class="fas fa-users"></i>
                            <div class="info">
                                Total Members
                                <span><a href="members.php"><?php echo countItems('UserID','users')?></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-pending">
                            <i class="fas fa-user-plus"></i>
                            <div class="info">
                                Pending Members
                                <span>
                                    <a href="members.php?do=Manage&page=Pending">
                                    <?php echo checkItem("RegStatus","users",0) ?>
                                    </a>
                                </span>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-items">
                            <i class="fas fa-tags"></i>
                            <div class="info">
                                Total Items
                                <span><a href="items.php"><?php echo countItems('Item_ID','items')?></span></a>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-comments">
                            <i class="fas fa-comments"></i>
                            <div class="info">
                                Total Comments
                                <span><a href="comments.php"><?php echo countItems('C_ID','comments')?></span></a></span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="latest">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fas fa-users"></i>Latest <strong><?php echo $numUsers?></strong> Registered Users
                                <span class="toggle-info pull-right">
                                    <i class="fas fa-plus"></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled latest-users">
                                    <?php
                                        if(!empty($latestRegisterdUsers)){
                                            foreach ($latestRegisterdUsers as $user) {
                                                echo '<li>';
                                                    echo $user['Username'];
                                                    echo "<a href='members.php?do=Edit&userid=" . $user['UserID'] ."'>";
                                                        echo "<span class='btn btn-success pull-right'>";
                                                            echo "<i class='far fa-edit'></i> Edit";
                                                            if($user['RegStatus'] == 0){
                                                                echo "<a href='members.php?do=Activate&userid=" . $user['UserID'] . "
                                                                'class='btn btn-info pull-right activate'> Activate</a>";
                                                            }
                                                        echo "</span>";
                                                    echo "</a>";
                                                echo "</li>";
                                            }
                                        } else {
                                            echo "There is no users to show";
                                        }

                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fas fa-tags"></i>Latest <strong><?php echo $numItems?></strong> Items
                                <span class="toggle-info pull-right">
                                    <i class="fas fa-plus"></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled latest-users">
                                    <?php
                                        if (!empty($currentItems)) {
                                            foreach ($currentItems as $item) {
                                                echo '<li>';
                                                    echo $item['Name'];
                                                    echo "<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] ."'>";
                                                        echo "<span class='btn btn-success pull-right'>";
                                                            echo "<i class='far fa-edit'></i> Edit";
                                                            if($item['Approve'] == 0){
                                                                echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "
                                                                'class='btn btn-info pull-right activate'>
                                                                <i class='far fa-check-square'></i> Approve</a>";
                                                            }
                                                        echo "</span>";
                                                    echo "</a>";
                                                echo "</li>";
                                            }
                                        } else {
                                            echo "There is no items to show";
                                        }

                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> <!-- End row -->

                <!-- Start Comments -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fas fa-comments"></i>Latest Comments
                                <span class="toggle-info pull-right">
                                    <i class="fas fa-plus"></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                <?php
                                $stmt = $con->prepare("SELECT
                                                          comments.*,users.Username AS Member
                                                      FROM
                                                          comments
                                                      INNER JOIN
                                                          users
                                                      ON users.UserID = comments.user_id
                                                      ");
                                $stmt->execute();
                                $comments = $stmt->fetchAll();

                                if (!empty($comments)) {
                                    foreach ($comments as $comment) {
                                            echo "<div class='comment-box'>";
                                                echo "<span class='member-name pull-left'>" . $comment['Member']  . "</span>";
                                                echo "<p class='member-comment pull-right'>" . $comment['Comment'] . "</p>";
                                            echo "</div>";
                                    }
                                } else {
                                    echo "There is no comments to show";
                                }


                                ?>
                            </div>
                        </div>
                    </div>
                </div> <!-- End row -->
                <!-- Start Comments -->
            </div>
        </div>

        <?php
        /* End Dashboard Page */

        include $tpl . 'footer.inc.php';

        } else{

        header('Location: index.php');
        exit();
    }
