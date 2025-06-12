<?php
require '../api/crud.php';
$user_id = $_GET['user_id'];
$user = select("SELECT * FROM user WHERE userid=$user_id;")[0];
if ($user['userroleid'] != 2) {
    http_response_code(401);
    header('Content-Type: application/json');
    exit(json_encode(['status' => 'unauthorized']));
}

if (
    isset($_POST['roomnumber']) && $_POST['roomnumber'] != '' &&
    isset($_POST['amountclients']) && $_POST['amountclients'] != ''
) {
    $insert = insert("INSERT INTO `order` (roomnumber,amountclients,hotelservices,datecreation,paymentstatus,orderstatus) VALUES ('$_POST[roomnumber]',$_POST[amountclients],'$_POST[hotelservices]','$_POST[datecreation]','$_POST[paymentstatus]','$_POST[orderstatus]')");
    if ($insert['status'] != 'success') echo "<script>alert('Не удалось создать заказ')</script>";
    $_POST = [];
    header("Location: /frontend/view_2.php?user_id=$user_id");
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
        <h4 class="h4 title fw-bold mb-3">Создание нового заказа</h4>
        <form class="d-flex flex-column gap-2" method="POST">
            <div class="form-floating">
                <input name="roomnumber" id="roomnumber" placeholder="Название" class="form-control" type="text">
                <label for="roomnumber">Название</label>
            </div>
            <div class="form-floating">
                <input name="amountclients" id="amountclients" placeholder="Количество клиентов" class="form-control" type="text">
                <label for="amountclients">Количество клиентов</label>
            </div>
            <div class="form-floating">
                <input name="hotelservices" id="hotelservices" placeholder="Услуги" class="form-control" type="text">
                <label for="hotelservices">Услуги</label>
            </div>
            <div class="form-floating">
                <input name="orderstatus" id="orderstatus" placeholder="Статус" class="form-control" type="text">
                <label for="orderstatus">Статус</label>
            </div>
            <div class="form-floating">
                <input name="paymentstatus" id="paymentstatus" placeholder="Статус оплаты" class="form-control" type="text">
                <label for="paymentstatus">Статус оплаты</label>
            </div>
            <div class="form-floating">
                <input name="datecreation" id="datecreation" placeholder="Дата создания" class="form-control" type="date">
                <label for="datecreation">Дата создания</label>
            </div>
            <button type="submit" class="ms-auto btn btn-primary">Создать</button>
        </form>
    </div>
</body>

</html>