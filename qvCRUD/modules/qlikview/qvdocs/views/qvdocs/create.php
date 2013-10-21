<?php

use yii\helpers\Html;
use yii\widgets\Block;

/**
 * @var yii\base\View $this
 * @var app\modules\qlikview\qvdocs\models\qvdocs $model
 */

$this->title = 'Create QlikView Document';
$this->params['breadcrumbs'][] = ['label' => 'Qvdocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Block::begin(array('id'=>'sidebar')); ?>

<?php 
  if(class_exists('\app\modules\workflow\widgets\PortletToolbox')){
    echo \app\modules\timetrack\widgets\PortletToolbox::widget(array(
      'enableAdmin'=>false,
      'menuItems'=>array(
          array('label'=>Yii::t('app','home'),'link'=>Html::url(array('/site/index')),'icon'=>'icon-home'),
          array('label'=>Yii::t('app','overview'),'link'=>Html::url(array('/qvdocs/qvdocs/index')),'icon'=>'icon-list-alt'),          
      )
    )); 
  }
?>

<?php Block::end(); ?>


<?php Block::begin(array('id'=>'toolbar')); ?>

  <h4>
    <i class="icon-hand-down"></i>
    Help
  </h4>
 
  <p>
    For a correct working system, you need to give over the following to values as followed:
    <ul>
      <li>DocumentName.qvw</li>
      <li>c:/your/path/to/document</li>
    </ul>
  </p>
  <p>
    Note: No slash at the end of the folder!
  </p>

<?php Block::end(); ?>

<div class="qvdocs-create">

	<h1><?php echo Html::encode($this->title); ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
