<?php
namespace app\modules\timetrack\widgets;

use Yii;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\modules\timetrack\models\Timetable;

class PortletHolidayStatistic extends Portlet
{
	public $title='Holiday Statistic';
	
	public $user_id = 0;

	/**
	 * @var string the CSS class for the portlet title tag. Defaults to 'portlet-title'.
	 */
	//public $titleCssClass='fg-color-black';

	/**
	 * @var string the CSS class for the portlet title tag. Defaults to 'portlet-content'.
	 */
	//public $contentCssClass='fg-color-black';

	public $enableAdmin = false;

	public $htmlOptions = array('class'=>'panel panel-info');

	public function init() {
		parent::init();
	}

	protected function renderContent()
	{
		$MTimeTableScheduled = \app\models\TimeTableScheduled::findLatestWorkTime($this->user_id);
		//here we don't return the view, here we just echo it!
		echo $this->render('@app/modules/timetrack/widgets/views/_holiday_statistics',array('user_id'=>$this->user_id,'MTimeTableScheduled'=>$MTimeTableScheduled));
	}
}
