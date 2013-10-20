<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\base\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\timetrack\models\TimeTableScheduledDetailedSearch $searchModel
 */

$this->title = 'Time Table Scheduled Detaileds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="time-table-scheduled-detailed-index">

	<h1><?php echo Html::encode($this->title); ?></h1>

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?php echo Html::a('Create TimeTableScheduledDetailed', ['create'], ['class' => 'btn btn-success']); ?>
	</p>

	<?php echo GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id',
			'time_table_scheduled_id:datetime',
			'odd_even',
			'time_start',
			'time_end',
			// 'day_of_week',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

</div>
