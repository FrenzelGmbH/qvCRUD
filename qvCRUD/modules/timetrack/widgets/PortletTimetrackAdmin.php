<?php
namespace app\modules\timetrack\widgets;

use Yii;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\modules\timetrack\models\Timetable;

class PortletTimetrackAdmin extends Portlet
{
	public $title='Timetrack Admin';

	/**
	 * the menu items containing label and action for the displayed action
	 * @var array
	 */
	public $menuItems = NULL;
	
	/**
	 * @var string the CSS class for the portlet title tag. Defaults to 'portlet-title'.
	 */
	public $titleCssClass='fg-color-black';

	/**
	 * @var string the CSS class for the portlet title tag. Defaults to 'portlet-content'.
	 */
	public $contentCssClass='fg-color-black';

	public $htmlOptions=array();

	public function init() {
		parent::init();
	}

	protected function renderContent()
	{
		if($this->menuItems==null){
			$this->menuItems = array();
			$this->menuItems[] = array('label'=>Yii::t('app','new timetrack entry'),'link'=>Html::url(array('/timetrack/timetrack/create','category'=>Timetable::CAT_TIMETRACK)),'icon'=>'icon-plus');
			$this->menuItems[] = array('label'=>Yii::t('app','timetrack overview'),'link'=>Html::url(array('/timetrack/default/calendar','category'=>Timetable::CAT_TIMETRACK)),'icon'=>'icon-list-alt');
			$this->menuItems[] = array('label'=>Yii::t('app','new illness entry'),'link'=>Html::url(array('/timetrack/timetrack/create','category'=>Timetable::CAT_ILLNESS)),'icon'=>'icon-medkit');
			$this->menuItems[] = array('label'=>Yii::t('app','new holiday entry'),'link'=>Html::url(array('/timetrack/timetrack/create','category'=>Timetable::CAT_HOLIDAY)),'icon'=>'icon-plane');
			$this->menuItems[] = array('label'=>Yii::t('app','holiday booking overview'),'link'=>Html::url(array('/timetrack/default/calendar','category'=>Timetable::CAT_HOLIDAY_BOOKING)),'icon'=>'icon-list-alt');
			$this->menuItems[] = array('label'=>Yii::t('app','new wedding entry'),'link'=>Html::url(array('/timetrack/timetrack/create','category'=>Timetable::CAT_WEDDING)),'icon'=>'icon-heart');
			$this->menuItems[] = array('label'=>Yii::t('app','new movement entry'),'link'=>Html::url(array('/timetrack/timetrack/create','category'=>Timetable::CAT_MOVEMENT)),'icon'=>'icon-archive');
			$this->menuItems[] = array('label'=>Yii::t('app','new other entry'),'link'=>Html::url(array('/timetrack/timetrack/create','category'=>Timetable::CAT_OTHER)),'icon'=>'icon-question');			
		}

		//here we don't return the view, here we just echo it!
		echo $this->render('@app/modules/timetrack/widgets/views/_admin',array('menuItems'=>$this->menuItems));
	}

	/**
	 * Renders the decoration for the portlet.
	 * The default implementation will render the title if it is set.
	 */
	protected function renderDecoration()
	{
		if($this->title!==null)
		{
			$this->title = Yii::t('app',$this->title);
			echo "<div class='panel-heading'><h3 class=\"{$this->titleCssClass}\"><i class='icon-info'></i> {$this->title}</h3>\n</div>\n";
		}
	}
}