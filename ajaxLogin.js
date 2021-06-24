$(document).ready(function () {
    $("form").submit(
        function () {
            sendAjaxForm("loginresult_form", "login_form", "ajaxLogin.php");
            return false;

        });
});

function sendAjaxForm(loginresult_form, login_form, url) {
    $.ajax({
            url: url,
            type: "POST",
            dataType: "html",
            data: $("#" + login_form).serialize(),
            success: function (response) {
                response = JSON.parse(response)

                console.log(response.is_login)
                if (response.is_login) {
                    window.location = "http://gestbook/reply.php";
                } else alert("Invalid password or email. Please check your data");
            },
            error: function (response) {

                alert("error");
                $("#loginresult_form").html("Ошибка. Данные не отправлены.");
            }
        }
    );

}


