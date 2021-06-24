<html>
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


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

<form method="post" id="login_form" action="">
    <center>
        <fieldset style="...">
            <legend><h3>Login</h3></legend>
            <input type="email" id="email" name="email" required placeholder="E-mail"><br>
            <input type="password" id="pass" name="pass" required placeholder="Password"><br>
            <hr>
            <button  type="submit" value="Submit" id="button_login" > </button>
            <input type="reset" value="Reset"><br>
            <font size="2" color="gray" face="Arial">If you don`t have account.
                Please click <a href="register.php">here</a></font>
        </fieldset>
    </center>
</form>
<div id="loginresult_form"></div>
<script src="ajaxLogin.js"></script>
</body>
</html>


