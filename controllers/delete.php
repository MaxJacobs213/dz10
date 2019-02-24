<?php
if(isset($_GET['operator'])) {
    if ($_GET['operator'] == 'deletecar') {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/models/cars.php';

        $carClass = new Cars();
        if ($carClass->delete(['id' => $_POST['id']]))
            echo "Удалено";
    }
}


?>