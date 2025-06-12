<?php //auth.php
ini_set('display_errors', 1);        // Включить отображение ошибок
ini_set('display_startup_errors', 1); // Показывать ошибки при запуске PHP
error_reporting(E_ALL); 
require 'crud.php';

function check_user()
{
    $login = $_POST['login'];
    $password = $_POST['password'];
    $user = select("SELECT * FROM user WHERE login='$login' AND password='$password'");
    return $user;
}

$user = check_user();
$user_checked = count($user) > 0;
$user_id = $user[0]['userid'];
$user_role_id = $user[0]['userroleid'];

if ($user_checked) {
    header("Location: /frontend/view_$user_role_id.php?user_id=$user_id");
} else {
    http_response_code(401);
    header('Content-Type: application/json');
    exit(json_encode(['status' => 'unauthorized']));
}

?>
