<?php
$login = $_POST['login'];
$email = $_POST['email'];
$pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phnumber = $_POST['phnumber'];

$db = new PDO ('mysql:dbname=registeruser;host=127.0.0.1', 'root', 'root');
$statement = $db->prepare('INSERT INTO user (login, email, pass, firstname, lastname, phnumber)VALUE(:login, :email, :pass, :firstname,:lastname, :phnumber )');
$statement->bindParam(':login', $login);
$statement->bindParam(':email', $email);
$statement->bindParam(':pass', $pass);
$statement->bindParam(':firstname', $firstname);
$statement->bindParam(':lastname', $lastname);
$statement->bindParam(':phnumber', $phnumber);
$statement->execute();
if (!empty($login) && !empty($statement) && !empty($pass) && !empty($firstname) && !empty($lastname)) {
    $reg = true;
}
echo json_encode($reg);