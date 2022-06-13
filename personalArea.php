<?php
    include './scripts/extensions/db_connect.php';
    include './scripts/extensions/session.php';

    my_session_start();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование данных</title>
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header-footer.css">
    <link rel="stylesheet" href="./css/personalArea.css">
</head>
<body>
    <div class="page">
        <header>
            <lable class="header_lable">CEDU.NET</lable>
        </header>
        <div class="content-wrapper">
            <div class="content">
                <span class="content_main-lable">Редактирование персональных данных</span>
                <?php
                    if(my_session_get('auth') == 1){

                        $userId = my_session_get('id');

                        $query = "SELECT * FROM users WHERE id = '$userId'";
                        $user = mysqli_fetch_assoc($link->query($query));

                        $oldUserSurname = $user['surname'];
                        $oldUserName = $user['name'];
                        $oldUserPatronymic = $user['patronymic'];
                        $oldUserDateOfBirth = date_format(date_create($user['dateOfBirth']),"d.m.Y");
                        $oldUserEmail = $user['email'];

                        $newUserSurname = $_POST['surname'];
                        $newUserName = $_POST['name'];
                        $newUserPatronymic = $_POST['patronymic'];
                        $newUserDateOfBirth = $_POST['dateOfBirth'];
                        $newUserEmail = $_POST['email'];
                        $newUserCountry = $_POST['country'];

                        $emailPattern = '/^.+@.+\..+$/';
                        $dateOfBirthPattern = '/[0-3][0-9]\.[0-1][0-9]\.[0-9]{4}/';

                        $splitDate = explode(".", $newUserDateOfBirth);

                        if (!empty($newUserDateOfBirth) && !empty($newUserEmail) && !empty($newUserSurname) && !empty($newUserName)) {
                
                            $emailCheck = preg_match($emailPattern, $newUserEmail);
                            $dateOfBirthPatternCheck = preg_match($dateOfBirthPattern, $newUserDateOfBirth) && $splitDate[0] < 32 && $splitDate[1] < 13;

                            if ($dateOfBirthPatternCheck && $emailCheck ) {

                                $dateOfBirth = date_format(date_create($_POST['dateOfBirth']),"Y-m-d");

                                $query = "UPDATE users SET surname='$newUserSurname', name='$newUserName', patronymic='$newUserPatronymic', dateOfBirth='$dateOfBirth', email='$newUserEmail', country='$newUserCountry' WHERE id='$userId'";
                                $result = $link->query($query);

                                header("location: ./profile.php?id=$userId");

                            } else {
                                if (!$dateOfBirthPatternCheck) {$dateOfBirthPatternCheckMessage = true;}
                                if (!$emailCheck) { $emailCheckMessage = true;}
                            }
                		    
                        } else {
                            /* echo "Все поля должны быть заполнены!"; */
                        }

                        ?>
                        <div class="content_change-form"
                            <form action="" method="POST">

                                <div class="form_name">
                                    <p>
                                        <label class="form_lable">Укажите ваше ФИО</label><br>
                                        <input name="surname" placeholder="Фамилия" value=<?php echo $oldUserSurname; ?>><br>
                                        <input name="name" placeholder="Имя" value=<?php echo $oldUserName; ?>><br>
                                        <input name="patronymic" placeholder="Отчество (если есть)" value=<?php echo $oldUserPatronymic; ?>>
                                    </p>
                                </div>

                                <div class="form_birthDay">
                                    <?php if ($dateOfBirthPatternCheckMessage) {echo "<label>Неверный формат даты рождения!</label><br>";}?>
	                                <p>
                                        <label class="form_lable">Укажите дату рождения, формат: дд.мм.гггг</label><br>
                                        <input name="dateOfBirth" placeholder="Дата рождения" value=<?php echo $oldUserDateOfBirth; ?>>
                                    </p>
                                </div>

                                <div class="form_email">
                                    <?php if ($emailCheckMessage) {echo "<label>Неверный формат почтового адреса!</label><br>";}?>
                                    <p>
                                        <label class="form_lable">Укажите адрес электронной почты:</label><br>
	                                    <input name="email" placeholder="email" value=<?php echo $oldUserEmail; ?>>
                                    </p>
                                </div>

                                <div class="form_button-wrapper">
                                    <p><input class="button pa_button" type="submit" value="Сохранить изменения"></p>
                                </div>
                            </form>
                        </div>
                        <div class="menubar-wrapper">
                            <div class="menubar">
                                <p><a href="changePassword.php">Изменить пароль</a></p>
                                <p><a href="profile.php?id=<?php echo $userId; ?>">Назад</a></p>
                            </div>
                        </div>
                <?php
                    }

                    if(my_session_get('auth') == 0){
                        my_session_set('status', null);
                        header("Location: ./login.php");
                    }

                ?>
            </div>
        </div>
        <footer>
            <lable class="footer_lable">Учебный проект. Автор: Гелимянов Данил</lable>
        </footer>
    </div>
</body>
</html>