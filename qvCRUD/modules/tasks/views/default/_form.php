<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\widgets\Block;

use app\modules\workflow\models\Workflow;

use app\modules\workflow\widgets\PortletWorkflowLog;
/**
 * @var yii\base\View $this
 * @var app\modules\tasks\models\Task $model
 * @var ActiveForm $form
 */
?>

<?php Block::begin(array('id'=>'sidebar')); ?>

	<?php 

	$sideMenu = array();
	$sideMenu[] = array('decoration'=>'sticker sticker-color-yellow','icon'=>'icon-home','label'=>Yii::t('app','Home'),'link'=>Html::url(array('/site/index')));
	$sideMenu[] = array('decoration'=>'sticker sticker-color-green','icon'=>'icon-list-alt','label'=>Yii::t('app','Overview'),'link'=>Html::url(array('/tasks/default/index')));

	echo app\modules\tasks\widgets\PortletToolbox::widget(array(
		'menuItems'=>$sideMenu,
		'enableAdmin' => false,
	)); ?>	 
	
<?php Block::end(); ?>



<div id="page" class="form">

<h3><?= $this->context->action->uniqueId; ?></h3>

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'content')->textArea(array('rows'=>3)); ?>
		<?= $form->field($model, 'creator_id')->textInput(array('readonly' => 'true')); ?>
		<?= $form->field($model, 'time_create')->textInput(array('readonly' => 'true')); ?>
		<?= $form->field($model, 'task_table')->textInput(array('readonly' => 'true')); ?>
		<?= $form->field($model, 'task_id')->textInput(array('readonly' => 'true')); ?>
		<?= $form->field($model, 'status')->dropDownList(Workflow::getStatusOptions()); ?>
	
		<div class="form-group">
			<?= Html::submitButton('<i class="icon-pencil"></i> '.$model->isNewRecord ? Yii::t('app','Create'):Yii::t('app','Update'), array('class'=>'btn btn-success fg-color-white')); ?>
		</div>
	<?php ActiveForm::end(); ?>

<?php
	if(!$model->isNewRecord){
		echo PortletWorkflowLog::widget(array(
			'module'=>Workflow::MODULE_TASKS,
			'id'=>$model->id,
		));
	} 
?>

</div><!-- _form -->
