<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

use Yii2Tooltipster\Yii2Tooltipster;
use \yii\bootstrap\Modal;

/**
 * @var $this \yii\base\View
 * @var $content string
 */
app\config\AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="<?=Yii::$app->charset; ?>"/>
	<title><?=Html::encode($this->title); ?></title>
	<?php $this->head(); ?>
</head>
<body>

<?= Yii2Tooltipster::widget(array('options'=>array('class'=>'.tipster'))); ?>

<?php 
	Modal::begin(array(
	  'id'=>'applicationModal',
	  'header' => '<h4><i class="icon-meter-medium"></i>Loading</h4>',
	  'options' => array(
	  		'width'=>'800px',
	  ),
	));
	echo 'pls. wait one moment...';
	Modal::end();
?>

<?php $this->beginBody(); ?>
	<?php 

	$MenuItems = array();
	//Bedarfssammler
	//$MenuItems[] = array('label' => 'Bedarfssammler', 'url' => array('/opportunities/index'));
	$MenuItems[] = array('label' => '<i class="icon-home"></i> '.Yii::t('app','Home'), 'url' => Yii::$app->homeUrl);

	//menu items visible for users
	if(!Yii::$app->user->isGuest)
	{

		$rootNodes = app\modules\pages\models\Page::getRootNodes();
		foreach($rootNodes AS $Node)
			 $subMenu[] = array('label'=>Yii::t('app',$Node->title),'url' => array('/pages/page/onlineview','id'=>$Node->id));

		$MenuItems[] = array('label' => '<i class="icon-book"></i> '.Yii::t('app','Content'), 'url' => '#','items' => $subMenu);		
	}

	//menu items visible for toolbox users
	if(!Yii::$app->user->isGuest)
	{

		//$subMenuToolbox[] = array('label'=>Yii::t('app','Time Control'),'url' => array('/holiday/indexuser'));
		$subMenuToolbox[] = array('label'=>Yii::t('app','Workflow Control'),'url' => array('/workflow'));
		$subMenuToolbox[] = array('label'=>Yii::t('app','Tasks'),'url' => array('/tasks'));

		$MenuItems[] = array('label' => '<i class="icon-desktop"></i> '.Yii::t('app','Toolbox'), 'url' => '','items' => $subMenuToolbox);			
	}

	//menu items visible for stores and administrator
	/*if(Yii::$app->user->identity->position==User::POS_STORE && !Yii::$app->user->isGuest){
		$MenuItems[] = array('label' => '<i class="icon-building"></i> Lagerplätze', 'url' => array('/storage/admin'));
	};*/

	//menu items visible for administrator
	if(Yii::$app->user->isAdmin){
		$qvMenuAdmin[] = array('label'=>'<i class="icon-file-text"></i> '.Yii::t('app','Documents'),'url' => array('/qvdocs/qvdocs/index'));
		
		$MenuItems[] = array('label' => '<i class="icon-gears"></i> '.Yii::t('app','QlikView'), 'url' => '','items' => $qvMenuAdmin);
	};

	//menu items visible for administrator
	if(Yii::$app->user->isAdmin){
		$subMenuAdmin[] = array('label'=>Yii::t('app','User'),'url' => array('/user/admin'));
		$subMenuAdmin[] = array('label'=>Yii::t('app','Blog Management'),'url' => array('/posts/post/index'));
		$subMenuAdmin[] = array('label'=>Yii::t('app','Revision'),'url' => array('/revision'));
		$subMenuAdmin[] = array('label'=>Yii::t('app','File Manager'),'url' => array('/site/filemanager'));
		
		$MenuItems[] = array('label' => '<i class="icon-gears"></i> '.Yii::t('app','Administration'), 'url' => '','items' => $subMenuAdmin);
	};

	//menu items visible for none stores
	if(!Yii::$app->user->isGuest){
		$MenuItems[] = array('label' => '<i class="icon-signout"></i> Abmelden', 'url' => array('/site/logout'));
	}else{
		$MenuItems[] = array('label' => '<i class="icon-signin"></i> Anmelden', 'url' => array('/site/login'));
	};

	NavBar::begin(array(
		'brandLabel' => 'qvCRUD',
		'brandUrl' => Yii::$app->homeUrl,
		'id' => 'mainnavigation',
		'options' => array('class' => 'navbar-inverse'),	
	));

		echo Nav::widget(array(
			'encodeLabels' => false,
			'options' => array('class' => 'navbar-nav pull-right'),
			'items' => $MenuItems
		)); 

	NavBar::end();

	?>

	<div class="container">
		<?=$content; ?>
	</div>

	<footer class="footer">
		<div class="container">
			<p>
				&copy; Frenzel GmbH <?=date('Y'); ?>
				<br>
			<address>
				Hohewartstr.32 <br>
				70469 Stuttgart - GERMANY
			</address>
			</p>

			<p class="pull-right">philipp@frenzel.net</p>
		</div>
	</footer>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
