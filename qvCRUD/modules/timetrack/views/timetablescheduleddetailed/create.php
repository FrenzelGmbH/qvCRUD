<?php

use yii\helpers\Html;

/**
 * @var yii\base\View $this
 * @var app\modules\timetrack\models\TimeTableScheduledDetailed $model
 */

$this->title = 'Create Time Table Scheduled Detailed';
$this->params['breadcrumbs'][] = ['label' => 'Time Table Scheduled Detaileds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="time-table-scheduled-detailed-create">

	<h1><?php echo Html::encode($this->title); ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
