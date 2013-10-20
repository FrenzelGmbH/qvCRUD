<?php

namespace app\components;

use \Yii;
use yii\web\User;

class AppUser extends User
{

	public function getisAdmin()
	{
		if(Yii::$app->user->identity->role < 2 AND !Yii::$app->user->isGuest){
			return true;
		}
		return false;
	}

	public function getisAdvanced()
	{
		if(Yii::$app->user->identity->role < 3 AND !Yii::$app->user->isGuest){
			return true;
		}
		return false;
	}

	public function getisUser()
	{
		if(Yii::$app->user->identity->role < 4 AND !Yii::$app->user->isGuest){
			return true;
		}
		return false;
	}

}
