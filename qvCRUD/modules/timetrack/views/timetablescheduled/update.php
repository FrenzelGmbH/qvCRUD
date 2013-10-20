<?php

use yii\helpers\Html;

/**
 * @var yii\base\View $this
 * @var app\modules\timetrack\models\TimeTableScheduled $model
 */

$this->title = 'Update Time Table Scheduled: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Time Table Scheduleds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="time-table-scheduled-update">

	<h1><?php echo Html::encode($this->title); ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
