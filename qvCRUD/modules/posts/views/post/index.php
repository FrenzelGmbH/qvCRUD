<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;

/**
 * @var yii\base\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\posts\models\PostSearch $searchModel
 */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php yii\widgets\Block::begin(array('id'=>'sidebar')); ?>

	<?php 

	$sideMenu = array();
	$sideMenu[] = array('decoration'=>'sticker sticker-color-yellow','icon'=>'icon-arrow-left','label'=>Yii::t('app','Home'),'link'=>Html::url(array('/site/index')));
	$sideMenu[] = array('decoration'=>'sticker sticker-color-green','icon'=>'icon-plus','label'=>Yii::t('app','New Post'),'link'=>Html::url(array('/posts/post/create')));

	echo app\modules\posts\widgets\PortletSidemenu::widget(array(
		'sideMenu'=>$sideMenu,
		'enableAdmin'=>false,
		'htmlOptions'=>array('class'=>'nostyler'),
	)); ?>	 
	
<?php yii\widgets\Block::end(); ?>

<div class="module-wsp">

	<h1><?= Html::encode($this->title); ?></h1>

	<hr>

	<?= GridView::widget(array(
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => array(
			'id',
			'title',
			//'content:ntext',
			'tags:ntext',
			'status',
			// 'author_id',
			// 'time_create:datetime',
			// 'time_update:datetime',
			array(
				'class' => DataColumn::className(),
				'content'=>function($data, $row) {
					$html = Html::a(NULL, array("/posts/post/update", "id"=>$data->id), array('class' => 'edit icon icon-edit', "id"=>$data->id));
					$html .= ' | ';
					$html .= Html::a(NULL, array("/posts/post/delete", "id"=>$data->id), array('class'=>'delete icon icon-trash'));
					return $html;
				}
			),
		),
	)); ?>

</div>
