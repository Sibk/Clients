<?php

	class Router
	{
		//Маршруты
		private $urls = [
			"client/all" => "ClientController/getClientCard",
			"client/add" => "ClientController/addClient",
			"client/card" => "ClientController/cardClient",
			"phone/add" => "ClientController/addPhone",
            "client/phone/remove" => "ClientController/delPhone",
            "client/remove" => "ClientController/delClient",
            "client/search" => "ClientController/searchClient",

		];

		function getRoute($path)
		{
            $request = preg_replace(["/^\//", "/\/$/"], '', $path); //убираем в запросе первый и последний слэш
			foreach($this->urls as $key => $value) {
				$key1 = '/^' . preg_quote($key, '/') . '/'; //Экранируем маршрут
				if (preg_match($key1, $request)) { //Регулярка для поиска маршрута к контроллеру
					$request = explode("/", $value); //Бьем значение маршрута по разделителю, получаем
                    $controllerName = array_shift($request); //Имя контроллера(класса)
                    $controllerFunc = array_shift($request); //Запускаемый метод
                    $controllerFile = ROOT . "/controller/" . $controllerName . ".php"; //имя файла контроллера
                    if (file_exists($controllerFile)) {
                        include_once($controllerFile); //Импорт файла контроллера
                    }
                    $controller = new $controllerName; //создаем экземпляр класса котроллера
                    $res = $controller->$controllerFunc();//заводим нужный метод
                    if ($res) break;
				}
			}
		    return $request;
		}
	}

?>
