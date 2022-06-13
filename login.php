<?php
    include './scripts/extensions/db_connect.php';
    include './scripts/extensions/session.php';

    my_session_start();
    my_session_set('auth', 0);
    //echo my_session_get('auth')."<br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница авторизации</title>
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/header-footer.css">
</head>
<body>
    <div class="page">
        <header>
            <lable class="header_lable">CEDU.NET</lable>
        </header>
        <?php

	        if (!empty($_POST['password']) && !empty($_POST['login'])) {
		
		        $login = $_POST['login'];
		        $password = $_POST['password'];
		
		        $query = "SELECT * FROM users WHERE login='$login'";
		        $result = $link->query($query);
		
		        $user = mysqli_fetch_assoc($result); 

                $userBanStatus = $user['banned'];

                if ($userBanStatus == '0'){

                    $passwordHash = $user['password'];
		
                    if (!empty($user) && (password_verify($password, $passwordHash))) {
    
                        my_session_set('login', $user['login']);
                        my_session_set('id', $user['id']);
                        my_session_set('status', $user['status']);
                        my_session_set('auth', 1);
                        //my_session_set('validation_message','Авторизация успешно пройдена!');
                        header('location: ./index.php');
    
                    } else {
                        echo "Неверный логин или пароль!";
                    }

                } else {
                    echo "Вы забанены в системе!<br>Доступ запрещён!";
                }

	        }
        ?>
        <div class="content">
            <div class="content-wrapper">
                <div class="login_form-wrapper">
                    <lable class="login_form-lable">Окно авторизации</lable>
                    <div class="login_form">
                        <form action="" method="POST">
	                        <p>
                                <lable class="form_lable">Логин</label><br>
                                <input name="login" placeholder="">
                            </p>
	                        <p>
                                <lable class="form_lable">Пароль</label><br>
                                <input name="password" placeholder="" type="password">
                            </p>
                            <div class="button_wrapper"
	                            <p><input type="submit" class="button login_button" value="Войти в систему"></p>
                            </div>
                        </form>
                    </div>
                    <div class="login_form-link">
                        <p><a href='register.php'>Окно регистрации</a></p>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <lable class="footer_lable">Учебный проект. Автор: Гелимянов Данил</lable>
        </footer>
    <div>
</body>

</html>