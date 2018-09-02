<?php

    session_start();

    if(isset($_SESSION['Username'])){

        $pageTitle = 'Dashboard';

        include 'init.php';

        /* Start Dashboard Page */

        $latestUsers = 5; // Number of latest Users

        $latestRegisterdUsers = getLatest("*","users", "Username", $latestUsers); //Latest Users Array

        ?>

        <div class="wrapper">
            <div class="container text-center">
                <h1 class="text-center">Dashboard</h1>
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat st-members">
                            Total Members
                                <span><a href="members.php"><?php echo countItems('UserID','users')?></span></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-pending">
                            Pending Members
                            <span><a href="members.php?do=Manage&page=Pending">
                                <?php echo checkItem("RegStatus","users",0) ?>
                            </a></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-items">
                            Total Items
                            <span><a href="items.php"><?php echo countItems('Item_ID','items')?></span></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-comments">
                            Total Comments
                            <span>600</span>
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
                                <i class="fas fa-users"></i>Latest <strong><?php echo $latestUsers?></strong> Registered Users
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled latest-users">
                                    <?php
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
                                    ?>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fas fa-tags"></i>Latest Items
                            </div>
                            <div class="panel-body">
                                Test
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        /* End Dashboard Page */

        include $tpl . 'footer.inc.php';

        } else{

        header('Location: index.php');
        exit();
    }
