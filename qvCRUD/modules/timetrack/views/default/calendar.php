<?php

use yii\helpers\Html;
use yii\widgets\Block;

/**
 * @var yii\base\View $this
 * @var app\modules\timetrack\models\Timetable $model
 */

$this->title = 'Timetrack Calendar';
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
          array('label'=>Yii::t('app','overview'),'link'=>Html::url(array('/timetrack/default/index')),'icon'=>'icon-list-alt'),          
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

  $times = app\modules\timetrack\models\Timetable::find()->where(array('category'=>$category))->all();

  $events = array();

  foreach ($times AS $time){
    //Testing
    $Event = new \yii2fullcalendar\models\Event();
    $Event->id = $time->id;
    $Event->title = $time->categoryAsString;
    $Event->start = date('Y-m-d\Th:m:s\Z',strtotime($time->date_start.' '.$time->time_start));
    $Event->end = date('Y-m-d\Th:m:s\Z',strtotime($time->date_start.' '.$time->time_end));
    $events[] = $Event;
  }

  ?>
	
	<?= yii2fullcalendar\yii2fullcalendar::widget(array(
      //not needed anymore as ajax events is taking over ... 'events'=> $events,
      'ajaxEvents' => Html::Url(array('/timetrack/default/jsoncalendar','category'=>$category)),
  ));?>

</div>

</div>
