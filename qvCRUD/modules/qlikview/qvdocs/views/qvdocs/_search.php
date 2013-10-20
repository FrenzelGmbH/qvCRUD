<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\base\View $this
 * @var app\modules\qlikview\qvdocs\models\qvdocsSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="qvdocs-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

		<?=$form->field($model, 'id'); ?>
		<?=$form->field($model, 'qvDocumentName'); ?>
		<?=$form->field($model, 'qvPath'); ?>
		<?=$form->field($model, 'status'); ?>
		<?=$form->field($model, 'time_create'); ?>
		<div class="form-group">
			<?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']); ?>
			<?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']); ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
