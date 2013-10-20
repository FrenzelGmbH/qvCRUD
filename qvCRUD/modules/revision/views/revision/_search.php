<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\base\View $this
 * @var app\modules\revision\models\RevisionForm $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="revision-search">

	<?php $form = ActiveForm::begin(array('method' => 'get')); ?>

		<?= $form->field($model, 'id'); ?>
		<?= $form->field($model, 'content'); ?>
		<?= $form->field($model, 'status'); ?>
		<?= $form->field($model, 'creator_id'); ?>
		<?= $form->field($model, 'time_create'); ?>
		<?php // echo $form->field($model, 'revision_table'); ?>
		<?php // echo $form->field($model, 'revision_id'); ?>
		<div class="form-group">
			<?= Html::submitButton('Search', array('class' => 'btn btn-primary')); ?>
			<?= Html::resetButton('Reset', array('class' => 'btn btn-default')); ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
