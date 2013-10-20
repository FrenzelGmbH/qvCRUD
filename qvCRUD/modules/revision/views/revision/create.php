<?php

use yii\helpers\Html;

/**
 * @var yii\base\View $this
 * @var app\modules\revision\models\Revision $model
 */

$this->title = 'Create Revision';
$this->params['breadcrumbs'][] = array('label' => 'Revisions', 'url' => array('index'));
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="revision-create">

	<h1><?= Html::encode($this->title); ?></h1>

	<?= $this->render('_form', array(
		'model' => $model,
	)); ?>

</div>
