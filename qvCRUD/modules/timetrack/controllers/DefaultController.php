<?php

namespace app\modules\timetrack\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{

  //setting the default layout to column2
  public $layout = "column3";

	public function actionIndex()
	{
		return $this->render('index');
	}
}
