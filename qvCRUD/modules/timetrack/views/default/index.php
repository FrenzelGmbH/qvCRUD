<?php

use yii\helpers\Html;
use yii\widgets\Block;

/**
 * @var yii\base\View $this
 * @var app\modules\timetrack\models\Timetable $model
 */

$this->title = 'Timetrack';
$this->params['breadcrumbs'][] = array('label' => 'Overview', 'url' => array('index'));
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
  
  <p>
    Alle Einträge die mit der Arbeitszeit zu tun haben.
  </p>

<?php Block::end(); ?>

<div id="page">

<div class="timetrack-default-index">
	<h3 class="fg-color-orange"><?= $this->title; ?></h3>
	
	<?php
		echo app\modules\timetrack\widgets\PortletTimetrackAdmin::widget(array(
			'enableAdmin' => false,
		));
	?>

</div>

</div>
