<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\widgets\Block;

/**
 * @var yii\base\View $this
 * @var app\modules\timetrack\models\Timetable $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = array('label' => 'Timetables', 'url' => array('index'));
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Block::begin(array('id'=>'sidebar')); ?>

<?php 
  if(class_exists('\app\modules\timetrack\widgets\PortletToolbox')){
    echo \app\modules\timetrack\widgets\PortletToolbox::widget(array(
      'enableAdmin'=>false,
      'menuItems'=>array(
          array('label'=>Yii::t('app','home'),'link'=>Html::url(array('/site/index')),'icon'=>'icon-home'),
          array('label'=>Yii::t('app','overview'),'link'=>Html::url(array('/timetrack/timetrack/index')),'icon'=>'icon-list-alt'),
          $model->category==$model::CAT_HOLIDAY?array('label'=>Yii::t('app','export 2 word'),'link'=>Html::url(array('/word-export/holiday-form-sheet','id'=>$model->id)),'icon'=>'icon-tumblr'):NULL
      )
    )); 
  }
?>

<?php Block::end(); ?>

<?php Block::begin(array('id'=>'toolbar')); ?>

  <h4>
    <i class="icon-hand-down"></i>
    Hilfe
  </h4>
  
<?php if($model->category == $model::CAT_HOLIDAY): ?>  
  <p>
    Im folgenden Formblatt können Sie das Start- und Enddatum für den gewünschten Urlaubszeitraum selektieren.
    Wieviel Resturlaub Ihnen noch zusteht, sehen Sie in der unten angeführten Urlaubsstatistik. Bitte beachten Sie,
    das <b>je nach Arbeitszeitmodell</b> andere Werte aus Ihrem Urlaubsbestand abgezogen werden. Der <b>tatsächliche SALDO</b>
    wird nach Buchung durch die Personalabteilung bekannt gegeben.
  </p>
  <p>
    Der Urlaubsantrag wird in einem für das Unternehmen definierten Ablaufprozess bearbeitet. Sie werden daher
    in den kommenden Stunden/Tagen über den Verlauf oder benötigte Aktionen <b>per Mail informiert</b>.
  </p>
<?php endif; ?>

<?php Block::end(); ?>

  <h3 class="fg-color-orange"><i class="icon-book"></i> <?= Yii::t('app','Formular'); ?> - <?= Html::encode($model->CategoryAsString); ?></h3>

<div id="page">

	<?= $this->render('common/_formular_head', array(
		'model' => $model,
	)); ?>

	<?= DetailView::widget(array(
		'model' => $model,
		'attributes' => array(
			//'id',
			//'user_id',
			'time_start',
			'time_end',
			'date_start',
			'date_end',
			'date_create',
			//'category',
			'double_value',
			'status',
			//'date_delete',
		),
	)); ?>

	<p>
		<?= Html::a('Update', array('update', 'id' => $model->id), array('class' => 'btn btn-danger')); ?>
		<?= Html::a('Delete', array('delete', 'id' => $model->id), array(
			'class' => 'btn btn-danger',
			'data-confirm' => Yii::t('app', 'Are you sure to delete this item?'),
			'data-method' => 'post',
		)); ?>
	</p>

	<p>&nbsp;</p>

<?php
	if(class_exists('\app\modules\workflow\widgets\PortletWorkflowLog')){
		if(!$model->isNewRecord){
			echo \app\modules\workflow\widgets\PortletWorkflowLog::widget(array(
				'module'=>\app\modules\workflow\models\Workflow::MODULE_HOLIDAY,
				'id'=>$model->id,
			));
		}
	} 
?>

</div>
