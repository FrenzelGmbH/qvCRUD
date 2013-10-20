<?php

use yii\helpers\Html;

/**
 * @var yii\base\View $this
 * @var app\modules\timetrack\models\TimeTableScheduledDetailed $model
 */

$this->title = 'Update Time Table Scheduled Detailed: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Time Table Scheduled Detaileds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="time-table-scheduled-detailed-update">

	<h1><?php echo Html::encode($this->title); ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
