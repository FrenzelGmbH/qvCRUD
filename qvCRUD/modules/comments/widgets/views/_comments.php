<?php

use yii\helpers\Html;
use yii\widgets\ListView;

?>

<?php 
  if(class_exists('\app\modules\comments\widgets\PortletCommentsBatch')){
    echo \app\modules\comments\widgets\PortletCommentsBatch::widget(array(
      'module'            => $module,
      'id'                => $id,
      'enableCommentsLog' => false,
      'title'             => NULL,
      'htmlOptions'       => array('class'=>'nothing'),
    )); 
  }
?>

<?php 
	echo ListView::widget(array(
		'id' => 'PortletCommentsTable',
		'dataProvider'=>$dpComments,
		'itemView' => 'iviews/_view',
		'layout' => '{items}',
		)
	);
?>
