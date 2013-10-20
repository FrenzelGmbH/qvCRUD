<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Block;

/**
 * @var yii\base\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\qlikview\qvdocs\models\qvdocsSearch $searchModel
 */

$this->title = 'QlikView Documents';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Block::begin(array('id'=>'sidebar')); ?>

	<?php 
  if(class_exists('\app\modules\workflow\widgets\PortletToolbox')){
    echo \app\modules\timetrack\widgets\PortletToolbox::widget(array(
      'enableAdmin'=>false,
      'menuItems'=>array(
          array('label'=>Yii::t('app','create'),'link'=>Html::url(array('/qvdocs/qvdocs/create')),'icon'=>'icon-plus'),
          array('label'=>Yii::t('app','home'),'link'=>Html::url(array('/site/index')),'icon'=>'icon-home'),
          //array('label'=>Yii::t('app','overview'),'link'=>Html::url(array('/qvdocs/qvdocs/index')),'icon'=>'icon-list-alt'),          
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
		Here you manage the files and folders, that will be used to read document settings and build gui restricitions.
	</p>

<?php Block::end(); ?>

<div class="qvdocs-index">

	<h1><?php echo Html::encode($this->title); ?></h1>

	<div class="widget">

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?php echo GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			//'id',
			'qvDocumentName',
			'qvPath',
			'status',
			'time_create:datetime',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>
	</div>

</div>
