<?php
$params = require(__DIR__ . '/params.php');
return [
	'id' => 'bootstrap-console',
	'basePath' => dirname(__DIR__),
	'preload' => ['log'],
	'controllerPath' => dirname(__DIR__) . '/commands',
	'controllerNamespace' => 'app\commands',
	'modules' => [
	],
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=qvCRUD',
      'username' => 'root', 
      'password' => '',
      'tablePrefix' => 'tbl_',
		],
		'seeder'=>[
			'class'    =>'app\components\DbFixtureManager',
			'basePath' => dirname(__DIR__).'/migrations/seed',
    ],
		'log' => [
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
	],
	'params' => $params,
];
