<?php
    // запуск механизма сессий
    function my_session_start() {
	    if (session_status() == PHP_SESSION_NONE) session_start();
    }
 
    // добавление данных в сессию
    function my_session_set($key, $val) {
	    $_SESSION[$key] = $val;
    }
 
    // получение данных из сессии
    function my_session_get($key) {
	    if (isset($_SESSION[$key])) 
		    return $_SESSION[$key];
	    else
		    return 'Undefined value';
    }
 
    // удаление данных из сессии
    function my_session_clear($key) {
	    if (isset($_SESSION[$key])) unset($_SESSION[$key]);
    }
 
    // добавить во flash-сессию
    function my_session_flash_set($key, $val) {
	    $_SESSION[$key] = $val;
    }
 
    // получить из flash-сессии
    function my_session_flash_get($key) {
	    if (isset($_SESSION[$key])) {
		    $data = $_SESSION[$key];
		    unset($_SESSION[$key]);
		
		    return $data;
	    }
	    else
		    return 'Undefined value';
    }
?>