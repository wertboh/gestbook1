<?php
session_start();
if (!$_SESSION['auth']) {
    header('Location: login.php');
    die();
}
else {
?>
    <html>
    <head>

        <title>Guest Book</title>
        <style>
            body {
                background: linear-gradient(45deg, #EECFBA, #C5DDE8);
            }

            H3 {
                font-size: 1000%;
                font-family: Bookman, URW Bookman L, serif;
                color: #20B2AA;
                margin-bottom: 100px;
            }

            input[type=submit], input[type=reset]{
                background-color: #20B2AA;
                color: white;
                padding: 4px 16px;
                margin: 4px 2px;
                border: 1px solid #ccc;
                width: 100px;
            }
            input:focus {
                outline: 3px solid transparent;
            }
            .my-button {
                background-color: #20B2AA;
                color: white;
                padding: 4px 16px;
                margin: 4px 2px;
                border: 1px solid #ccc;
                width: 100px;
                float: right;
            }

        </style>
    </head>
    <body>
    <form action="" method="post">
    <a href="logout.php"><button class="my-button">Log out</button></a>
        <center>
            <h3>Guest book</h3>
            <label>
<textarea name="comments" required placeholder="Write you comment.." rows="4" cols="50" style="resize: none;">

</textarea>
            </label><br>
            <input type="submit" value="Submit">
            <input type="reset" value="Reset"><br>
        </center>
    </form>
    </body>
    </html>
    <?php

    $comments = $_POST['comments'];
    $date = date("d-m-Y");


    $db = new PDO ('mysql:dbname=registeruser;host=127.0.0.1', 'root', 'root');

    $stmt1 = $db->prepare('SELECT comments, date, login FROM comment');
    $stmt1->execute();
    $data1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data1 as $key => $value) {
        echo '<br><big>' . $value['login'] . '</big>' . ' ' . '<small>' . $value['date'] . '</small>';
        echo '<div style="border: 2px solid yellow; width: 1000px; border-radius: 10px; background: pink; word-break: break-all;
padding-left:20px; padding-top:5px; padding-right:35px; padding-bottom:10px">' . $value['comments'] . '</div>';
    }

    $stmt = $db->prepare('SELECT * FROM user WHERE id_user = :id_user');
    $stmt->bindParam(':id_user', $_SESSION['id_user']);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $statement = $db->prepare('INSERT INTO comment (comments, date, login)VALUE(:comments, :date, :login)');
    $statement->bindParam(':comments', $comments);
    $statement->bindParam(':date', $date);
    $statement->bindParam(':login', $data[0]['login']);
    $statement->execute();
    unset($_POST);





}
?>
