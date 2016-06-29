<?php
    define('ITEMS_PER_PAGE', 5);
    $add = false;

    $fileName = 'students.txt';
    include 'read.php';
    $size = count($array);
    if (isset($_GET['delete'])){ //if we get delete
        $delete = $_GET['delete'];
        array_splice($array, $delete, 1); //deleting element from array
        include 'write.php';
        $size--; // size of array has been changed
    }
    //add
    if(isset($_GET['course']) && isset($_GET['name'])){
        $last[] = (string)(count($array) + 1);
        $last[] = $_GET['name'];
        $last[] = $_GET['course'];
        $array[] = $last;
        $add = true;
        include 'write.php';
        $size++;
    }
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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

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
<body>
        <div class="container-fluid">
            <div class="row">
                <div class="hidden-xs col-sm-2 padding-none">
                    <div class="sidebar">
                        <ul class="nav nav-pills nav-stacked" style="padding-top: 20px;" >
                            <li ><a href="courses.php">Courses</a></li>
                            <li class="active"><a href="students.php">Students</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-10">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="page-header">Students
                                <!-- Trigger the modal with a button -->
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> Add</button>
                            </h1>

                        </div>
                    </div>

                    <div class="col-xs-1 col-xs-offset-9">


                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Add Student</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="student name" aria-describedby="basic-addon1" name="name">
                                            </div>
                                            <select class="selectpicker form-control margin" title="Choose course" name="course">
                                                <?php
                                                $fileName = 'courses.txt';
                                                include 'read.php';
                                                $titleArray = [];
                                                for ($i=0;$i<count($array);$i++){
                                                    $titleArray[] = $array[$i][1];
                                                }
                                                $titleArray = array_unique($titleArray);
                                                for ($i=0;$i<count($titleArray);$i++){
                                                    echo '<option>' . $titleArray[$i] . '</option>';
                                                }
                                                $fileName = 'students.txt';
                                                include 'read.php';

                                                ?>
                                            </select>
                                            <button type="submit" class="btn btn-default">add</button>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="row text-center" >
                        <div class="col-xs-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>student name</th>
                                    <th>course</th>
                                    <th>action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    for($i=$start;$i<$start + $limit;$i++){
                                        echo '<tr>';
                                        foreach ($array[$i] as $key => $value){
                                            echo '<td>' . $value . '</td>';
                                        }
                                        echo '<td><a href="?delete=' . $i . '">delete student</a>';
                                        echo '</tr>';
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-xs-12">
                            <nav>
                                <ul class="pagination">
                                    <li>
                                        <?php
                                            if ($currentPage == 0){
                                                echo '<a class="pagination-lock" aria-label="Previous">';
                                            } else {
                                                echo '<a href="' . '?page=' . ($currentPage - 1) . '" aria-label="Previous">';
                                            }
                                        ?>
                                        <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                    for($i=0;$i<$pageCount;$i++){
                                        if ($i == $currentPage){
                                            $style = 'style="font-weight: bold;"';
                                        } else {
                                            $style = 'style="font-weight: 0;"';
                                        }
                                        echo '<li><a ' . $style . 'href="?page=' . $i . '">' . ($i + 1) . '</a></li>';
                                    }
                                    ?>
                                    <li>
                                        <?php
                                        if ($currentPage == ($pageCount - 1)){
                                            echo '<a class="pagination-lock" aria-label="Next">';
                                        } else {
                                            echo '<a href="' . '?page=' . ($currentPage + 1) . '" aria-label="Next">';
                                        }
                                        ?>
                                        <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/i18n/defaults-*.min.js"></script>

</body>
</html>
