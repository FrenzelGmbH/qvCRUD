<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\base\View $this
 * @var app\modules\revision\models\Revision $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = array('label' => 'Revisions', 'url' => array('index'));
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="revision-view">

	<h1><?= Html::encode($this->title); ?></h1>

	<p>
		<?= Html::a('Update', array('update', 'id' => $model->id), array('class' => 'btn btn-danger')); ?>
		<?= Html::a('Delete', array('delete', 'id' => $model->id), array(
			'class' => 'btn btn-danger',
			'data-confirm' => Yii::t('app', 'Are you sure to delete this item?'),
			'data-method' => 'post',
		)); ?>
	</p>

	<?= DetailView::widget(array(
		'model' => $model,
		'attributes' => array(
			'id',
			'content:ntext',
			'status',
			'creator_id',
			'time_create:datetime',
			'revision_table',
			'revision_id',
		),
	)); ?>

</div>
