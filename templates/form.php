<html>

<head>
    <meta charset="utf-8">
    <link href="static/index.css" rel="stylesheet" type="text/css">
    <title>Form</title>
</head>

<body>
    <div class="form-conference">
        <!-- TITLE -->
        <div class="form-conference--inner">
            <span class="title">
                <h1>Форма участника конференции</h1>
                <?php
                $ip = $_SERVER['REMOTE_ADDR'];
                $ip_file = 'txt_data/ip.txt';
                $expire = time() + 60 * 60 * 24 * 30;

                if (!isset($_COOKIE['visited'])) {
                    file_put_contents($ip_file, $ip . "\n", FILE_APPEND | LOCK_EX);
                    setcookie('visited', 'yes', $expire);
                }

                $unique_ips = count(array_unique(explode("\n", file_get_contents($ip_file)))) - 1;
                echo "Уникальных по IP посетителей: " . $unique_ips;
                $users = count(glob(session_save_path() . '/*'));
                echo "<br>Пользователей по сессиям: " . $users;
                $counter = file_get_contents('txt_data/hits.txt') + 1;
                echo "<br>Хитов: " . $counter;
                file_put_contents('txt_data/hits.txt', $counter);

                ?>
                <p>
                    Это форма необходимая для участия в данной конференции
                </p>
            </span>
            <?php

            use App\View;

            $view = new View;
            if (!empty($errors)) {
                $view->render('partials/unsuccsesful', ['errors' => $errors]);
            }
            if (!empty($succses)) {
                $view->render('partials/succsesful');
            }
            ?>
            <form action="" method="POST">
                <!-- HEAD ID -->
                <fieldset class="form" id="1">
                    <table>
                        <tr>
                            <td>
                                <div class="td"><label for="name">Имя:<br></label><input type="txt" name="name" id="name" value="<?= htmlspecialchars($postData["name"] ?? "") ?>" required placeholder="Краткий ответ">
                                    <hr>
                                </div>
                            </td>
                        <tr>
                            <td>
                                <div class="td"><label for="lastname">Фамилия:<br></label><input type="txt" name="lastname" id="SurName" value="<?= htmlspecialchars($postData["lastname"] ?? "") ?>" required placeholder="Краткий ответ">
                                    <hr>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><label for="email">E-mail:<br></label><input type="email" name="email" id="E-mail" value="<?= htmlspecialchars($postData["email"] ?? "") ?>" placeholder="example@gmail.com">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><label for="phone">Телефон<br></label><input type="txt" name="phone" id="ID" value="<?= htmlspecialchars($postData["phone"] ?? "") ?>" placeholder="79501001003" required>
                                <hr>
                            </td>
                        </tr>
                    </table>
                </fieldset>

                <fieldset class="form" id="4">
                    <table>

                        <tr>
                            <td>
                                <label for="theme">Выберите интересующую тематику:</label>
                                <select name="theme">
                                    <option value="business" <?php echo ((htmlspecialchars($postData["theme"] ?? "") == 'business') ? "selected" : ''); ?>>Бизнес</option>
                                    <option value="tech" <?php echo ((htmlspecialchars($postData["theme"] ?? "") == 'tech') ? "selected" : ''); ?>>Технологии</option>
                                    <option value="advert" <?php echo ((htmlspecialchars($postData["theme"] ?? "") == 'advert') ? "selected" : ''); ?>>Реклама и Маркетинг</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="money">Выберите способ оплаты:</label>
                                <select name="money">
                                    <option value="WebMoney" <?php echo ((htmlspecialchars($postData["money"] ?? "") == 'WebMoney') ? "selected" : ''); ?>>WebMoney</option>
                                    <option value="Iandex" <?php echo ((htmlspecialchars($postData["money"] ?? "") == 'Iandex') ? "selected" : ''); ?>>Яндекс.Деньги</option>
                                    <option value="PayPal" <?php echo ((htmlspecialchars($postData["money"] ?? "") == 'PayPal') ? "selected" : ''); ?>>PayPal</option>
                                    <option value="Credit" <?php echo ((htmlspecialchars($postData["money"] ?? "") == 'Credit') ? "selected" : ''); ?>>Кредитная карта</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="offer">
                                <label for="mailing">
                                    Согласшаюсь на рассылку о конференции
                                </label><input name='mailing' type="checkbox" id="Sure" checked required>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="offer">
                                <label for="processing">Подтверждаю обработку
                                    данных</label>
                                <input name='processing' type="checkbox" id="Sure2">
                            </td>
                        </tr>
                        <tr>
                            <td><input type="submit" value="Войти"></td>
                        </tr>
                    </table>
                </fieldset>


            </form>
        </div>
    </div>
</body>

</html>