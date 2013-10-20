<?php

use yii\helpers\Html;

/**
 * @var yii\base\View $this
 * @var app\modules\revision\models\Revision $model
 */

$this->title = 'Update Revision: ' . $model->id;
$this->params['breadcrumbs'][] = array('label' => 'Revisions', 'url' => array('index'));
$this->params['breadcrumbs'][] = array('label' => $model->id, 'url' => array('view', 'id' => $model->id));
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="revision-update">

	<h1><?= Html::encode($this->title); ?></h1>

	<?= $this->render('_form', array(
		'model' => $model,
	)); ?>

</div>
