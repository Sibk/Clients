<?php
   class Clients
   {

       //выгрузка всех клиентов
   	   public function getClients()
   	   {
   	   	$db_conn = new ConnectDB();
   	   	$db = $db_conn->getConnect();
   	   	$query = "SELECT id, first_name, last_name, otchestvo, birthday, sex, creation_date, update_date FROM clients";
   	   	$res = pg_query($query);
   	   	$res = pg_fetch_all($res);
   	   	if (!$res) return false;
            foreach ($res as $key => $r) {
                $res[$key]["phone"] = $this->getClientPhone($r["id"]); //добавляю ключ phone и добавляю номера
            }
   	   	return $res;
   	   }

        //выгрузка номеров клиента по айди клиента
        public function getClientPhone($id)
        {
            $db_conn = new ConnectDB();
            $db = $db_conn->getConnect();
            $query = "SELECT * FROM phones WHERE client_id = {$id}";
            $res = pg_query($query);
            $res = pg_fetch_all($res);
            return $res;
        }

        // поиск клиента по фамилии или id
        public function getClient($first_name =null, $otchestvo = null, $last_name = null, $id = null, $phone = null)
        {
        	//Экранируем пользовательский ввод
            $last_name = pg_escape_string($last_name);
            $first_name = pg_escape_string($first_name);
            $otchestvo = pg_escape_string($otchestvo);
            $phone = pg_escape_string($phone);

            $db_conn = new ConnectDB();
            $db = $db_conn->getConnect();
            //Поиск по id
            if ($id) $query = "SELECT * FROM clients WHERE id = {$id}"; 
            //Поиск по ФИО
            if ($last_name && $first_name && $otchestvo) $query = "SELECT * FROM clients WHERE 
                first_name = '{$first_name}' AND
                otchestvo = '{$otchestvo}' AND
                last_name = '{$last_name}'"; //По ФИО
            //Поиск по номеру телефона
            if ($phone) {
            	$query = "SELECT 
            	    cl.id,
                    cl.first_name,
                    cl.otchestvo,
                    cl.last_name,
                    cl.birthday,
                    cl.sex,
                    cl.creation_date,
                    cl.update_date
            	    FROM clients cl JOIN phones ph ON cl.id = ph.client_id WHERE ph.phone = {$phone}"; //Телефону
            	$res = pg_query($query);
                $res = pg_fetch_all($res);
            	if (!$res) return false;
                foreach ($res as $key => $r) {
                    $res[$key]["phone"] = $this->getClientPhone($r["id"]); //добавлям ключ phone и добавлям номера
                }
                return $res;
            }
            //Поиск по фамилии
            if ($last_name) {
            	$query = "SELECT * FROM clients WHERE last_name = '{$last_name}'"; //Телефону
            	$res = pg_query($query);
                $res = pg_fetch_all($res);
            	if (!$res) return false;
                foreach ($res as $key => $r) {
                    $res[$key]["phone"] = $this->getClientPhone($r["id"]); //добавлям ключ phone и добавлям номера
                }
                return $res;
            } 
            $res = pg_query($query);
            $res = pg_fetch_all($res);
            return $res;
        }

        // Функция добавления формы клиента в базу
        public function addClient($req)
        {
          	$db_conn = new ConnectDB();
          	$time_create = date('Y-m-d H:i');
          	$first_name = pg_escape_string($req["first_name"]);
          	$otchestvo = pg_escape_string($req["otchestvo"]);
          	$last_name = pg_escape_string($req["last_name"]);
          	$birthday = pg_escape_string($req["birthday"]);
          	$sex = pg_escape_string($req["sex"]);

            $db = $db_conn->getConnect();
            $query = "INSERT INTO clients (
                first_name,
                otchestvo,
                last_name,
                birthday,
                sex,
                creation_date)
                VALUES
                ('{$first_name}',
                '{$otchestvo}',
                '{$last_name}',
                '{$birthday}',
                '{$sex}',
                '{$time_create}')";
            $res = pg_query($query);
            return $res;
          }

        //Функция добавления номеров в базу, принимает массив номеров и фамилию
        public function addPhone($phones, $client_id = null)
        {
            $db_conn = new ConnectDB();
            $db = $db_conn->getConnect();
            foreach ($phones as $phone) {
            	if ($phone) {
                    $phone = pg_escape_string($phone);
                    $query = "INSERT INTO phones (phone, client_id) VALUES ({$phone}, {$client_id})";
                    $res = pg_query($query);
            	} else return false;
                
            }
            return true;
        }

        //Изменение карты клиента
        public function editClient($req)
        {
            $db_conn = new ConnectDB();
            $db = $db_conn->getConnect();
            $first_name = pg_escape_string($req["first_name"]);
            $otchestvo = pg_escape_string($req["otchestvo"]);
            $last_name = pg_escape_string($req["last_name"]);
            $birthday = pg_escape_string($req["birthday"]);
            $sex = pg_escape_string($req["sex"]);
            $id = pg_escape_string($req["id"]);
            $update_date = date('Y-m-d H:i');

            $query = "UPDATE clients SET
                first_name = '{$first_name}',
                otchestvo = '{$otchestvo}',
                last_name = '{$last_name}',
                birthday = '{$birthday}',
                sex = '{$sex}',
                update_date = '{$update_date}'
                WHERE id = {$id}";
            $res = pg_query($query);
            return true;
        }

        //Изменение номеров
        public function editPhones($phones)
        {
        	$db_conn = new ConnectDB();
            $db = $db_conn->getConnect();
        	foreach ($phones as $phone){
        		$id = $phone["id"];
        		$phone = pg_escape_string($phone["phone"]);//Экранируем номер
        		$query = "UPDATE phones SET phone = {$phone} WHERE id = {$id}";
        		$res = pg_query($query);
        	}

        	$res = $this->updateDate($id); //Обновляем последнее изменение формы клиента
        }

        //Обновление последнего изменения формы
        public function updateDate($id)
        {
        	$db_conn = new ConnectDB();
            $db = $db_conn->getConnect();
            $up_date = date('Y-m-d H:i');
            $query = "UPDATE clients SET update_date = '{$up_date}' WHERE id = {$id}";
            $res = pg_query($query);
            return $res;
        }

       //Удаление из бд

        public function delData($table_name, $id)
        {
            $db_conn = new ConnectDB();
            $db = $db_conn->getConnect();
            $query = "DELETE FROM {$table_name} WHERE id = {$id}";
            $res = pg_query($query);
            return $res;
        }

    }
