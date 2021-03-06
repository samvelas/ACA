<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>My Blog</title>

    <!-- Bootstrap -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="CSS/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<?php
require_once 'Classes/tools.php';
$tools = new Tools(); // to use tools methods
include_once 'header.php';

define ('ITEMS_PER_PAGE', 2);


if(isset($_GET['category'])){
    $categoryId = $_GET['category'];
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    } else {
        $page = 0;
    }
    $array = $tools->getPostByCategory($categoryId, $page * ITEMS_PER_PAGE, ITEMS_PER_PAGE); // FROM, LIMIT, OFFSET

    $pageCount = $tools->getPageCount($categoryId);
} else{
    if (isset($_GET['search'])){ // to print corresponding posts after search
        $array = [];
        $array = $tools->search($_GET['search']);
        $pageCount = count($array);
        if (count($array) == 0){
            echo '<h1 class="text-center">No result for "' . $_GET['search'] . '"</h1>';
            echo $tools->getErrorMessage();
            die;
        }
    } else {
        echo '<h1 class="text-center">Welcome to My Blog!</h1>';
        die;

    }
}
/*
//pagination
define('ITEMS_PER_PAGE', '10');

$size = count($array);
$pageCount = ceil($size/ITEMS_PER_PAGE);
$currentPage = 0;
if (isset($_GET['page'])){
    $currentPage = $_GET['page'];
}
$start = $currentPage * ITEMS_PER_PAGE;
$limit = ITEMS_PER_PAGE;
if (($currentPage == $pageCount - 1) && ($size < $pageCount * ITEMS_PER_PAGE)){
    $limit = $size - $start;
}

*/
?>

<body>
    <div class="container margin-top">
        <div class="row">
            <div class="col-xs-12">
                <?php
                foreach ($array as $key => $value){
                    echo
                        '<div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">' . $value['title'] . '</h3>
                            </div>
                            <div class="panel-body">' . $value['content'] . '</div>
                            <div class="panel-footer">' . $value['author'] . ' ' . $value['date'] . '</div>
                        </div>';
                }
                ?>
            </div>

        </div>
        <?php
        if(!isset($_GET['search'])){ // no need for pagination in search
            include 'pagination.php';
        }
        ?>
    </div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="JS/script.js"></script>
</body>
</html>
