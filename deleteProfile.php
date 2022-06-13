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
    <title>Удаление аккаунта</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <header>
        <div class="userInfo">
            <h1>Удаление аккантуа: <?php echo my_session_get('login');?></h1>
            <p><span>Вы авторизованы в системе.<br>Здравствуйте, <?php echo my_session_get('login'); ?>.</span></p>
            <p><span>Ваша роль в системе: <?php echo my_session_get('status').".<br>Ваш Id: ".my_session_get('id'); ?></span>
        </div>
        <div class="menuBar">
            <?php if(my_session_get('status') == 'admin') echo("<p><a href='admin.php'>Панель администратора</a></p>"); ?>
        </div>
    </header>
    <?php
        $userId = my_session_get('id');

        $query = "SELECT * FROM users WHERE id='$userId'";
        $user = mysqli_fetch_assoc($link->query($query));

        $userPasswordHash = $user['password'];
        $userPassword = $_POST['password'];

        $passwordCorrectCheck = password_verify($userPassword, $userPasswordHash);

        if ($passwordCorrectCheck){

            $query = "DELETE FROM users WHERE id='$userId'";
            $link->query($query);

            my_session_set('id', -1);
            my_session_set('login', 'null');
            my_session_set('auth', 0);

            header('location: ./index.php');

        } else {
            $passwordCorrectMessage = true;
        }
    ?>

    <form action="" method="POST">
        <?php if ($passwordCorrectMessage) {echo "<label>Неверный пароль!</label><br>";}?>
        <p>
            <label>Для удаления аккаунта введите пароль</label><br>
            <input name="password" placeholder="Пароль" type="password">
        </p>
        <p><input type="submit" value="Удалить аккаунт"></p>
        <p><a href="profile.php?id=<?php echo $userId; ?>">Отмена</a?</p>
    </form>
</body>
</html>