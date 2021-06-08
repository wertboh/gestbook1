<?php
if (!empty($_POST)) {
    header('Location: login.php');
}
?>
<html>
<head>
    <title>Register</title>
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
            width: 1000px;
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

        input[type=text] {
            border-radius: 4px;
            padding: 12px 20px;
            margin: 4px 0;
            border: 1px solid #ccc;
            width: 250px;
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
<body>
<form action="" method="post">
    <center>
        <fieldset style="width:0px">
            <legend><h3>Register</h3></legend>
            <input type="text" name="login" required placeholder="Login"><br>
            <br><input type="email" name="email" required placeholder="E-mail"><br>
            <br><input type="password" name="pass" required placeholder="Password"><br>
            <br><input type="text" name="firstname" required placeholder="Firstname"><br>
            <br><input type="text" name="lastname" required placeholder="Lastname"><br>
            <br><input type="text" name="phnumber" placeholder="Phone Number">
            <hr>
            <input type="submit" value="Submit">&nbsp
            <input type="reset" value="Reset"><br>
            <font size="2" color="gray" face="Arial">If you have account. Please click <a
                    href="login.php">here</a></font>
        </fieldset>
    </center>
</form>
</body>
</html>
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
?>
