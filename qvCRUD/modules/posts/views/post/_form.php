<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\modules\workflow\models\Workflow;
use yiiwymeditor\yiiwymeditor;

/**
 * @var yii\base\View $this
 * @var app\modules\posts\models\Post $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="post-form">

  <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(array('maxlength' => 128)); ?>

    <?= yiiwymeditor::widget(array(
      'model'=>$model,
      'attribute'=>'content',
      'clientOptions'=>array(
        'toolbar' => 'basic',
        'height' => '200px',
        'filebrowserBrowseUrl' => Html::url(array('/pages/page/filemanager')),
        'filebrowserImageBrowseUrl' => Html::url(array('/pages/page/filemanager','mode'=>'image')),
      ),
      'inputOptions'=>array(
        'size'=>'2',
      )
    ));?>

    <?= $form->field($model,'status')->dropDownList(Workflow::getStatusOptions()); ?>

    <?= $form->field($model, 'tags')->textInput(); ?>

    <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', array('class' => 'btn btn-primary')); ?>
    </div>

  <?php ActiveForm::end(); ?>

</div>
