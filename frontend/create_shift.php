<?php
require '../api/crud.php';
$user_id = $_GET['user_id'];
$user = select("SELECT * FROM user WHERE userid=$user_id;")[0];
if ($user['userroleid'] != 1) {
    http_response_code(401);
    header('Content-Type: application/json');
    exit(json_encode(['status' => 'unauthorized']));
}

$users = select("SELECT 
userid,
status,
lastname,
firstname,
middlename,
namerole
FROM user LEFT JOIN userrole USING(userroleid)");

if (
    isset($_POST['datestart']) && $_POST['datestart'] != '' &&
    isset($_POST['dateend']) && $_POST['dateend'] != ''
) {
    $insert = insert("INSERT INTO `shift` (datestart,dateend) VALUES ('$_POST[datestart]','$_POST[dateend]')");
    $id = select("SELECT LAST_INSERT_ID() as id")[0]['id'];
    $query="INSERT INTO userlist (userid,shiftid) VALUES ";
    foreach (explode(',',$_POST['userList']) as $value) {
        $query .= "($value,$id),";
    }
    $insert2 = insert(substr($query,0,-1));
    if ($insert['status'] != 'success' || $insert2['status'] != 'success') echo "<script>alert('Не удалось создать смену')</script>";
    $_POST = [];
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
        <h4 class="h4 title fw-bold mb-3">Создание нового заказа</h4>
        <form class="d-flex flex-column gap-2" method="POST">
            <div class="form-floating">
                <input required name="datestart" id="datestart" placeholder="Дата с" class="form-control" type="date">
                <label for="datestart">Дата с</label>
            </div>
            <div class="form-floating">
                <input required name="dateend" id="dateend" placeholder="Дата по" class="form-control" type="date">
                <label for="dateend">Дата по</label>
            </div>
            <div class="form-floating">
                <input required name="userList" id="userList" placeholder="Сотрудники" class="form-control" type="text" readonly>
                <label for="userList">Сотрудники</label>
            </div>
            <div class="form-floating">
                <select id="users" class="form-select">
                    <option selected disabled>Выберите сотрудников</option>
                    <?php
                    foreach ($users as $row) {
                        echo "<option value='$row[userid]'>$row[userid] $row[namerole], $row[lastname] $row[firstname] $row[middlename]</option>";
                    }
                    ?>
                </select>
                <label for="users">Сотрудники</label>
            </div>
            <button type="submit" class="ms-auto btn btn-primary">Создать</button>
        </form>
    </div>
    <script>
        function selectUser(e) {
            const {
                value,
                name
            } = e.target
            const list = document.getElementById('userList').value === '' ? [] : document.getElementById('userList').value.split(',')
            if (list.includes(value)) return document.getElementById('userList').value = list.filter(el=>el!==value).join(',')
            document.getElementById('userList').value = [...list, value]
        }

        document.getElementById('users').addEventListener('change', selectUser)
    </script>
</body>

</html>