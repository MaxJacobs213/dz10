<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/models/cities.php');
$citiesClass = new Cities();
$cities = $citiesClass->get_all();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ДОбавление машины</title>
</head>
<body>

<form action="controllers/save.php?operator=addcar" method="post">
    <p>
        <label for="">Название машины</label>
        <input type="text" name="name">
    </p>
    <p>
        <label for="">Год выпуска</label>
        <input type="number" name="year_issue">
    </p>
    <p>
        <label for="">Город</label>
        <select name="city_id">
            <?php foreach ($cities as $city):?>
            <option value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <button>Сохранить</button>
    </p>
</form>

</body>
</html>