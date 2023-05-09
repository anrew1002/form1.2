<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="static/login.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="login">
        <form action="" method="POST">
            <table>
                <tr>
                    <td colspan="2">
                        <label for="username">Логин:<br></label>
                        <input type="txt" name="username" id="name" value="<?= htmlspecialchars($postData["username"] ?? "") ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label for="username">Пароль:<br></label>
                        <input type="txt" name="password" id="name" value="<?= htmlspecialchars($postData["password"] ?? "") ?>">
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" value="Send"></td>
                </tr>
            </table>
        </form>
    </div>

</body>

</html>