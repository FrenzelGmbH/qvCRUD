<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\base\View $this
 * @var app\modules\timetrack\models\TimetableForm $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="timetable-search">

	<?php $form = ActiveForm::begin(array(
		'action' => array('index'),
		'method' => 'get',
	)); ?>

		<?= $form->field($model, 'id'); ?>
		<?= $form->field($model, 'user_id'); ?>
		<?= $form->field($model, 'time_start'); ?>
		<?= $form->field($model, 'time_end'); ?>
		<?= $form->field($model, 'date_start'); ?>
		<?php // echo $form->field($model, 'date_end'); ?>
		<?php // echo $form->field($model, 'date_create'); ?>
		<?php // echo $form->field($model, 'category'); ?>
		<?php // echo $form->field($model, 'double_value'); ?>
		<?php // echo $form->field($model, 'status'); ?>
		<?php // echo $form->field($model, 'date_delete'); ?>
		<div class="form-group">
			<?= Html::submitButton('Search', array('class' => 'btn btn-primary')); ?>
			<?= Html::resetButton('Reset', array('class' => 'btn btn-default')); ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
