<?php
require '../api/crud.php';
$user_id = $_GET['user_id'];
$user = select("SELECT * FROM user WHERE userid=$user_id;")[0];
if ($user['userroleid'] != 3) {
    http_response_code(401);
    header('Content-Type: application/json');
    exit(json_encode(['status' => 'unauthorized']));
}

if (isset($_POST['action']) && $_POST['action'] == 'change_status') {
    $update = update("UPDATE `order` SET orderstatus='$_POST[orderstatus]' WHERE orderid=$_POST[orderid]");
    if ($update['status'] != 'success') echo "<script>alert('Не удалось обновить статус')</script>";
    $_POST= [];
}

$orders = select("SELECT 
orderid as '№', 
orderstatus as 'Статус', 
roomnumber as 'Название',
amountclients as 'Клиентов', 
hotelservices as 'Услуги', 
paymentstatus as 'Оплата',
datecreation as 'Создан'
FROM `order` WHERE paymentstatus='принят'");

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
    <a href="/" class="btn btn-sm btn-primary rounded position-absolute m-3 end-0 top-0">Выход</a>
    <div class="container pt-3">
        <div class="d-flex">
            <h4 class="h4 fw-bold title">Список принятых заказов</h4>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <?php foreach (array_keys($orders[0]) as $key) {
                        echo "<th>$key</th>";
                    } ?>
                    <th>Управление</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $row) {
                    $order_id = $row['№'];
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        if ($key == 'Создан') $value = date('d.m.Y', strtotime($value));
                        echo "<td>$value</td>";
                    }
                    echo "<td class='d-flex gap-1 flex-column'>
                        <form method='POST'>
                            <input type='hidden' name='action' value='change_status'/>
                            <input type='hidden' name='orderid' value='$order_id'/>
                            <button class='btn btn-sm btn-outline-success' name='orderstatus' value='готов'>Готов</button>
                            <button class='btn btn-sm btn-outline-primary' name='orderstatus' value='готовится'>Готовится</button>
                        </form>
                    </td>";
                    echo "</tr>";
                } ?>
            </tbody>
        </table>
    </div>
</body>

</html>