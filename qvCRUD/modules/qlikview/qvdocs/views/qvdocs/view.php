<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\widgets\Block;

/**
 * @var yii\base\View $this
 * @var app\modules\qlikview\qvdocs\models\qvdocs $model
 */

$this->title = $model->qvDocumentName;
$this->params['breadcrumbs'][] = ['label' => 'Qvdocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Block::begin(array('id'=>'sidebar')); ?>

	<?php 
  if(class_exists('\app\modules\workflow\widgets\PortletToolbox')){
    echo \app\modules\timetrack\widgets\PortletToolbox::widget(array(
      'enableAdmin'=>false,
      'menuItems'=>array(
          array('label'=>Yii::t('app','overview'),'link'=>Html::url(array('/qvdocs/qvdocs/index')),'icon'=>'icon-list-alt'),          
          array('label'=>Yii::t('app','home'),'link'=>Html::url(array('/site/index')),'icon'=>'icon-home'),          
      )
    )); 
  }
?>

<?php Block::end(); ?>


<?php Block::begin(array('id'=>'toolbar')); ?>

	<?php 
  if(class_exists('\app\modules\qlikview\qvdocs\widgets\PortletGeneralInfo')){
    echo \app\modules\qlikview\qvdocs\widgets\PortletGeneralInfo::widget(array(
      'enableAdmin'=>false,
      'arrAssoc' => $dirs,
    )); 
  }
?>

<?php Block::end(); ?>

<div class="qvdocs-view">

	<h2><?= Html::encode($this->title); ?></h2>	

	<div class="widget">

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'qvDocumentName',
			'qvPath',
			'status',
			'time_create:datetime',
		],
	]); ?>

	</div>
	

	<p>
		<?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
		<?= Html::a('Delete', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data-confirm' => Yii::t('app', 'Are you sure to delete this item?'),
			'data-method' => 'post',
		]); ?>
	</p>

</div>
