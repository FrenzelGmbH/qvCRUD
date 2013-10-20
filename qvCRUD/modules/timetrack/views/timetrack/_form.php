<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\jui\DatePicker;
use yii\widgets\MaskedInput;

use yii\web\JsExpression;

/**
 * @var yii\base\View $this
 * @var app\modules\timetrack\models\Timetable $model
 * @var yii\widgets\ActiveForm $form
 */

/*$WizJS = <<<WIZJS

$('#myWizard').Wizard();

WIZJS;

$this->registerJs($WizJS);*/

?>

<?= $this->render('common/_formular_head', array(
		'model' => $model,
)); ?>

<h3>
  	<i class="icon-pencil"></i>
  	<?= Yii::t('app','Input'); ?>
</h3>

<?php $form = ActiveForm::begin(); ?>

<div class="step-content">
  <div class="step-pane active" id="step1">

<div class="row">
	
	<div class="col-md-6">
		
		<div class="form-group">
			<label class="control-label"><?= Yii::t('app','Start Date'); ?></label>
			<?php

					$JSDateJump = new JsExpression('function( selectedDate ) {$( "#bookingform_dateend" ).datepicker( "option", "minDate", selectedDate );}');

					echo DatePicker::widget(array(
					  'id' => 'bookingform_datestart',
					  'language' => 'sv',
				      'model' => $model,
				      'attribute' => 'date_start',
				      'inline'=>false,
				      'options'=>array('class'=>'form-control'),
				      'clientOptions' => array(
				          'dateFormat' => 'yy-mm-dd',
				          'showOn' => 'both',
				          'changeMonth' => false,
				          'numberOfMonths' => 2,	
				          'onClose' => $JSDateJump,					          
				      ),
				      
					));?>
		</div>

	</div>	

	<div class="col-md-6">
		
<?php if($model->category <> $model::CAT_TIMETRACK): ?>


		<div class="form-group">
			<label class="control-label"><?= Yii::t('app','End Date'); ?></label>
					<?= DatePicker::widget(array(
						'id' => 'bookingform_dateend',
						'language' => 'sv',
					    'model' => $model,
					    'attribute' => 'date_end',
					    'inline'=>false,
					    'options'=>array('class'=>'form-control'),
					    'clientOptions' => array(
					          'dateFormat' => 'yy-mm-dd',
					          'changeMonth' => false,
				          	  'numberOfMonths' => 2,
					          'showOn' => 'both'								          
					    ),
					));?>
		</div>

<?php endif; ?>

	</div>

</div>

<?php if($model->category == $model::CAT_TIMETRACK): ?>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label"><?= Yii::t('app','Start Time'); ?></label>
			<?= MaskedInput::widget(array(
								'model'=>$model,
								'attribute'=>'time_start',
								'mask'=>'99:99',
								'options'=>array('class'=>'form-control'),
			));?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label"><?= Yii::t('app','End Time'); ?></label>
			<?= MaskedInput::widget(array(
								'model'=>$model,
								'attribute'=>'time_end',
								'mask'=>'99:99',
								'options'=>array('class'=>'form-control'),
			));?>
		</div>
	</div>
</div>

<?php endif; ?>

<?php 
	if(class_exists('\app\modules\timetrack\widgets\PortletHolidayStatistic') && $model->category == $model::CAT_HOLIDAY){
		echo \app\modules\timetrack\widgets\PortletHolidayStatistic::widget(array(
			'user_id'=>$model->user_id,
		)); 
	}
?>

<?php
	if(class_exists('\app\modules\workflow\widgets\PortletWorkflowLog') && !$model->isNewRecord){
		echo \app\modules\workflow\widgets\PortletWorkflowLog::widget(array(
			'module'=>\app\modules\workflow\models\Workflow::MODULE_HOLIDAY,
			'id'=>$model->id,
		));
	} 
?>

<div id="myWizard" class="wizard">
  <ul class="steps">
    <li data-target="#step1" class="active"><span class="badge badge-info">1</span><?= Yii::t('app',$model->status); ?><span class="chevron"></span></li>
    <li data-target="#step2"><span class="badge">2</span> ... <span class="chevron"></span></li>
  </ul>
  	<div class="actions">
	    <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), array('class' => 'btn btn-primary btn-xs')); ?>
	    <!--button type="button" class="btn btn-xs btn-prev"> <i class="icon-arrow-left"></i>Prev</button>
	    <button type="button" class="btn btn-xs btn-next" data-last="Finish">Next<i class="icon-arrow-right"></i></button-->
  </div>  
</div>		
	
	</div>
	<div class="step-pane" id="step2">
		<?= $form->field($model,'category')->dropDownList($model->getCategoryOptions(),array('readonly'=>'readonly')); ?>
		<?= $form->field($model, 'user_id')->textInput(array('readonly'=>true)); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>
