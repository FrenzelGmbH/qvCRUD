<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\base\View $this
 * @var app\modules\qlikview\qvdocs\models\qvdocs $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="widget">

	<?php $form = ActiveForm::begin(); ?>

		<?=$form->field($model, 'qvDocumentName')->textInput(['maxlength' => 100]); ?>

		<?php /*=$form->field($model, 'time_create')->textInput();*/ ?>

		<?=$form->field($model, 'qvPath')->textInput(['maxlength' => 180]); ?>

		<?php /*=$form->field($model, 'status')->textInput(['maxlength' => 255]);*/ ?>

		<div class="form-group">
			<?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
