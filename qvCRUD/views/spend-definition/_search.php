<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\base\View $this
 * @var app\models\SpendDefinitionSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="spend-definition-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

		<?= $form->field($model, 'ValidFrom') ?>

		<?= $form->field($model, 'IsValid') ?>

		<?= $form->field($model, 'SpendDefID') ?>

		<?= $form->field($model, 'SpendDefDescription') ?>

		<?= $form->field($model, 'Parent') ?>

		<div class="form-group">
			<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
