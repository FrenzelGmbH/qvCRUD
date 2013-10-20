<?php

use yii\helpers\Html;
use yii\widgets\Block;
use yii\helpers\HtmlPurifier;
use yii\widgets\Breadcrumbs;

/**
 * @var yii\base\View $this
 * @var app\modules\pages\models\Page $model
 */

$this->title = $model->name;

if(!is_null($model->Parent->title))
	$this->params['breadcrumbs'][] = array('label' => $model->Parent->title, 'url' => array('/pages/page/onlineview','id'=>$model->parent_pages_id));

$this->params['breadcrumbs'][] = array('label' => $this->title);
?>

<?php
	if(Yii::$app->user->isAdvanced):
?>

<div class="frztoolbar">
		<?= Html::a('<i class="icon-plus"> </i> '.Yii::t('app','Create'), array('create', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
    &nbsp;&nbsp;<?= Html::a('<i class="icon-pencil"> </i> '.Yii::t('app','Update'), array('update', 'id' => $model->id), array('class' => 'btn btn-info')); ?>
		&nbsp;&nbsp;<?= Html::a('<i class="icon-trash"> </i> '.Yii::t('app','Delete'), array('delete', 'id' => $model->id), array('class' => 'btn btn-danger')); ?>
</div>

<?php
	endif;
?>

<?= Breadcrumbs::widget(array(
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : array(),
		)); ?>

<?php Block::begin(array('id'=>'sidebar')); ?>

  <?php 
    if(class_exists('\app\modules\pages\widgets\PortletPageToc') && Yii::$app->user->isUser){
      echo \app\modules\pages\widgets\PortletPageToc::widget(); 
    }
  ?>  

	<?php
		if(in_array("advanced",explode(';',$model->vars))){
			echo app\modules\pages\widgets\PortletCmsToc::widget(array(
    			'rootId'=>$model->id,
    			'contentCssClass' => 'bg-color-white'
			));
		}else{
			echo app\modules\pages\widgets\PortletPageNavigationSub::widget(array(
    		'id'=>$model->id,
			));
		}
		if(in_array("search",explode(';',$model->vars))){
			echo app\modules\pages\widgets\PortletPagesSearch::widget();
		}
	?>

  <?php 
    if(class_exists('\app\modules\pages\widgets\PortletCmsHistory') && Yii::$app->user->isUser){
      echo \app\modules\pages\widgets\PortletCmsHistory::widget(array(
        'id'=>$model->id,
      )); 
    }
  ?>

<?php Block::end(); ?>

<?php 
	if(class_exists('\app\modules\tasks\widgets\PortletTasksBatch') && Yii::$app->user->isAdvanced){
		echo \app\modules\tasks\widgets\PortletTasksBatch::widget(array(
			'module'=>\app\modules\workflow\models\Workflow::MODULE_CMS,
			'id'=>$model->id,
		)); 
	}
?>

<div id="onlineviewwrap">
	<h1 class="fg-color-orange"><?= Html::encode($this->title); ?></h1>
	<?php 
		echo HtmlPurifier::process($model->body);
	?>
</div>

<?php 
  if(class_exists('\app\modules\comments\widgets\PortletComments') && Yii::$app->user->isAdvanced){
    echo \app\modules\comments\widgets\PortletComments::widget(array(
      'module'=>\app\modules\workflow\models\Workflow::MODULE_CMS,
      'id'=>$model->id,
    )); 
  }
?>
