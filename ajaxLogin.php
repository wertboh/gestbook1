<?php
session_start();
$email = $_POST['email'];
$pass = $_POST['pass'];

$db = new PDO('mysql:dbname=registeruser;host=127.0.0.1', 'root', 'root');
$stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$hes = substr($data[0]['pass'], 0, 60);
if (!empty($email) && !empty($pass)) {
    if (password_verify($pass, $hes) && $email == $data[0]['email']) {
        $_SESSION['id_user'] = $data[0]['id_user'];
        $result['is_login'] = true;
        $_SESSION['auth'] = true;
    } else {
        $_SESSION['auth'] = false;
        $result['is_login'] = false;
    }

}
echo json_encode($result);