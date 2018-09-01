<?php

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

if ($do == 'Manage'){

    echo "welcome, you are in manage page" . '<br>';
    echo "<a href='?action=Add'>Add Category</a>" . '<br>';
    echo "<a href='?action=Update'>Update Category</a>" . '<br>';
    echo "<a href='?action=Delete'>Delete Category</a>" . '<br>';


} elseif ($do == 'Add') {

    echo "welcome, you can add new category";

} elseif ($do == 'Update') {

    echo "welcome, you can update current category";

} elseif ($do == 'Delete') {

    echo "welcome, you can delete current category";

} else {
    echo "Error, there is no page with this name";
}
