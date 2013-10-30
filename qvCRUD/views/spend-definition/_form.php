<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\base\View $this
 * @var app\models\SpendDefinition $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="spend-definition-form">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'ValidFrom')->textInput() ?>

		<?= $form->field($model, 'IsValid')->textInput() ?>

		<?= $form->field($model, 'SpendDefID')->textInput() ?>

		<?= $form->field($model, 'SpendDefDescription')->textInput() ?>

		<?= $form->field($model, 'Parent')->textInput() ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
