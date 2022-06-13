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
    <title>Страница администратора</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <header>
        <div class="userInfo">
            <h1>Панель администратора</h1>
            <p><span>Вы авторизованы в системе.<br>Здравствуйте, <?php echo my_session_get('login'); ?>.</span></p>
            <p><span>Ваша роль в системе: <?php echo my_session_get('status').".<br>Ваш Id: ".my_session_get('id'); ?></span>
        </div>
    </header>
    <?php
        if(my_session_get('auth') == 1)
        {   
            $query = "SELECT *, statuses.name as status
                FROM users LEFT JOIN statuses
                ON statuses.roleId = users.status_id";
            $users = mysqli_fetch_all($link->query($query));

    ?>
        <p><a href='index.php'>Главная страница</a></p>
        <div>
            <span>Список всех пользователей</span>
            <table border=2px>
                <thead>
                    <tr>
                        <td>Логин</td>
                        <td>Роль в системе</td>
                        <td>Изменение роли</td>
                        <td>Статус</td>
                        <td>Изменить статус</td>
                        <td>Удаление</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for($i = 0; $i < count($users); $i++){
                            $user = $users[$i];
                            $userId = $user['0'];
                            $userLogin = $user['1'];
                            $userRoleStatus = $user['13'];
                            $userBanStatus = $user['4'];
                            $userBanText;
                            $userBanLink;

                            if($userBanStatus == 0){
                                $userBanText = "Имеет доступ";
                                $userBanLink = "Забанить";
                            } else {
                                $userBanText = "Забанен";
                                $userBanLink = "Разбанить";
                            }
                            
                            $changeStatus;

                                if($userRoleStatus == "admin"){
                                    echo '<tr bgcolor="red">';
                                    $changeStatus = "Понизить роль";
                                } else if ($userRoleStatus == "user"){
                                    echo '<tr bgcolor="green">';
                                    $changeStatus = "Повысить роль";
                                } else {
                                    echo '<tr>';
                                }
                                ?>
                                    <td><a href="profile.php?id=<?php echo $userId; ?>"><?php echo $userLogin; ?></a></td>
                                    <td><?php echo $userRoleStatus; ?></td>
                                    <td><a href="adminChangeRole.php?id=<?php echo $userId;?>&status=<?php echo $userRoleStatus;?>"><?php echo $changeStatus; ?></a></td>
                                    <td><?php echo $userBanText; ?></td>
                                    <td><a href="adminBan.php?id=<?php echo $userId;?>&status=<?php echo $userBanStatus;?>"><?php echo $userBanLink; ?></a></td>
                                    <td><a href ="adminChangeUser.php?id=<?php echo $userId; ?>">Удалить</a></td>
                                </tr>
                            <?php
                        }                    
                    ?>
                </tbody>
            </table>
        </div>

    <?php

        } else {
            ?>
                <lable>Вы не авторизованы в системе. Войдите или зарегиструйтесь.</lable>
                <p><a href='login.php'>Войти в систему</a></p>
                <p><a href='register.php'>Зарегистрироваться</a></p>
            <?php
        }
    ?>
</body>
</html>