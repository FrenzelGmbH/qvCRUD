<?php 

use \Yii;
use yii\helpers\Html;

?>

<h4>
  <i class="icon-user"></i>
  <?= Yii::t('app','Employee'); ?>
</h4>

<div class="row">
    <div class="col-md-3 text-right text-info"><p><?= Yii::t('app','From'); ?></p></div>
    <div class="col-md-9"><p><?= Html::encode($model->User->prename); ?> <?= Html::encode($model->User->name); ?></p></div>
</div>
<div class="row">
    <div class="col-md-3 text-right text-info"><p><?= Yii::t('app','Region'); ?></p></div>
    <div class="col-md-9"><p><?= Html::encode($model->User->Location->name); ?></p></div>
</div>
<div class="row">
    <div class="col-md-3 text-right text-info"><p><?= Yii::t('app','Costcenter'); ?></p></div>
    <div class="col-md-9"><p><?= Html::encode($model->User->Location->Costcenter->name); ?></p></div>
</div>

<hr>
