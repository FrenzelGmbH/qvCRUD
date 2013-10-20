<?php 

use yii\helpers\Html;
use yiidhtmlx\Chart;

use app\modules\timetrack\models\Timetable;

$divider = $MTimeTableScheduled->category==0?1:$MTimeTableScheduled->category;

?>

<table class="table table-striped">
			<tr>
		<td class="col-lg-3"><?= Yii::t('app','Current Saldo'); ?></td>
		<td><?= TimeTable::getCurrentSaldo($user_id,'2013')->double_value/$divider; ?></td>
		<td colspan="2"><?= $MTimeTableScheduled->CategoryAsString; ?></td>
	</tr>
	<tr>
		<td class="col-lg-3"><?= Yii::t('app','Start Saldo'); ?></td>
		<td class="col-lg-3"><?= TimeTable::getinitialBooking($user_id,'2013')->double_value/$divider; ?></td>
		<td class="col-lg-3"><?= Yii::t('app','Beginning from'); ?></td>
		<td>2013/2014</td>
	</tr>
	<tr>
		<td class="col-lg-3"><?= Yii::t('app','Consumed'); ?></td>
		<td><?= (double)TimeTable::getHolidayBookings($user_id,'2013')->double_value/$divider; ?></td>
		<td colspan="2"></td>
	</tr>
</table>

<?php 
	echo Chart::widget(
		array(
			'clientOptions'=>array(
			 	'view'  => 'bar',
			 	'container' => 'myTestChart',
	 		    'value' => '#value#',
	 		    'color' => '#color#',
	 		    'border' => 1,
	 		    'radius' => 1,
	 		    'xAxis'=>array(
					'title'=> Yii::t('app','Amount by Month'),
					'template'=> '#status#',
				)
			),			
 	    	'options'=>array(
				'id'    => 'myTestChart',
				'style' => 'width:100%;height:120px;'
			),
			'clientDataOptions'=>array(
				'type'=>'json',
				'url'=>Html::url(array('/timetrack/chart/jsonpieemployeesheet','id'=>$user_id))
			)		
		)
	);
?>
