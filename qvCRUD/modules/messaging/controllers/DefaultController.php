<?php

namespace app\modules\messaging\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
