<html>
<head>
    <style>

    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
</body>
</html>

<html>
<head>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
</head>
<body>
<form method="post" id="reply_form" action="">
    <a href="logout.php" class="my-button">
        <center>Log out</center>
    </a>
    <center>
        <h3>Guest book</h3>
        <label>
                <textarea rows="4" required cols="45" name="comments" placeholder="Write you comment.."
                          style="resize: none;"></textarea>
        </label><br>
        <input type="submit"  name="submitbtn" id="button_reply">
        <input type="reset" value="Reset"><br>

    </center>
</form>
<div id="replyresult_form"></div>
<script src="ajaxReply"></script>
</body>
</html>