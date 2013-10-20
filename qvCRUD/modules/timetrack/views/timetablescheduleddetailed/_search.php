<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\base\View $this
 * @var app\modules\timetrack\models\TimeTableScheduledDetailedSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="time-table-scheduled-detailed-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

		<?=$form->field($model, 'id'); ?>
		<?=$form->field($model, 'time_table_scheduled_id'); ?>
		<?=$form->field($model, 'odd_even'); ?>
		<?=$form->field($model, 'time_start'); ?>
		<?=$form->field($model, 'time_end'); ?>
		<?php // echo $form->field($model, 'day_of_week'); ?>
		<div class="form-group">
			<?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']); ?>
			<?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']); ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
