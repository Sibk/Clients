<?php

    ini_set('display_errors',1); //Показываем ошибки 
	error_reporting(E_ALL); //Какие ошибки будут выводиться

	define('ROOT', dirname(__FILE__)); //Константа ROOT путь к файлу index.php, для импортов файлов

	require_once(ROOT . "/settings/autoload.php"); //Подключение автоподгрузки файлов
	require_once(ROOT . "/settings/connect_db.php"); //Подключение к БД
    require_once(ROOT . "/router/router.php"); // Подключение роутинга

    $uri = $_SERVER['REQUEST_URI']; //Строка запроса пользователя
    $router = new Router();
    $res = $router->getRoute($uri); //Запускаем роутер, передаем строку запроса
   


?>
