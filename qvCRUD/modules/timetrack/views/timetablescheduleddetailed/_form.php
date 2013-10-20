<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\base\View $this
 * @var app\modules\timetrack\models\TimeTableScheduledDetailed $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="time-table-scheduled-detailed-form">

	<?php $form = ActiveForm::begin(); ?>

		<?=$form->field($model, 'time_table_scheduled_id')->textInput(); ?>

		<?=$form->field($model, 'odd_even')->textInput(); ?>

		<?=$form->field($model, 'day_of_week')->textInput(); ?>

		<?=$form->field($model, 'time_start')->textInput(); ?>

		<?=$form->field($model, 'time_end')->textInput(); ?>

		<div class="form-group">
			<?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
