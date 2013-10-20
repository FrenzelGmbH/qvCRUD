<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\base\View $this
 * @var app\modules\timetrack\models\TimeTableScheduledSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="time-table-scheduled-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

		<?=$form->field($model, 'id'); ?>
		<?=$form->field($model, 'user_id'); ?>
		<?=$form->field($model, 'location_id'); ?>
		<?=$form->field($model, 'category'); ?>
		<?=$form->field($model, 'date_start'); ?>
		<div class="form-group">
			<?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']); ?>
			<?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']); ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
