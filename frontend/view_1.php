<?php
require '../api/crud.php';
$user_id = $_GET['user_id'];
$user = select("SELECT * FROM user WHERE userid=$user_id;")[0];
if ($user['userroleid'] != 1) {
    http_response_code(401);
    header('Content-Type: application/json');
    exit(json_encode(['status' => 'unauthorized']));
}

if (isset($_POST['action']) && $_POST['action'] == 'quit') {
    $update = update("UPDATE user SET status='Уволен' WHERE userid=$_POST[userid]");
    if ($update['status'] != 'success') echo "<script>alert('Не удалось уволить сотрудника')</script>";
    $_POST = [];
}

$orders = select("SELECT 
orderid as '№', 
orderstatus as 'Статус', 
roomnumber as 'Название',
amountclients as 'Клиентов', 
hotelservices as 'Услуги', 
paymentstatus as 'Оплата',
datecreation as 'Создан'
FROM `order`");

$users = select("SELECT 
userid as '№',
status as 'Статус',
lastname as 'Фамилия',
firstname as 'Имя',
middlename as 'Отчество',
namerole as 'Должность'
FROM user LEFT JOIN userrole USING(userroleid)");

$shifts = select("SELECT datestart as 'С',dateend as 'По', GROUP_CONCAT(CONCAT(lastname,' ',firstname,' ',middlename) SEPARATOR ',') as 'Сотрудники' FROM shift LEFT JOIN userlist USING(shiftid) LEFT JOIN user USING(userid) GROUP BY shiftid");
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
            <h4 class="h4 fw-bold title">Список заказов</h4>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <?php foreach (array_keys($orders[0]) as $key) {
                        echo "<th>$key</th>";
                    } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $row) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        if ($key == 'Создан') $value = date('d.m.Y', strtotime($value));
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                } ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <h4 class="h4 fw-bold title">Список сотрудников</h4>
            <a class="btn btn-sm btn-primary" href="/frontend/register.php?user_id=<?php echo $user_id; ?>">Добавить сотрудника</a>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <?php foreach (array_keys($users[0]) as $key) {
                        echo "<th>$key</th>";
                    } ?>
                    <th>Управление</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $row) {
                    $u_id = $row['№'];
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        if ($key == 'Создан') $value = date('d.m.Y', strtotime($value));
                        echo "<td>$value</td>";
                    }
                    echo "<td class='d-flex gap-1 flex-column'>
                        <form method='POST'>
                            <input type='hidden' name='userid' value='$u_id'/>
                            <input type='hidden' name='action' value='quit'/>
                            <button type='submit' class='btn btn-sm btn-outline-danger'>Уволить</button>
                        </form>
                    </td>";
                    echo "</tr>";
                } ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <h4 class="h4 fw-bold title">Список смен</h4>
            <a class="btn btn-sm btn-primary" href="/frontend/create_shift.php?user_id=<?php echo $user_id; ?>">Добавить смену</a>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <?php foreach (array_keys($shifts[0]) as $key) {
                        echo "<th>$key</th>";
                    } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shifts as $row) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        if ($key == 'С' || $key == 'По') $value = date('d.m.Y', strtotime($value));
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                } ?>
            </tbody>
        </table>
    </div>
</body>

</html>