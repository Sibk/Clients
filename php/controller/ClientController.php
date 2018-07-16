<?php
   class ClientController
   {
        public function getClientCard()
        {

            $clients = new Clients();
            $res = $clients->getClients(); //получаем список всех клиентов
            require_once(ROOT . "/view/AllClients.php");
            return true;
        }

        public function searchClient()
        {
        	$res= null;
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            	$clients = new Clients();
                if (ctype_digit($_POST["search"])) { //Если состоит только из цифр, значит, номер телефона
                    $res = $clients->getClient(null, null, null, null, $_POST["search"]);
                } else { // Фамилия
                	$res = $clients->getClient(null, null, $_POST["search"]); //Передаем фамилию в функцию поиска
                }       	
            }
            require_once(ROOT . "/view/SearchClient.php");
            return true;
        }

       //Добавление клиента
       public function addClient()
       {
           $name_error = null;
           $clients = new Clients();
           if ($_SERVER["REQUEST_METHOD"] == "POST") {
               if (
               	   //проверка переданы ли все поля с формы
               	   $_POST["first_name"] && 
               	   $_POST["otchestvo"] && 
               	   $_POST["last_name"] && 
               	   $_POST["birthday"] && 
               	   $_POST["sex"]) {
                       $res = $clients->addClient($_POST); //добавляем форму клиента
                       $phones = ($_POST["phones"]);//получаем номера клиента из пост запроса
                       $client_id = $clients->getClient(
                           $_POST["first_name"],
                           $_POST["otchestvo"],
                           $_POST["last_name"]
                           )[0]["id"]; //получаем id клиента, которого добавили
                       $clients->addPhone($phones, $client_id);//добавляем номера в форму клиента
                       $this->back($_SERVER["HTTP_REFERER"]); //Редирект на предыдщую страницу
               } else {
               	$name_error = 'Не заполнены все поля';
               	$this->back($_SERVER["HTTP_REFERER"]); //Редирект на предыдщую страницу
               }
           }
           require_once(ROOT . "/view/AddClient.php");

           return true;
       }

       //Карточка клиента и изменения данных пользователя
       public function cardClient()
       {     $res = null;
             $clients = new Clients();
             //Изменение данных пользователя
             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                print_r($_POST);
                $phones = $this->getPhones($_POST); //Получаем из пост запроса номера с формы
                $res = $clients->editClient($_POST); //Меняем данные клиента
                $res = $clients->editPhones($phones);//Меняем номера
                $this->back($_SERVER["HTTP_REFERER"]);//Редирект на предыдщую страницу
             }

             preg_match('/[0-9]+/', $_SERVER["QUERY_STRING"], $res); //Получаем айди
       	     $id = implode($res);//Преобразуем массив в строку
       	     //В php видимо нельзя указать в какое поле надо передать значение, поэтому пишем null
             $res = $clients->getClient(null, null, null, $id); //Получаем инфу о клиенте по id
             $phones = $clients->getClientPhone($id); //Получаем номера клиента, передаем id клиента
             require_once(ROOT . "/view/CardClient.php");
             return true;
       }

       //добавляем номера в бд
       public function addPhone()
       {
       	    $clients = new Clients();
       	    $client_id = $_POST["client_id"]; //получаем айди клиента
       	    $phones = $_POST["phones"];
       	    $res = $clients->addPhone($phones, $client_id);//Добавляем в базу номера, передаем массив номеров и id клиента
       	    $res = $clients->updateDate($client_id); //Обновляем  дату последнего изменения
       	    $this->back($_SERVER['HTTP_REFERER']);
       	    return true;
       }

       //Функция удаления телефона
       public function delPhone()
       {
           $clients = new Clients();
           print_r($_POST["del_phone"]);
           $ids = $_POST["del_phone"];
           foreach ($ids as $id) {
           	   $res = $clients->delData('phones', $id); //Передаем имя таблицы и айди номера
           }
           $this->back($_SERVER['HTTP_REFERER']); //Редирект на предыдущую страницу
           return true;
       }

       //Функция удаления пользователя
       public function delClient()
       {
           $client_id = $_POST["client_id"];
           $clients = new Clients();
           $res = $clients->delData('clients', $client_id);//Передаем имя таблицы и айди клиента
           $this->back(); //Редирект на список всех клиентов
           return true;
       }

       //функция редирект
       private function back($redirect = "/client/all") //Дефолтный редирект на список всех пользовтелей
       {
            header("Location: {$redirect}");
            exit;
       }

       //Функция для получения массива номеров из пост запроса
       private function getPhones($POST)
       {
            $phones = [];
            foreach ($POST as $key => $value) {
                if (preg_match("/phone/", $key)) { //Ищем ключ в хэше
                    $id = preg_replace("/phone[0-9]\//", '', $key); //Получаем из ключа id телефона
                    $tmp = ["phone" => $value, "id" => $id]; //Определяем хэш
                    array_push($phones, $tmp); //Грузим хэш в массив
                }
            }
            return $phones; //Возвращаем массив хэшей
       }
   }
?>
