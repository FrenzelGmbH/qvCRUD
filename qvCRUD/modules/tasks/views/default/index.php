<?php

use yii\helpers\Html;
use yii\widgets\ListView;

use yii\widgets\Block;

/**
 * @var yii\base\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\pages\models\PageForm $searchModel
 */

$this->title = 'ToDos';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Block::begin(array('id'=>'sidebar')); ?>

	<?php 

	$sideMenu = array();
	$sideMenu[] = array('decoration'=>'sticker sticker-color-yellow','icon'=>'icon-home','label'=>Yii::t('app','Home'),'link'=>Html::url(array('/site/index')));
	$sideMenu[] = array('icon'=>'icon-plus','label'=>Yii::t('app','new Todo'),'link'=>Html::url(array('/tasks/task/create')));
	$sideMenu[] = array('decoration'=>'sticker sticker-color-green','icon'=>'icon-list-alt','label'=>Yii::t('app','Overview'),'link'=>Html::url(array('/tasks/default/index')));

	echo \app\modules\tasks\widgets\PortletToolbox::widget(array(
		'menuItems'=>$sideMenu,
		'enableAdmin'=>false,
	)); ?>	 
	
<?php Block::end(); ?>

<div class="module-wsp">

	<h4><?= Html::encode($this->title); ?></h4>

	<?php //echo $this->render('_search', array('model' => $searchModel)); ?>

	<hr>
<div class="box bordered">
	<ul class="list-group">
		<?php 
			echo ListView::widget(array(
						'id'           => 'IndexTaskView',
						'dataProvider' => $dpTasks,
						'itemView'     => 'iviews/_view',
						'layout'     => '<div class="box-header">{summary}</div>{items}{pager}',
					)
			);
		?>
	</ul>
</div>

</div>
