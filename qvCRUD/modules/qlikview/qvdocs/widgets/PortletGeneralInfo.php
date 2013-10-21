<?php
namespace app\modules\qlikview\qvdocs\widgets;

use yii\helpers\Html;

class PortletGeneralInfo extends Portlet
{
	public $title='Project Info';
	
	public $arrAssoc = NULL;
	
	public $enableAdmin = false;

	public $htmlOptions = array('class'=>'nostyler');

	protected function renderContent()
	{
		//here we don't return the view, here we just echo it!
		echo $this->render('@app/modules/qlikview/qvdocs/widgets/views/_generalinfo',array('infoText'=>$this->arrAssoc));
	}
}