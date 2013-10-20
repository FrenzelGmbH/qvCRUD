<?php

namespace app\modules\pages\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}
}
