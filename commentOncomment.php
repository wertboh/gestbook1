<html>
<head>
  <style>
      input[type=submit], input[type=reset] {
          background-color: #20B2AA;
          color: white;
          padding: 4px 16px;
          margin: 4px 2px;
          border: 1px solid #ccc;
          width: 100px;
      }
      .accordion-item{
          background: linear-gradient(50deg, #EECFBA, #C5DDE8);
          width: 1000px
      }
  </style>
</head>
</html>
<?php
$comments = $_POST['comments'];
$date = date("d-m-Y, h:i:s");
$db = new PDO ('mysql:dbname=registeruser;host=127.0.0.1', 'root', 'root');

$stmt1 = $db->prepare('SELECT comments, date, firstname, lastname FROM comment');
$stmt1->execute();
$data1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

echo '<br><div class="accordion" id="accordionExample">
    <div class="accordion-item">';
foreach ($data1 as $key => $value) {
echo '<br><big>' . $value['firstname'] . ' ' . $value['lastname'] . '</big>' . ' ' . '<small>' . $value['date'] . '</small>';
echo '<div style="border: 2px solid yellow; width: 1000px; border-radius: 10px; background: pink; word-break: break-all;
padding-left:20px; padding-top:5px; padding-right:35px; padding-bottom:10px">' . $value['comments'] . '</div>';

echo ' <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapseOne" 
        style="background-color: #20B2AA;
                color: white;
                padding: 2px 8px;
                margin: 18px 10px;
                border: 1px solid #ccc;
                width: 100px;
                text-decoration: none;" name="reply">
            Replies</button>

        <div id="collapse' . $key . '" class="accordion-collapse collapse show1" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the .accordion-flush class. This is the first items accordion body.<code>.accordion-flush</code> class. This is the first items accordion body.
        </div>
    </div>';
    echo '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $key . '" aria-expanded="false" aria-controls="collapseTwo"
style="background-color: deeppink;
                color: white;
                padding: 2px 8px;
                margin: 18px 10px;
                border: 1px solid #ccc;
                width: 100px;
                text-decoration: none;" name="reply">
            Reply</button>
    <div id="collapse' . $key . '" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion1">
      <div class="accordion-body">
      <form action="" method="post"><textarea rows="4" required cols="45" name="replies" placeholder="Write you comment.."
                          style="resize: none;"></textarea>
            <br><input type="submit" value="Submit" name="submit"  >
            <input type="reset" value="Reset"></form> 
      </div>
    </div>
 <br>';
}
echo '</div></div>';
if ($_POST['submit'] == 'Submit')
$replies = $_POST['replies'];
?>