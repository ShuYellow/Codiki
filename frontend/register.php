<?php
require '../api/crud.php';
$user_id = $_GET['user_id'];
$user = select("SELECT * FROM user WHERE userid=$user_id;")[0];
if ($user['userroleid'] != 1) {
    http_response_code(401);
    header('Content-Type: application/json');
    exit(json_encode(['status' => 'unauthorized']));
}

if (
    isset($_POST['firstname']) && $_POST['firstname'] != '' &&
    isset($_POST['lastname']) && $_POST['lastname'] != ''
) {
    $insert = insert("INSERT INTO user (login,password,firstname,lastname,middlename,userroleid) VALUES ('$_POST[login]','$_POST[password]','$_POST[firstname]','$_POST[lastname]','$_POST[middlename]',$_POST[userroleid])");
    if ($insert['status'] != 'success') echo "<script>alert('Не удалось уволить сотрудника')</script>";
    $_POST= [];
    header("Location: /frontend/view_1.php?user_id=$user_id");
}

?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ИС Мини-отель</title>
    <link rel="stylesheet" href="./bootstrap.min.css">
</head>

<body>
    <div class="container pt-3">
        <h4 class="h4 title fw-bold mb-3">Регистрация нового сотрудника</h4>
        <form class="d-flex flex-column gap-2" method="POST">
            <div class="form-floating">
                <input name="login" id="login" placeholder="Логин" class="form-control" type="text">
                <label for="login">Логин</label>
            </div>
            <div class="form-floating">
                <input name="password" id="password" placeholder="Пароль" class="form-control" type="password">
                <label for="password">Пароль</label>
            </div>
            <div class="form-floating">
                <input name="userroleid" id="userroleid" placeholder="Должность" class="form-control" type="text">
                <label for="userroleid">Должность</label>
            </div>
            <div class="form-floating">
                <input name="lastname" id="lastname" placeholder="Фамилия" class="form-control" type="text">
                <label for="lastname">Фамилия</label>
            </div>
            <div class="form-floating">
                <input name="firstname" id="firstname" placeholder="Имя" class="form-control" type="text">
                <label for="firstname">Имя</label>
            </div>
            <div class="form-floating">
                <input name="middlename" id="middlename" placeholder="Отчество" class="form-control" type="text">
                <label for="middlename">Отчество</label>
            </div>
            <button type="submit" class="ms-auto btn btn-primary">Создать</button>
        </form>
    </div>
</body>

</html>