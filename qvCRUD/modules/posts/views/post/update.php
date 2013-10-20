<?php

use yii\helpers\Html;

/**
 * @var yii\base\View $this
 * @var app\modules\posts\models\Post $model
 */

$this->title = 'Update Post: ' . $model->title;
$this->params['breadcrumbs'][] = array('label' => 'Posts', 'url' => array('index'));
$this->params['breadcrumbs'][] = array('label' => $model->title, 'url' => array('view', 'id' => $model->id));
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="module-wsp">

	<h1><?= Html::encode($this->title); ?></h1>

	<?= $this->render('_form', array(
		'model' => $model,
	)); ?>

</div>
