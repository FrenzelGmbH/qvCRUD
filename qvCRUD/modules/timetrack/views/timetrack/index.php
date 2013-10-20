<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\base\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\timetrack\models\TimetableForm $searchModel
 */

$this->title = 'Timetables';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timetable-index">

	<h1><?= Html::encode($this->title); ?></h1>

	<?php // echo $this->render('_search', array('model' => $searchModel)); ?>

	<p>
		<?= Html::a('Create Timetable', array('create'), array('class' => 'btn btn-danger')); ?>
	</p>

	<?= GridView::widget(array(
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => array(
			array('class' => 'yii\grid\SerialColumn'),

			'id',
			//'user_id',
			'time_start',
			'time_end',
			'date_start',
			// 'date_end',
			// 'date_create',
			'category',
			// 'double_value',
			// 'status',
			// 'date_delete',

			array('class' => 'app\modules\timetrack\actions\TimetrackActionColumn'),
		),
	)); ?>

</div>
