<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/models/cities.php');
$citiesClass = new Cities();
$cities = $citiesClass->get_all();

include_once ($_SERVER['DOCUMENT_ROOT'].'/models/cars.php');
$carsClass = new Cars();
$cars = $carsClass->get_one(['id' => $_GET['id']]);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактирование машины</title>
</head>
<body>

<form action="controllers/edit.php?operator=editcar" method="post">
    <p>
        <label for="">Название машины</label>
        <input type="text" name="name" value="<?= $cars['name']?>">
    </p>
    <p>
        <label for="">Год выпуска</label>
        <input type="number" name="year_issue" value="<?= $cars['year_issue'] ?>">
    </p>
    <p>
        <input type="hidden" name="id" value="<?= $cars['id'] ?>">
    </p>
    <p>
        <label for="">Город</label>
        <select name="city_id">
            <?php foreach ($cities as $city):?>
                <option value="<?= $city['id'] ?>"  <?= ($cars['city_id'] == $city['id']) ? 'selected' : ''; ?>><?= $city['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <button>Сохранить</button>
    </p>
</form>
<form action="controllers/delete.php?operator=deletecar" method="post">
    <button>Удалить</button>
    <input type="hidden" name="id" value="<?= $cars['id'] ?>">
</form>

</body>
</html>