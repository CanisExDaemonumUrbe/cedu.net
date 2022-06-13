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
    <title>Список всех пользователей</title>
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header-footer.css">
    <link rel="stylesheet" href="./css/users.css">
</head>
<body>
    <div class="page">
        <header>
            <lable class="header_lable">CEDU.NET</lable>
        </header>
        <?php

            $query = "SELECT * FROM users";
		    $users = mysqli_fetch_all($link->query($query));

        ?>

        <div class="content-wrapper">
            <div class = "content">
            <span class="content_main-lable">Список пользователей</span>
                <table class="info-table" border="2px">
                    <tbody>

                        <?php
                            foreach ($users as $user){

                                ?>
                                    <tr>
                                        <td><a href="profile.php?id=<?php echo $user['0']; ?>"><?php echo $user['1']; ?></a></td>
                                    </tr>
                                <?php

                            }
                        ?>

                    </tbody>
                </table>
                <p><a href='index.php'>Главная страница</a></p>
            </div>
        </div>

        <footer>
            <lable class="footer_lable">Учебный проект. Автор: Гелимянов Данил</lable>
        </footer>
    </div>
</body>
</html>