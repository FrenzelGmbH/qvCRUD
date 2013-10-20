<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\base\View $this
 * @var app\modules\qlikview\qvdocs\models\qvdocs $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Qvdocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qvdocs-view">

	<h1><?php echo Html::encode($this->title); ?></h1>

	<p>
		<?php echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
		<?php echo Html::a('Delete', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data-confirm' => Yii::t('app', 'Are you sure to delete this item?'),
			'data-method' => 'post',
		]); ?>
	</p>

	<?php echo DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'qvDocumentName',
			'qvPath',
			'status',
			'time_create:datetime',
		],
	]); ?>

</div>
