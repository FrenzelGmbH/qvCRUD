<?php

use yii\helpers\Html;

/**
 * @var yii\base\View $this
 * @var app\modules\qlikview\qvdocs\models\qvdocs $model
 */

$this->title = 'Update Qvdocs: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Qvdocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="qvdocs-update">

	<h1><?php echo Html::encode($this->title); ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
