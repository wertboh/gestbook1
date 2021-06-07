<?php
session_start();

echo '
<html>
<head>
<!--    <meta charset="UTF-8">-->
    <title>Login</title>
    <style>
        body {
            background: linear-gradient(45deg, #EECFBA, #C5DDE8);
        }

        H3 {
            font-size: 140%;
            font-family: Verdana, Georgia, Helvetica, sans-serif;
            color: #20B2AA;

        }

        fieldset {
            border: border: 1rem solid;
            width: 100px;
            background: linear-gradient(45deg, #EECFBA, #ffff80);
        }

        input[type=submit], input[type=reset] {
            background-color: #20B2AA;
            color: white;
            padding: 4px 16px;
            margin: 4px 2px;
            border: 1px solid #ccc;
            width: 100px;
        }

        input[type=password] {
            border-radius: 4px;
            padding: 12px 20px;
            margin: 4px 0;
            border: 1px solid #ccc;
            width: 250px;
        }

        input[type=email] {
            border-radius: 4px;
            padding: 12px 20px;
            margin: 4px 0;
            border: 1px solid #ccc;
            width: 250px;
        }
    </style>
</head>
<body>
<form action="" method="post">
    <center>
        <fieldset style="...">
            <legend><h3>Login</h3></legend>
            <input type="email" name="email" required placeholder="E-mail"><br>
            <input type="password" name="pass" required placeholder="Password"><br>
            <hr>
            <input type="submit" value="Submit">
            <input type="reset" value="Reset"><br>
            <font size="2" color="gray" face="Arial">If you don`t have account.
                Please click <a href="register.php">here</a></font>
        </fieldset>
    </center>
</form>
</body>
</html>';

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
        echo '<center>' . '<font size="2" color="gray" face="Arial">'
            . 'Now you are login' . '</font>' . '</center>';
        $_SESSION['id_user'] = $data[0]['id_user'];
        $_SESSION['auth'] = true;
    } else {
        echo '<center>' . '<font size="2" color="gray" face="Arial">' .
            'Invalid password or email. Please check your data' . '</font>' . '</center>';
        $_SESSION['auth'] = false;
    }
    if (isset($_SESSION['id_user'])) {
        echo '<font size="2" color="gray" face="Arial">' .
            'Now you can write your comment. Click <a href="reply.php">here</a>.' . '</font>';
//        header("Location: reply.php");

    }
}

?>
