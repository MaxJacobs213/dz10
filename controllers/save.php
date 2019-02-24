<?php


if(isset($_GET['operator'])) {

    //добавление города
    if ($_GET['operator'] == 'addcity') {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/models/cities.php';

        $cityClass = new Cities();
        $result = $cityClass->insert($_POST);
        if ($result) {
            echo 'Данные сохранены!';
        }
    }

    if ($_GET['operator'] == 'addcar') {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/models/cars.php';
        require_once($_SERVER['DOCUMENT_ROOT'] . '/models/Request.php');

        $carClass = new Cars();
        $request = new Request ();
        $errors = [];
        $status = true;

        if ($request->isPost()) {
            $request->required('name', 'Название')
                ->required('year_issue', 'Год выпуска')
                ->required('city_id', 'Город')
                ->isYear('year_issue')
                ->isValidOptions('city_id', $carClass->pdo, 'cities', 'id');

            $status = $request->isValid();
            $errors = $request->getErrors();

            if ($status) {
                $result = $carClass->insert($_POST);
                if ($result) {
                    echo 'Данные сохранены!';
                }
            } else {
                foreach ($errors as $key => $error)
                    foreach ($error as $item)
                        echo $item . '<br>';
            }
        }

    }
}

?>