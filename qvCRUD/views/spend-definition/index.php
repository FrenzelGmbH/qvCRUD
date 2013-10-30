<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\base\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\SpendDefinitionSearch $searchModel
 */

$this->title = 'Spend Definitions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spend-definition-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('Create SpendDefinition', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?php 

		foreach($dataProvider AS $key => $value)
			echo $value['SpendDefID'] . ' : ' . $value['SpendDefDescription'] . '<br/>';

	/*echo GridView::widget([
		'dataProvider' => $dataProvider,
		//'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			//'ValidFrom',
			//'IsValid',
			'SpendDefID',
			'SpendDefDescription',
			//'Parent',

			['class' => 'yii\grid\ActionColumn'],
		],
	]);*/ ?>

</div>
