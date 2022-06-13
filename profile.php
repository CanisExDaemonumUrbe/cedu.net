<?php
    include './scripts/extensions/db_connect.php';
    include './scripts/extensions/session.php';

    my_session_start();

    function calculate_age($birthday) {

        $birthday_timestamp = strtotime($birthday);
        $age = date('Y') - date('Y', $birthday_timestamp);

        if (date('md', $birthday_timestamp) > date('md')) {
          $age--;
        }
        return $age;
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница пользователя</title>
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header-footer.css">
    <link rel="stylesheet" href="./css/profile.css">
</head>
<body>
    <div class="page">

        <header>
            <lable class="header_lable">CEDU.NET</lable>
        </header>

    <?php
        $userId = $_GET['id'];

        $query = "SELECT * FROM users WHERE id='$userId'";
		$user = mysqli_fetch_assoc($link->query($query));

        $login = $user['login'];
        $status = $user['status'];
        $banned; if($user['banned'] == 0) {$banned = "Нет";} else {$banned = "Да";}
        $surname = $user['surname'];
        $name = $user['name'];
        $patronymic = $user['patronymic'];
        $dateOfBirth = date_format(date_create($user['dateOfBirth']),"d.m.Y");
        $age = calculate_age($dateOfBirth);
        $email = $user['email'];
        $regDate = date_format(date_create($user['registrationDate']),"d.m.Y");
        ?>
    <div class="content-wrapper">
        <div class="content">
            <span class="content_main-lable">Основные данные</span>
            <table class="info-table" border=2px>
                <thead>
                    <tr>
                        <td>Логин: <?php echo $login; ?></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Роль в системе: <?php echo $status; ?></td> 
                    </tr>
                    <tr>
                        <td>Бан в системе: <?php echo $banned; ?></td> 
                    </tr>
                    <tr>
                        <td>ФИО: <?php echo $surname." ".$name." ".$patronymic; ?></td> 
                    </tr>
                    <tr>
                        <td>Дата рождения: <?php echo $dateOfBirth; ?></td>
                    </tr>
                    <tr>
                        <td>Возраст: <?php echo $age; ?></td>
                    </tr>
                    <tr>
                        <td>Email: <?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td>Дата регистрации: <?php echo $regDate; ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="content_menubar">
                <?php
                    if ($userId == my_session_get('id')){
                        ?>
                            <p><a href='personalArea.php'>Изменить данные</a></p>
                            <p><a href='deleteProfile.php'>Удаление аккаунта</a></p>
                        <?php
                    }
                ?>
                <p><a href='index.php'>Главная страница</a></p>
            </div>
        </div>
    </div>

    <footer>
        <lable class="footer_lable">Учебный проект. Автор: Гелимянов Данил</lable>
    </footer>

    </div>
</body>
</html>