<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ИС Мини-отель</title>
    <link href="./frontend/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container min-vh-100 align-items-center justify-content-center d-flex flex-column">
    <div class="h5 title mb-4 fw-bold">ИС Мини-отель</div>
    <form class="d-flex flex-column gap-2" method="POST" action="/api/auth.php">
        <div class="form-floating">
            <input class="form-control" placeholder="Логин" type="text" name="login" id="login" />
            <label for="login">Логин</label>
        </div>
        <div class="form-floating">
            <input class="form-control" placeholder="Пароль" type="password" name="password" id="password" />
            <label for="password">Пароль</label>
        </div>
        <button class="mt-4 btn btn-primary mx-auto" type="submit">Авторизация</button>
    </form>
</body>

</html>