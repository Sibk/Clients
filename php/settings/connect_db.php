<?php
//Подключение к БД
    class ConnectDB
    {
    	public function getConnect()
    	{
    		$host = "127.0.0.1";
    		$dbname = "mysite";
    		$user = "php";
    		$password = "12345";

    		$db = pg_connect("host={$host} dbname={$dbname} user={$user} password={$password}")
    		    or die('not connect: ' . pg_last_error());
    		return $db;
    	}
    }