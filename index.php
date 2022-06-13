<?php
include './scripts/extensions/db_connect.php';
include './scripts/extensions/session.php';

my_session_start();

$userId = my_session_get('id');
$userLogin = my_session_get('login');
$userStatus = my_session_get('status');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header-footer.css">
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <div class="page">

        <header>
            <lable class="header_lable">CEDU.NET</lable>
        </header>

        <div class="content-wrapper">
            <div class="content">
                <?php
                    if (my_session_get('auth') == 0) {
                        my_session_set('status', null);
                        header("Location: ./login.php");
                    }

                    $query = "SELECT * FROM guestbook ORDER BY date DESC";

                    $result = $link->query($query);

				    for ($notes = []; $row = mysqli_fetch_assoc($result); $notes[] = $row);

				    

                ?>

                <div class="menubar-wrapper">
                    
                    <div class="user_info-wrapper">
                        <p><span class="user_info">Вы авторизованы в системе.<br>Здравствуйте, <?php echo $userLogin; ?>.</span></p>
                        <p><span class="user_info">Ваша роль в системе: <?php echo my_session_get('status').".<br>Ваш Id: ".my_session_get('id'); ?>.</span>
                    </div>

                    <?php if ($userStatus == 'admin') echo ("<p><a href='admin.php'>Панель администратора</a></p>"); ?>
                    <p><a href='profile.php?id=<?php echo $userId; ?>'>Ваш профиль</a></p>
                    <p><a href='users.php'>Список всех пользователей</a></p>


                    <form action="./scripts/events/logout_button.php" method="GET">
                        <input type="submit" class="button logout_button"name="logout" value="Выход из аккаунта">
                    </form>
                </div>
                    
                <div class="chat-wrapper">
                    <div class="chat">
                        <div class="chat_timeline">
                            <div class="note-wrapper">
                                <?php foreach($notes as $note):
                                    $noteId = $note['id'];
                                    $noteAuthor = $note['author'];
                                    $noteDate = "(".$note['date'].")";
                                ?>
		                        <div class="note">
                                    <div class="note_head-wrapper">
				                        <p>
					                        <span class="note_author"><?php echo $noteAuthor ?></span>
					                        <span class="note_date"><?php echo $noteDate ?></span>
                                            <?php if ($userStatus == 'admin'): ?>
                                                <a class="note_delete" href='./scripts/events/adminDeleteMessage.php?id=<?php echo $noteId; ?>'>Удалить</a>
                                            <?php endif; ?>
				                        </p>
                                    </div>
				                    <p>
					                    <span class="note_message"><?php echo $note['message'] ?></span>
				                    </p>
                                </div>
                                <?php endforeach?>
                            </div>
                        </div>
                        <div class="chat_form">
                            <form action="./scripts/events/send-message_button.php?login=<?php echo $userLogin;?>&message=<?php echo $_POST['message'];?>" method="POST">
					            <p><textarea class="chat_form-message" name="message" placeholder="Введите сообщение"></textarea></p>
					            <p><input type="submit" class="chat_button button" value="Отправить"></p>
            				</form>
                        </div>
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