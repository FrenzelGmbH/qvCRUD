<?php
namespace app\modules\comments\widgets;

use Yii;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\modules\comments\models\Comment;

class PortletComments extends Portlet
{
	public $title='Kommentare';
	
	public $module = 0;
	public $id = 0;

	/**
	 * @var string the CSS class for the portlet title tag. Defaults to 'portlet-title'.
	 */
	//public $titleCssClass='fg-color-black';

	/**
	 * @var string the CSS class for the portlet title tag. Defaults to 'portlet-content'.
	 */
	//public $contentCssClass='fg-color-black';

	public $enableAdmin = false;

	public $htmlOptions = array('class'=>'panel panel-warning');

	public function init() {
		parent::init();
	}

	protected function renderContent()
	{
		$query = Comment::findRecentComments($this->module, $this->id);

		$dpComments = new ActiveDataProvider(array(
		  'query' => $query,
	  ));
		//here we don't return the view, here we just echo it!
		echo $this->render('@app/modules/comments/widgets/views/_comments',array('dpComments'=>$dpComments,'module'=>$this->module,'id'=>$this->id));
	}
}