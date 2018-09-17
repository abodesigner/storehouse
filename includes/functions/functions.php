<?php
    /*
    ============================================================
     Function related to Front-End
    ============================================================
    */

    /*
    ** Function Name : getCats().
    ** Version       : 1.0.
    ** Usage         : get categories.
    */

    function getAllRecords($table, $where = NULL, $orderBy = NULL){
        global $con;

        $sql = $where == NULL ? "" : $where;

        $getAll = $con->prepare("SELECT * FROM $table $sql ORDER BY $orderBy DESC");
        $getAll->execute();
        $allRows = $getAll->fetchAll();
        return $allRows;
    }

    /*
    ** Function Name : getCats().
    ** Version       : 1.0.
    ** Usage         : get categories.
    */

    function getCats(){
        global $con;
        $getCats = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");
        $getCats->execute();
        $rows = $getCats->fetchAll();
        return $rows;
    }

    /*
    ** Function Name : getItems().
    ** Version       : 2.0.
    ** Usage         : get items.
    */
    function getItems($where, $value, $approve = NULL){
        global $con;

        $sql = $approve == NULL ? "AND Approve = 1" : " ";

        $items = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY Item_ID DESC");

        $items->execute(array($value));

        $rows = $items->fetchAll();

        return $rows;
    }

    /*
    ** Function Name : checkUserStatus().
    ** Version       : 1.0.
    ** Usage         : check if regStatus == 0 or 1.
    */

    function checkUserStatus($user){
      global $con;
      $stmtx = $con->prepare("SELECT
                                 Username, RegStatus
                             FROM
                                 users
                             WHERE
                                  Username=?
                             AND
                                  RegStatus = 0");
      $stmtx->execute(array($user));
      $status = $stmtx->rowCount();

      return $status;
    }

    /*
    ** Function Name : checkItem().
    ** Version       : 1.0.
    ** Usage         : check item if exist in database
    */
    function checkItem($Item,$Table,$value){
        global $con;
        $sttmt = $con->prepare("SELECT $Item FROM $Table WHERE $Item = ?");
        $sttmt->execute(array($value));
        $count = $sttmt->rowCount();
        return $count;
    }



















    /*
    ** Function Name : getTitle().
    ** Version       : 1.0.
    ** Usage         : echo the apge title in case
    **                 page has the '$pageTitle Variable',
    **                 else echo 'default' for other pages.
    */
    function getTitle(){
        global $pageTitle;
        echo $pageTitle = isset($pageTitle) ? $pageTitle : "Default";
    }

    /*
    ** Function Name : redirectHome().
    ** Version       : 2.0.
    ** Usage         : function will accept two parameters,
    **                 $themsg  = echo mesg [Error | Success | Warning]
    **                 $url     = link you want to direct to.
    **                 $seconds =  number of seconds before redirect to home page
    */
    function redirectHome($theMsg, $url = null, $sec = 3){
        if($url === null){
            $url = 'index.php';
        } else{
            if( isset($_SERVER['HTTP_REFERER']) && !empty(($_SERVER['HTTP_REFERER']))){
                $url = $_SERVER['HTTP_REFERER'];
            } else{
                $url = 'index.php';
            }
        }
        echo $theMsg;
        echo "<div class='alert alert-info'>You will be redirected to home page after $sec seconds.</div>";
        header("refresh:$sec; url=$url");
        exit();
    }


    /*
    ** Function Name : countItems().
    ** Version       : 1.0.
    ** Usage         : count the number of members in database.
    ** parameters    : $item & $table.
    */
    function countItems($item, $table){
        global $con;
        $stm = $con->prepare("SELECT COUNT($item) FROM $table");
        $stm->execute();
        return $stm->fetchColumn();
    }


    /*
    ** Function Name : getLatest().
    ** Version       : 1.0.
    ** Usage         : get latest items, members, comments.
    ** parameters    : $select - $table -$limit
    */

    function getLatest($select, $table, $order, $limit){
        global $con;
        $sttm = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
        $sttm->execute();
        $rows = $sttm->fetchAll();
        return $rows;
    }
