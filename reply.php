<?php
session_start();
if (!$_SESSION['auth']) {
    header('Location: loginHtml.php');
    die();
} else {
    if (!empty($_POST['comments']) || !empty($_GET['reply'])) {
        header("Location: http://gestbook/reply.php");
    }
    include 'html.php';

    $date = date("d-m-Y, h:i:s");

    $db = new PDO ('mysql:dbname=registeruser;host=127.0.0.1', 'root', 'root');
    $stmt = $db->prepare('SELECT * FROM user WHERE id_user = :id_user');
    $stmt->bindParam(':id_user', $_SESSION['id_user']);
    $stmt->execute();
    $information_about_user = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt1 = $db->prepare('SELECT * FROM comment WHERE ISNULL(id_maternal)');
    $stmt1->execute();
    $getChildren = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $statement2 = $db->prepare('INSERT INTO comment (comments, date, firstname,lastname)VALUE(:comments, :date, :firstname, :lastname)');
    $statement2->bindParam(':comments', $_POST['comments']);
    $statement2->bindParam(':date', $date);
    $statement2->bindParam(':firstname', $information_about_user[0]['firstname']);
    $statement2->bindParam(':lastname', $information_about_user[0]['lastname']);
    $statement2->execute();

    echo '<br><div class="accordion" id="accordionExample">
    <div class="accordion-item">';

    function button($db, $information_about_user, $date, $nameButtom, $indent)
    {
        echo '<button class="buttonMain" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $nameButtom . '" aria-expanded="false" aria-controls="collapseTwo"
style="margin-left:' . $indent . 'px;" name="reply">
            Reply</button>';
        echo '<div id="collapse' . $nameButtom . '" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion1">
      <div class="accordion-body">
      <form action="" method="get"><textarea rows="4" required cols="45" name="reply" placeholder="Write you comment.." style="margin-left:' . $indent .
            '"></textarea><br>';

        echo '<input type="Submit" value="Submit" name="' . $nameButtom . '" style="margin-left:' . $indent . '">
<input type="reset" value="Reset" name="' . $nameButtom . '"></form>';
        echo '</div>
    </div>';
        echo '</div></div>';


        if (isset($_GET[$nameButtom])) {
            $statement1 = $db->prepare('INSERT INTO comment (comments, date, firstname,lastname, id_maternal)VALUE(:comments, :date, :firstname, :lastname, :id_maternal)');
            $statement1->bindParam(':comments', $_GET['reply']);
            $statement1->bindParam(':date', $date);
            $statement1->bindParam(':firstname', $information_about_user[0]['firstname']);
            $statement1->bindParam(':lastname', $information_about_user[0]['lastname']);
            $statement1->bindParam(':id_maternal', $nameButtom);
            $statement1->execute();
        }

    }

    function replies($db, $information_about_user, $date, $nameButtom, $comment, $indent)
    {
        $stmt2 = $db->prepare('SELECT * FROM comment WHERE  id_maternal = :id_comment');
        $stmt2->bindParam(':id_comment', $comment['id_comment']);
        $stmt2->execute();
        $replies = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        echo '<br><div style="margin-left:' . $indent . ';"><big>' . $comment['firstname'] . ' ' . $comment['lastname'] . '</big>' . ' ' . '<small>' . $comment['date'] . '</small></div>'
            . '<br><div style="margin-left:' . $indent . ';border: 2px solid deeppink; width: 1000px; border-radius: 10px; background: lightyellow; word-break: break-all;
padding-left:20px; padding-top:5px; padding-right:35px; padding-bottom:10px; ">' . $comment['comments'] . '</div>';
        button($db, $information_about_user, $date, $comment['id_comment'], $indent + 20);
        foreach ($replies as $item) {
            replies($db, $information_about_user, $date, $nameButtom, $item, $indent + 40);
        }
    }

    $indent = 10;

    foreach ($getChildren as $GETchildren) {
        replies($db, $information_about_user, $date, 0, $GETchildren, $indent);
    }

}