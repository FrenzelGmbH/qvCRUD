<?php

use yii\helpers\Html;

/**
 * @var yii\base\View $this
 * @var app\models\SpendDefinition $model
 */

$this->title = 'Update Spend Definition: ' . $model->SpendDefID;
$this->params['breadcrumbs'][] = ['label' => 'Spend Definitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SpendDefID, 'url' => ['view', 'id' => $model->SpendDefID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="spend-definition-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
