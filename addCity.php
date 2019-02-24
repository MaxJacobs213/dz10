<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ДОбавление города</title>
</head>
<body>

<form action="/controllers/save.php?operator=addcity" method="post">
    <p>
        <label for="">Название города</label>
        <input type="text" name="name">
    </p>
    <p>
        <label for="">Индекс</label>
        <input type="number" name="post_index">
    </p>
    <p>
        <button>Сохранить</button>
    </p>
</form>

</body>
</html>