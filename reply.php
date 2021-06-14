<?php
session_start();
if (!$_SESSION['auth']) {
    header('Location: login.php');
    die();
} else {
    if (!empty($_POST['comments'])) {
        header("Location: http://gestbook/reply.php");
    } elseif (!empty($_GET['replies'])) header("Location: http://gestbook/reply.php");
    include 'html.php';

    $comments = $_POST['comments'];
    $date = date("d-m-Y, h:i:s");


    $db = new PDO ('mysql:dbname=registeruser;host=127.0.0.1', 'root', 'root');
    $stmt = $db->prepare('SELECT * FROM user WHERE id_user = :id_user');
    $stmt->bindParam(':id_user', $_SESSION['id_user']);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt4 = $db->prepare('SELECT * FROM comment ');
    $stmt4->execute();
    $data4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);

    $stmt5 = $db->prepare('SELECT * FROM comment ');
    $stmt5->execute();
    $data5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);

$i = 1;
$j = 0;
    echo '<br><div class="accordion" id="accordionExample">
    <div class="accordion-item">';

    foreach ($data4 as $key => $value) {
        if ($value['id_maternal'] == NULL) {
            echo '<br><big>' . $value['firstname'] . ' ' . $value['lastname'] . '</big>' . ' ' . '<small>' . $value['date'] . '</small>';
            echo '<div style="border: 2px solid yellow; width: 1000px; border-radius: 10px; background: pink; word-break: break-all;
padding-left:20px; padding-top:5px; padding-right:35px; padding-bottom:10px">' . $value['comments'] . '</div>';

            $i += 2;

            echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $i . '" aria-expanded="false" aria-controls="collapseTwo"
style="background-color: deeppink;
                color: white;
                padding: 2px 8px;
                margin: 18px 10px;
                border: 1px solid #ccc;
                width: 100px;
                text-decoration: none;" name="reply">
            Reply</button>
    <div id="collapse' . $i . '" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion1">
      <div class="accordion-body">
      <form action="" method="get"><textarea rows="4" required cols="45" name="reply" placeholder="Write you comment.."
                          style="resize: none;"></textarea><br>';

            echo '<input type="Submit" value="Submit" name="' . $key . '">
<input type="reset" value="Reset" name="' . $key . '"></form>';
            echo '</div>
    </div>';
            $j += 2;
            echo ' <button class="accordion-button collapsed" type="button" class="but-col" data-bs-toggle="collapse" data-bs-target="#collapse' . $j . '" aria-expanded="true" aria-controls="collapseOne"
        style="background-color: #20B2AA;
                color: white;
                padding: 2px 8px;
                margin: 18px 10px;
                border: 1px solid #ccc;
                width: 100px;
                text-decoration: none;" name="reply">
            Replies</button>

        <div id="collapse' . $j . '" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">';

            foreach ($data5 as $item) {
                if ($value['id_comment'] == $item['id_maternal']) {
                    echo '<br><big>' . $item['firstname'] . ' ' . $item['lastname'] . '</big>' . ' ' . '<small>' . $item['date'] . '</small>';
                    echo '<div style="border: 2px solid deeppink; width: 1000px; border-radius: 10px; background: lightyellow; word-break: break-all;
padding-left:20px; padding-top:5px; padding-right:35px; padding-bottom:10px">' . $item['comments'] . '</div>';
                }
            }
            echo '</div></div>';
        }
            if (isset($_GET[$key])) {

                $statement1 = $db->prepare('INSERT INTO comment (comments, date, firstname,lastname, id_maternal)VALUE(:comments, :date, :firstname, :lastname, :id_maternal)');
                $statement1->bindParam(':comments', $_GET['reply']);
                $statement1->bindParam(':date', $date);
                $statement1->bindParam(':firstname', $data[0]['firstname']);
                $statement1->bindParam(':lastname', $data[0]['lastname']);
                $statement1->bindParam(':id_maternal', $value['id_comment']);
                $statement1->execute();
            }
    }
    $statement2 = $db->prepare('INSERT INTO comment (comments, date, firstname,lastname)VALUE(:comments, :date, :firstname, :lastname)');
    $statement2->bindParam(':comments', $comments);
    $statement2->bindParam(':date', $date);
    $statement2->bindParam(':firstname', $data[0]['firstname']);
    $statement2->bindParam(':lastname', $data[0]['lastname']);
    $statement2->execute();
}
