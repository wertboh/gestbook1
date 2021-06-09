<?php
session_start();
if (!$_SESSION['auth']) {
    header('Location: login.php');
    die();
} else {
    if (!empty($_POST['comments'])) {
        header("Location: http://gestbook/reply.php");
    }
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

            input[type=submit], input[type=reset] {
                background-color: #20B2AA;
                color: white;
                padding: 4px 16px;
                margin: 4px 2px;
                border: 1px solid #ccc;
                width: 100px;
            }

            .my-button {
                background-color: #20B2AA;
                color: white;
                padding: 2px 8px;
                margin: 18px 10px;
                border: 1px solid #ccc;
                width: 100px;
                float: right;
                text-decoration: none;

            }

        </style>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    <body>

    <form method="post">
        <a href="logout.php" class="my-button">
            <center>Log out</center>
        </a>
        <center>
            <h3>Guest book</h3>
            <label>
                <textarea rows="4" required cols="45" name="comments" placeholder="Write you comment.."
                          style="resize: none;"></textarea>
            </label><br>
            <input type="submit" value="Submit" name="submitbtn"  >
            <input type="reset" value="Reset"><br>

        </center>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    </body>
    </html>
    <?php
    $comments = $_POST['comments'];
    $date = date("d-m-Y, h:i:s");
    $db = new PDO ('mysql:dbname=registeruser;host=127.0.0.1', 'root', 'root');

    $stmt1 = $db->prepare('SELECT comments, date, firstname, lastname, id_comment FROM comment');
    $stmt1->execute();
    $data1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    include 'commentOncomment.php';

    $db = new PDO ('mysql:dbname=registeruser;host=127.0.0.1', 'root', 'root');
    $stmt = $db->prepare('SELECT * FROM user WHERE id_user = :id_user');
    $stmt->bindParam(':id_user', $_SESSION['id_user']);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);



    $statement = $db->prepare('INSERT INTO comment (comments, date, firstname,lastname)VALUE(:comments, :date, :firstname, :lastname)');
    $statement->bindParam(':comments', $comments);
    $statement->bindParam(':date', $date);
    $statement->bindParam(':firstname', $data[0]['firstname']);
    $statement->bindParam(':lastname', $data[0]['lastname']);
    $statement->execute();

    $stmt2 = $db->prepare('INSERT INTO commentoncomment (date, firstname, lastname, idComment, replies) 
VALUE (":date", "firstname", ":lastname", 2, ":replies")');
//    $stmt2->bindParam(':date', $date);
//    $stmt2->bindParam(':firstname',$data[0]['firstname']);
//    $stmt2->bindParam(':lastname',$data[0]['lastname']);
//    $stmt2->bindParam(':idComment',$data1[0]['id_comment']);
//    $stmt2->bindParam(':replies',$replies);
    $stmt2->execute();
}
?>
