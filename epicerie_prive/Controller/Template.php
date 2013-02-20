<?php

abstract class Controller_Template
{

    protected $selfModel;
    protected static $instance;
    public static $db;

    protected function __construct()
    {
	
    }

    /* Chaque contrôleur implante le design pattern «Singleton» */

    public static function getInstance($className)
    {
	$controllerClassName = 'Controller_' . $className;

	eval
	("
		if(!$controllerClassName::\$instance)
		{
			$controllerClassName::\$instance = new $controllerClassName();
		}
		\$controllerInstance = $controllerClassName::\$instance;
	");

	return $controllerInstance;
    }
}