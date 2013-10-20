<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\base\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\revision\models\RevisionForm $searchModel
 */

$this->title = 'Revisions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="revision-index">

	<h1><?= Html::encode($this->title); ?></h1>

	<?php // echo $this->render('_search', array('model' => $searchModel)); ?>

	<p>
		<?= Html::a('Create Revision', array('create'), array('class' => 'btn btn-danger')); ?>
	</p>

	<?= GridView::widget(array(
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => array(
			array('class' => 'yii\grid\SerialColumn'),

			'id',
			'content:ntext',
			'status',
			'creator_id',
			'time_create:datetime',
			// 'revision_table',
			// 'revision_id',

			array('class' => 'yii\grid\ActionColumn'),
		),
	)); ?>

</div>
