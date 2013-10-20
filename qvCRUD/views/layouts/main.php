<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

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
		$subMenuToolbox[] = array('label'=>Yii::t('app','Time Control'),'url' => array('/timetrack/default/index'));
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
		$subMenuAdmin[] = array('label'=>Yii::t('app','Locations'),'url' => array('/location/admin'));
		$subMenuAdmin[] = array('label'=>Yii::t('app','Costcenter'),'url' => array('/costcenter/admin'));
		$subMenuAdmin[] = array('label'=>Yii::t('app','User'),'url' => array('/user/admin'));
		$subMenuAdmin[] = array('label'=>Yii::t('app','Controlling'),'url' => array('/controlling/indexadmin'));
		$subMenuAdmin[] = array('label'=>Yii::t('app','Holiday'),'url' => array('/holiday/index'));
		$subMenuAdmin[] = array('label'=>Yii::t('app','Content'),'url' => array('/post/indexadmin'));
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
		<?=Breadcrumbs::widget([
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]); ?>
		<?=$content; ?>
	</div>

	<footer class="footer">
		<div class="container">
			<p class="pull-left">&copy; Frenzel GmbH <?=date('Y'); ?></p>
			<p class="pull-right"><?=Yii::powered(); ?></p>
		</div>
	</footer>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
