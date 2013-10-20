<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\base\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\timetrack\models\TimeTableScheduledSearch $searchModel
 */

$this->title = 'Time Table Scheduleds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="time-table-scheduled-index">

	<h1><?php echo Html::encode($this->title); ?></h1>

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?php echo Html::a('Create TimeTableScheduled', ['create'], ['class' => 'btn btn-success']); ?>
	</p>

	<?php echo GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id',
			'user_id',
			'location_id',
			'category',
			'date_start',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

</div>
