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
    <title>Страница регистрации</title>
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header-footer.css">
    <link rel="stylesheet" href="./css/register.css">
</head>
<body>
    <div class="page">
        <header>
                <lable class="header_lable">CEDU.NET</lable>
        </header>
    <?php
        
        if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['confirm']) && isset($_POST['dateOfBirth']) && isset($_POST['email'])) {

            $login = $_POST['login'];
            $password = $_POST['password'];
            $confirm = $_POST['confirm'];
            $dateOfBirth = $_POST['dateOfBirth'];
            $surname = $_POST['surname'];
            $name = $_POST['name'];
            $patronymic = $_POST['patronymic'];
            $email = $_POST['email'];
            $registrationDate = date("Y-m-d");

            $loginPattern = '/[a-zA-z0-9]/';
            $emailPattern = '/^.+@.+\..+$/';
            $dateOfBirthPattern = '/[0-3][0-9]\.[0-1][0-9]\.[0-9]{4}/';

            $splitDate = explode(".", $dateOfBirth);


            if (!empty($login) && !empty($password) && !empty($confirm) && !empty($dateOfBirth) && !empty($email) && !empty($surname) && !empty($name)) {
                
                $loginPatterCheck = preg_match($loginPattern, $login);
                $loginLenCheck = strlen($login) >= 4 && strlen($login) <= 10;
                $passwordLenCheck = strlen($password) >= 6 && strlen($password) <= 12;
                $emailCheck = preg_match($emailPattern, $email);
                $dateOfBirthPatternCheck = preg_match($dateOfBirthPattern, $dateOfBirth) && $splitDate[0] < 32 && $splitDate[1] < 13;

                if ( $loginPatterCheck && $loginLenCheck && $passwordLenCheck && $dateOfBirthPatternCheck && $emailCheck ) {

                    if ($password == $confirm) {
    
                        $query = "SELECT * FROM users WHERE login='$login'";
                        $user = mysqli_fetch_assoc($link->query($query));
        
                        if (empty($user)){
                            
                            $dateOfBirth = date_format(date_create($_POST['dateOfBirth']),"Y-m-d");
                            
                            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                            $status = "user";
                            my_session_set('status', $status);

                            $query = "INSERT INTO users SET login='$login', password='$passwordHash', status_id='1', dateOfBirth='$dateOfBirth', surname = '$surname', name = '$name', patronymic = '$patronymic', email='$email', registrationDate='$registrationDate',";
                            $result = $link->query($query);
        
                            my_session_set('login', $login);
                            my_session_set('auth', 1);
        
                            $id = mysqli_insert_id($link);
                            my_session_set('id', $id);
        
                            header('location: ./index.php');
        
                        } else {
                            echo "Пользователь с таким логином уже зарегистрирован!";
                        }
        
                    } else {
                        echo "Пароли не совпадают!<br>";
                    }

                } else {
                    if (!$loginPatterCheck) { $loginPatterCheckMessage = true;}
                    if (!$loginLenCheck) { $loginLenCheckMessage = true;}
                    if (!$passwordLenCheck) { $passwordLenCheckMessage = true;}
                    if (!$dateOfBirthPatternCheck) {$dateOfBirthPatternCheckMessage = true;}
                    if (!$emailCheck) { $emailCheckMessage = true;}
                }
                		    
            } else {
                echo "Все поля должны быть заполнены!";
            }
        }

        
    ?>
        <div class="content">
            <div class="content-wrapper">
                <div class="register_form-wrapper">
                    <lable class="register_form-lable">Окно регистрации</lable>
                    <div class="register_form">
                        <form action="" method="POST">
                            <?php
                                if ($loginPatterCheckMessage) { echo "<label class='error form_lable'>Логин может содержать только цифры или латинские буквы!</label><br>";}
                                if ($loginLenCheckMessage) {echo "<label class='error form_lable'>Длина логина должна быть от 4 до 10 символов!</label><br>";}
                            ?>
	                        <p>
                                <label class="form_lable">Придумайте логин:<br> от 4 до 10 символов, цифры, латинские буквы</label><br>
                                <input name="login" placeholder="Логин">
                            </p>

                            <?php if ($passwordLenCheckMessage) {echo "<label class='error form_lable'>Длина пароля должна быть от 6 до 12 символов!</label><br>";}?>
	                        <p>
                                <label class="form_lable">Придумайте пароль: от 6 до 12 символов</label><br>
                                <input name="password" placeholder="Пароль" type="password">
                            </p>

	                        <p>
                                <label class="form_lable">Подтвердите пароль</label><br>
                                <input name="confirm" placeholder="Подтвержение" type="password">
                            </p>

                            <p>
                                <label class="form_lable">Укажите ваше ФИО</label><br>
                                <input name="surname" placeholder="Фамилия"><br>
                                <input name="name" placeholder="Имя"><br>
                                <input name="patronymic" placeholder="Отчество (если есть)">
                            </p>    

                            <?php if ($dateOfBirthPatternCheckMessage) {echo "<label class='error form_lable'>Неверный формат даты рождения!</label><br>";}?>
	                        <p>
                                <label class="form_lable">Укажите дату рождения, формат: дд.мм.гггг</label><br>
                                <input name="dateOfBirth" placeholder="Дата рождения">
                            </p>

                            <?php if ($emailCheckMessage) {echo "<label class='error form_lable'>Неверный формат почтового адреса!</label><br>";}?>
                            <p>
                                <label class="form_lable">Укажите адрес электронной почты:</label><br>
	                            <input name="email" placeholder="email">
                            </p>

                            <div class="button_wrapper">
	                            <p><input type="submit" class="button register_button" value="Зарегистрироваться"></p>
                            </div>
                        </form>
                    </div>
                    <div class="register_form-link">
                        <p><a href='login.php'>Окно авторизации</a></p>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <lable class="footer_lable">Учебный проект. Автор: Гелимянов Данил</lable>
        </footer>
    </div>
</body>

</html>
