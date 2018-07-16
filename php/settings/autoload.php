<?php
//Авто подгрузка файлов
	function __autoload($className)
	{
		//Подрузка моделей и настроек
         $paths = array(
             '/model/',
             '/settings/', 
	     );

	     foreach ($paths as $path){
	     	$path = ROOT . $path . $className . ".php"; //ROOT каталог где лежит index.php
	     	if (is_file($path)) include_once $path; // если файл есть, импортировать
	     }
	}