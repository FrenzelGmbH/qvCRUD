<?php
namespace app\modules\comments\widgets;

use yii\helpers\Html;

use app\modules\comments\widgets\Portlet;
use app\modules\comments\models\Comment;

class PortletCommentsBatch extends Portlet
{
	public $title='Kommentare';
	
	public $module = 0;
	public $id = 0;

	public $contentCssClass="com-portlet";

	/**
	 * should the admin toolbar be shown?
	 * @var boolean
	 */
	public $enableAdmin = false;

	/**
	 * should the comments log be shown?
	 * @var boolean
	 */
	public $enableCommentsLog = true;

	public function init() {
		parent::init();
	}

	protected function renderContent()
	{
		$countComments = Comment::getAdapterForCommentCount($this->module, $this->id);
		//here we don't return the view, here we just echo it!
		echo $this->render('@app/modules/comments/widgets/views/_commentsbatch',array('countComments'=>$countComments,'module'=>$this->module,'id'=>$this->id,'enableCommentsLog'=>$this->enableCommentsLog));
	}

}