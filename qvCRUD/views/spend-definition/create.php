<?php

use yii\helpers\Html;

/**
 * @var yii\base\View $this
 * @var app\models\SpendDefinition $model
 */

$this->title = 'Create Spend Definition';
$this->params['breadcrumbs'][] = ['label' => 'Spend Definitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spend-definition-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
