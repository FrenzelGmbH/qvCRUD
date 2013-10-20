<?php

namespace app\modules\timetrack;


class Timetrack extends \yii\base\Module
{
  /**
  * @var public defaultRoute holding the controller name which will be called by default
  */
  public $defaultRoute = 'timetrack';

  /**
  * @var public $controllerNamespace holing the namespace of the controller
  */
  public $controllerNamespace = 'app\modules\timetrack\controllers';

	public function init()
	{
		parent::init();

		// custom initialization code goes here
	}
}
