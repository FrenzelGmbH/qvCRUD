<?php

use yii\helpers\Html;

/**
 * @var yii\base\View $this
 * @var app\modules\timetrack\models\TimeTableScheduled $model
 */

$this->title = 'Create Time Table Scheduled';
$this->params['breadcrumbs'][] = ['label' => 'Time Table Scheduleds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="time-table-scheduled-create">

	<h1><?php echo Html::encode($this->title); ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
