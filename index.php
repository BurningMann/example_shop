<?php
require 'config.php';
require 'controller/controller.php';

function autoloadInc($class) 
{
    $file = 'inc/' . strtolower($class) . '.php';//имя файла класса в папке inc
	if (is_readable($file))//проверяем, если этот файл существует и доступен для чтения
	{
		include $file;//то включаем этот файл
		return true;//должно быть все OK
	}
	else
		return false;//файл недоступен, будет использована следующая функция в очереди автозагрузки
}
spl_autoload_register('autoloadInc');

function autoloadModel($class) 
{
    $file = 'model/' . strtolower($class) . '.php';
	if (is_readable($file))
	{
		include $file;
		return true;
	}
	else
		return false;
}
spl_autoload_register('autoloadModel');
$controller = new Controller('Guestbook', 'read');
$controller = new Controller('Blueth', 'read');
$controller = new Controller('Shirt', 'read');
$controller->run();
