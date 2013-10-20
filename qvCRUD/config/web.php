<?php
$params = require(__DIR__ . '/params.php');
$config = [
	'id' => 'qvCRUD',
	'basePath' => dirname(__DIR__),
	'modules'=>[
    'pages' => [
      'class' => 'app\modules\pages\Pages',
    ],
    'posts' => [
      'class' => 'app\modules\posts\Posts',
    ],
    'comments' => [
			'class' => 'app\modules\comments\Comments'
		],
		'workflow' => [
      'class' => 'app\modules\workflow\Workflow',
    ],
   'bikes' => [
      'class' => 'app\modules\bikes\Bike',
    ],
   'tags' => [
      'class' => 'app\modules\tags\Tag',
    ],
   'tasks' => [
      'class' => 'app\modules\tasks\Task',
    ],
   'revision' => [
      'class' => 'app\modules\revision\Revision',
    ],
    'qvdocs' => [
      'class' => 'app\modules\qlikview\qvdocs\qvdocs',
    ],
  ],
	'components' => [
		'request' => [
			'enableCsrfValidation' => true,
		],
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
		'user' => [
			'class' => 'app\components\AppUser',
			'identityClass' => 'app\models\User',
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
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

if (YII_ENV_DEV) {
	$config['preload'][] = 'debug';
	$config['modules']['debug'] = 'yii\debug\Module';
	$config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
