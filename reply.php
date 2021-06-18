<?php
session_start();
if (!$_SESSION['auth']) {
    header('Location: login.php');
    die();
} else {
    if (!empty($_POST['comments'])) {
        header("Location: http://gestbook/reply.php");
    } elseif (!empty($_GET['reply'])) {
        header("Location: http://gestbook/reply.php");
    }
    include 'html.php';

    $comments = $_POST['comments'];
    $date = date("d-m-Y, h:i:s");

    $db = new PDO ('mysql:dbname=registeruser;host=127.0.0.1', 'root', 'root');
    $stmt = $db->prepare('SELECT * FROM user WHERE id_user = :id_user');
    $stmt->bindParam(':id_user', $_SESSION['id_user']);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt1 = $db->prepare('SELECT * FROM comment ');
    $stmt1->execute();
    $data1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $stmt2 = $db->prepare('SELECT * FROM comment WHERE id_maternal != "NULL"');
    $stmt2->execute();
    $data2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    echo '<br><div class="accordion" id="accordionExample">
    <div class="accordion-item">';


    function button($db, $data, $date, $i)
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
        echo $i;

        if (isset($_GET[$i])) {

            $statement1 = $db->prepare('INSERT INTO comment (comments, date, firstname,lastname, id_maternal)VALUE(:comments, :date, :firstname, :lastname, :id_maternal)');
            $statement1->bindParam(':comments', $_GET['reply']);
            $statement1->bindParam(':date', $date);
            $statement1->bindParam(':firstname', $data[0]['firstname']);
            $statement1->bindParam(':lastname', $data[0]['lastname']);
            $statement1->bindParam(':id_maternal', [$i]['id_comment']);
            $statement1->execute();

            $stmnt = $db->prepare('UPDATE comment SET amount_child = amount_child + 1  WHERE id_comment = :id_comment');
            $stmnt->bindParam(':id_comment', [$i]['id_comment']);
            $stmnt->execute();
        }
    }


    function replies($DATA1, $counter1, $DATA2, $counter2, $data0, $db, $data, $date, $i, $a)
    {
        if ($counter2 < $data0) {
            if ($a == $DATA2[$counter2]['id_maternal']) {
                echo '<br><big>' . $DATA2[$counter2]['firstname'] . ' ' . $DATA2[$counter2]['lastname'] . '</big>' . ' ' . '<small>' . $DATA2[$counter2]['date'] . '</small>'
                    . '<br><div style="border: 2px solid deeppink; width: 1000px; border-radius: 10px; background: lightyellow; word-break: break-all;
padding-left:20px; padding-top:5px; padding-right:35px; padding-bottom:10px">' . $DATA2[$counter2]['comments'] . '</div>';

                button($db, $data, $date, $DATA2[$counter2]['id_comment']);
            }
            return replies($DATA1, $counter1, $DATA2,$counter2 + 1, $data0, $db, $data, $date, $i, $a);
        }
    }

    function reply($DATA1, $counter1, $DATA2, $count1, $counter2, $data0, $db, $data, $date, $i, $a)
    {
        if ($counter1 < $count1) {

            if ($DATA1[$counter1]['id_maternal'] == NULL) {
                echo '<br><big>' . $DATA1[$counter1]['firstname'] . ' ' . $DATA1[$counter1]['lastname'] . '</big>' . ' ' . '<small>' . $DATA1[$counter1]['date'] . '</small>';
                echo '<p style="border: 2px solid yellow; width: 1000px; border-radius: 10px; background: pink; word-break: break-all;
padding-left:20px; padding-top:5px; padding-right:35px; padding-bottom:10px">' . $DATA1[$counter1]['comments'] . '</p>';
                button($db, $data, $date, $DATA1[$counter1]['id_comment']);

                replies($DATA1, $counter1, $DATA2,  0, $data0, $db, $data, $date, $i, $DATA1[$counter1]['id_comment']);
            }
            return reply($DATA1, $counter1 + 1, $DATA2,  $count1, $counter2, $data0, $db, $data, $date, $i, $a);
        }
    }

    $stmt = $db->prepare('SELECT * FROM comment ');
    $stmt->execute();
    $data3 = $stmt->rowCount();

    $stmt0 = $db->prepare('SELECT * FROM comment WHERE id_maternal != "NULL"');
    $stmt0->execute();
    $data0 = $stmt0->rowCount();


    reply($data1, 0, $data2,  $data3, 0, $data0, $db, $data, $date, 0, 0);


    $statement2 = $db->prepare('INSERT INTO comment (comments, date, firstname,lastname)VALUE(:comments, :date, :firstname, :lastname)');
    $statement2->bindParam(':comments', $comments);
    $statement2->bindParam(':date', $date);
    $statement2->bindParam(':firstname', $data[0]['firstname']);
    $statement2->bindParam(':lastname', $data[0]['lastname']);
    $statement2->execute();


}