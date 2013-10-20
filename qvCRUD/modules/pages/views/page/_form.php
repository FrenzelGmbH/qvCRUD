<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\modules\workflow\models\Workflow;

use yiiwymeditor\yiiwymeditor;

/**
 * @var yii\base\View $this
 * @var app\modules\pages\models\Page $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="page-form">

	<?php $form = ActiveForm::begin(); ?>

<div class="row">
	<div class="col-lg-12">
		<?= $form->field($model,'title')->textInput(array('size'=>80,'maxlength'=>128,'class'=>'form-control tipster','title'=>'Titel der Seite')); ?>
		<?= $form->field($model,'name')->textInput(array('size'=>80,'maxlength'=>128)); ?>		
	</div>
</div>

<div class="row">
	<div class="col-lg-4">
		<?= $form->field($model, 'parent_pages_id')->dropDownList($model::getListOptions()); ?>
		<?= $form->field($model, 'description')->textarea(array('rows' => 2)); ?>
		<?= $form->field($model, 'tags')->textInput(array('size'=>50)); ?>
		<?= $form->field($model, 'status')->dropDownList(Workflow::getStatusOptions()); ?>
		<?= $form->field($model, 'template')->textarea(array('rows' => 2)); ?>
		<?= $form->field($model, 'vars')->textInput(); ?>
		<?= $form->field($model, 'ord')->textInput(); ?>
		<?= $form->field($model, 'special')->textInput(); ?>
		<?= $form->field($model, 'date_associated')->textInput(array('readonly'=>true)); ?>
		<?= $form->field($model, 'category')->textInput(array('maxlength' => 64)); ?>
	</div>
	<div class="col-lg-8">
		<?= yiiwymeditor::widget(array(
			'model'=>$model,
			'attribute'=>'body',
			'clientOptions'=>array(
				'toolbar' => 'basic',
				'height' => '500px',
				'filebrowserBrowseUrl' => Html::url(array('/pages/page/filemanager')),
				'filebrowserImageBrowseUrl' => Html::url(array('/pages/page/filemanager','mode'=>'image')),
			),
			'inputOptions'=>array(
				'size'=>'2',
			)
		));?>
	</div>
</div>
		
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', array('class' => 'btn btn-primary')); ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
