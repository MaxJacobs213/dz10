<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/models/cities.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/models/cars.php');
$citiesClass = new Cities();
$cities = $citiesClass->get_all();
$carsClass = new Cars();
$cars = $carsClass->get_all();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Список городов</h1>

<?php foreach ($cities as $city):?>
<p><?php echo $city['name']?></p>
<?php endforeach;?>

<h1>Список машин</h1>

<?php foreach ($cars as $car):?>
    <p>
        <?php echo $car['name']?>
        <a href="editCar.php?id=<?= $car['id'] ?>">Редактировать</a>
    </p>
<?php endforeach;?>
</body>
</html>