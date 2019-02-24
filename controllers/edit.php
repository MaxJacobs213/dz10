<?php


if(isset($_GET['operator'])) {

    if ($_GET['operator'] == 'editcar') {
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
                $result = $carClass->update($_POST, ['id' => $_POST['id']]);
                if ($result) {
                    echo 'Данные изменены!';
                }
            } else {
                foreach ($errors as $key => $error)
                    foreach ($error as $item)
                        echo $item.'<br>';
            }
        }

    }
}

?>