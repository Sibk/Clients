Создаем БАЗУ mysite
Создаем пользователя php с паролем 12345
Или зайти php/settings/connect_db.php и изменить настройки подключения к БД
    $host = "127.0.0.1";
    $dbname = "mysite";
    $user = "php";
    $password = "12345";

Создаем 2 таблицы
CREATE TABLE clients(id INTEGER PRIMARY KEY DEFAULT NEXTVAL('user_id'), first_name CHAR(64), last_name CHAR(64), birthday date, sex boolean, creation_date timestamp, update_date timestamp);

CREATE TABLE phones(id INTEGER PRIMARY KEY DEFAULT NEXTVAL('phone_id'), phone integer, client_id INTEGER NOT NULL REFERENCES clients ON DELETE CASCADE);

VirtualHost apache2 выглядит так:
	<VirtualHost *:80>
		ServerName test.site
		DocumentRoot /var/www/php
		<Directory /var/www/>
			AllowOverride All
		</Directory>
		ErrorLog ${APACHE_LOG_DIR}/error.log
		CustomLog ${APACHE_LOG_DIR}/access.log combined
	</VirtualHost>

Файл с именем .htaccess лежит в корневом каталоге приложения рядом с index.php
Выглядит он так:
	AddDefaultCharset utf-8

	RewriteEngine On
	RewriteBase /
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteRule . index.php

Надо будет подключить мод апача a2enmod rewrite
