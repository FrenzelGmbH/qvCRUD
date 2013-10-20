<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\base\View $this
 * @var app\modules\timetrack\models\TimeTableScheduled $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="time-table-scheduled-form">

	<?php $form = ActiveForm::begin(); ?>

		<?=$form->field($model, 'user_id')->textInput(); ?>

		<?=$form->field($model, 'location_id')->textInput(); ?>

		<?=$form->field($model, 'category')->textInput(); ?>

		<?=$form->field($model, 'date_start')->textInput(); ?>

		<div class="form-group">
			<?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
