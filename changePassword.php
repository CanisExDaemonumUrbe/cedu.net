<?php
    include './scripts/extensions/db_connect.php';
    include './scripts/extensions/session.php';

    my_session_start();
    echo my_session_get('auth')."<br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Изменение пароля</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <header>
        <div class="userInfo">
            <h1>Редактирование пароля пользователя: <?php echo my_session_get('login') ?></h1>
            <p><span>Вы авторизованы в системе.<br>Здравствуйте, <?php echo my_session_get('login'); ?>.</span></p>
            <p><span>Ваша роль в системе: <?php echo my_session_get('status').".<br>Ваш Id: ".my_session_get('id'); ?></span>
        </div>
        <div class="menuBar">
            <?php if(my_session_get('status') == 'admin') echo("<p><a href='admin.php'>Панель администратора</a></p>"); ?>
        </div>
    </header>
    <?php

        if(my_session_get('auth') == 1){

            $userId = my_session_get('id');

            $query = "SELECT * FROM users WHERE id='$userId'";
            $user = mysqli_fetch_assoc($link->query($query));

            $userHash = $user['password'];
            $oldUserPassword = $_POST['oldPassword'];
            $newUserPassword = $_POST['newPassword'];
            $newUserConfirm = $_POST['newConfirm'];

            if (!empty($oldUserPassword) && !empty($newUserPassword) && !empty($newUserConfirm)){

                $newPasswordLenCheck = strlen($newUserPassword) >= 6 && strlen($newUserPassword) <= 12;
                $oldPasswordCorrectCheck = password_verify($oldUserPassword, $userHash);
                
                if ($newPasswordLenCheck && $oldPasswordCorrectCheck){

                    if ($newUserPassword == $newUserConfirm){

                        $newUserPasswordHash = password_hash($newUserPassword, PASSWORD_DEFAULT);

                        $query = "UPDATE users SET password='$newUserPasswordHash' WHERE id='$userId'";
                        $link->query($query);
    
                        header("location: ./profile.php?id=$userId");

                    } else {
                        $confirmErrorMessage = true;
                    }

                } else {
                    if(!$oldPasswordCorrectCheck) {$oldPasswordCorrectMessage = true;}
                    if(!$newPasswordLenCheck) {$passwordLenCheckMessage = true;}
                }

            } else {
                $emptyErrorMessage = true;;
            }

            ?>
            <form action="" method="POST">

                <?php if ($oldPasswordCorrectMessage) {echo "<label>Все поля должны быть заполнены!</label><br>";}?>

                <?php if ($oldPasswordCorrectMessage) {echo "<label>Неверный пароль!</label><br>";}?>
                <p>
                    <label>Введите старый пароль</label><br>
                    <input name="oldPassword" placeholder="Пароль" type="password">
                </p>  

                <?php if ($passwordLenCheckMessage) {echo "<label>Длина пароля должна быть от 6 до 12 символов!</label><br>";}?>
                <p>
                    <label>Придумайте новый пароль: от 6 до 12 символов</label><br>
                    <input name="newPassword" placeholder="Пароль" type="password">
                </p>

                <?php if ($confirmErrorMessage) {echo "<label>Пароли не совпадают!</label><br>";}?>
                <p>
                    <label>Подтвердите новый пароль</label><br>
                    <input name="newConfirm" placeholder="Подтвержение" type="password">
                </p>

                <p><input type="submit" value="Сохранить изменения"></p>
                <p><a href="profile.php?id=<?php echo $userId; ?>">Назад</a?</p>
            </form>

        <?php

        }

        if(my_session_get('auth') == 0){
            ?>
                <span>Вы не авторизованы в системе.<br>Пожалуйста авторизуйтесь или зарегистрируйтесь.</span>
                <p><a href="login.php">Войти в систему</a></p>    
                <p><a href="register.php">Регистрация в системе</a></p>    
            <?php
        }
    ?>
</body>
</html>