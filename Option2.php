<?php
session_start();
if (!$_SESSION['auth']) {
    header('Location: login.php');
    die();
} else {
    if (!empty($_POST['comments'])) {
        header("Location: http://gestbook/Option2.php");
    } elseif (!empty($_GET['reply'])) {
        header("Location: http://gestbook/Option2.php");
    }
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

    $stmt5 = $db->prepare('SELECT * FROM comment WHERE id_maternal != "NULL"');
    $stmt5->execute();
    $data5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $db->prepare('SELECT * FROM comment ');
    $stmt->execute();
    $data1 = $stmt->rowCount();

    $stmt0 = $db->prepare('SELECT * FROM comment WHERE id_maternal != "NULL"');
    $stmt0->execute();
    $data0 = $stmt0->rowCount();

    echo '<br><div class="accordion" id="accordionExample">
    <div class="accordion-item">';


    function button($db, $DATA, $data, $date, $i)
    {
        echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $i . '" aria-expanded="false" aria-controls="collapseTwo"
style="background-color: deeppink;
                color: white;
                padding: 2px 8px;
                margin: 18px 10px;
                border: 1px solid #ccc;
                width: 100px;
                text-decoration: none;" name="reply">
            Reply</button>';
        echo '<div id="collapse' . $i . '" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion1">
      <div class="accordion-body">
      <form action="" method="get"><textarea rows="4" required cols="45" name="reply" placeholder="Write you comment.."
                          style="resize: none;"></textarea><br>';

        echo '<input type="Submit" value="Submit" name="' . $i . '">
<input type="reset" value="Reset" name="' . $i . '"></form>';
        echo '</div>
    </div>';
        echo '</div></div>';


        if (isset($_GET[$i])) {

            $statement1 = $db->prepare('INSERT INTO comment (comments, date, firstname,lastname, id_maternal)VALUE(:comments, :date, :firstname, :lastname, :id_maternal)');
            $statement1->bindParam(':comments', $_GET['reply']);
            $statement1->bindParam(':date', $date);
            $statement1->bindParam(':firstname', $data[0]['firstname']);
            $statement1->bindParam(':lastname', $data[0]['lastname']);
            $statement1->bindParam(':id_maternal', $DATA[$i]['id_comment']);
            $statement1->execute();
        }
    }

    function replies($DATA, $DATAd, $counter, $data0, $db, $data, $date, $i)
    {
        if ($counter < $data0) {
            foreach ($DATAd as $item) {
                if ($DATA == $item['id_maternal']) {
                    echo '<br><big>' . $item['firstname'] . ' ' . $item['lastname'] . '</big>' . ' ' . '<small>' . $item['date'] . '</small>'
                        . '<br><div style="border: 2px solid deeppink; width: 1000px; border-radius: 10px; background: lightyellow; word-break: break-all;
padding-left:20px; padding-top:5px; padding-right:35px; padding-bottom:10px">' . $item['comments'] . '</div>';

                    button($db, $DATA, $data, $date, $item['id_comment']);
                }
            }
            if ($item['amount_child'] > 0) return replies($item['id_maternal'], $DATAd, $counter + 1, $data0, $db, $data, $date, $i);

        }
    }

    foreach ($data4 as $value) {
        if ($value['id_maternal'] == NULL) {
            echo '<br><big>' . $value['firstname'] . ' ' . $value['lastname'] . '</big>' . ' ' . '<small>' . $value['date'] . '</small>';
            echo '<p style="border: 2px solid yellow; width: 1000px; border-radius: 10px; background: pink; word-break: break-all;
padding-left:20px; padding-top:5px; padding-right:35px; padding-bottom:10px">' . $value['comments'] . '</p>';
            button($db, $value, $data, $date, $value['id_comment']);

            replies($value['id_maternal'], $data5, 0, $data0, $db, $data, $date, 0);
        }
    }
    $statement2 = $db->prepare('INSERT INTO comment (comments, date, firstname,lastname)VALUE(:comments, :date, :firstname, :lastname)');
    $statement2->bindParam(':comments', $comments);
    $statement2->bindParam(':date', $date);
    $statement2->bindParam(':firstname', $data[0]['firstname']);
    $statement2->bindParam(':lastname', $data[0]['lastname']);
    $statement2->execute();
}