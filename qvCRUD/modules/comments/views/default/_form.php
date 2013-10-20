<?php
use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(array(
	'options' => array('class' => 'form-comment'),
)); ?>
	<?= $form->field($model,'content')->textArea(array('rows'=>4, 'cols'=>40)); ?>
	
	<div class="form-actions">		
		<?= Html::submitButton('<i class="icon-pencil"></i> '.Yii::t('app','Save'), array('class' => 'btn btn-success fg-color-white')); ?>
	</div>

<?php ActiveForm::end(); ?>
