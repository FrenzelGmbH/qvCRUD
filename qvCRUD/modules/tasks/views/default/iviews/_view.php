<?php

use \Yii;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

use app\models\User;
use app\modules\workflow\models\Workflow;
use app\modules\tasks\models\Task;

?>

<li class="task-box">
  <table class="table table-condensed">
    
    <tr>
      <td width="5%"><h4><i class="icon-check-empty"></i></h4></td>
      <td width="75%">
        <h4>
          <img src="http://lorempixel.com/40/40/animals" alt="Animals"></img>        
          <?= Yii::t('app','For').' '.strtoupper(User::find($model['creator_id'])->prename) .' '. strtoupper(User::find($model['creator_id'])->name); ?>
        </h4>        
      </td>
      <td>
        <small><i class="icon-time"></i> <?= date('Y-m-d h:m',$model['time_create']); ?></small>
        <h4><?= strtoupper(Workflow::getModuleAsString($model['task_table'])); ?></h4>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <i class="icon-quote-left"></i>&nbsp;
        <?= $model['content']; ?></td>
      <td>
        <small>Status:</small>
        <span class="label label-info">
          <?= Html::encode($model['status']); ?>
        </span>
      </td>
    </tr>
    
    <tr>
      <td><h4><i class="icon-angel-right"></i></h4></td>
      <td>
        <a href="<?= Task::getUrl($model['task_table'],$model['task_id'],'view'); ?>" class="btn btn-success btn-sm"> 
          <i class="icon-eye-open"> </i>
          <?= Yii::t('app','view'); ?> 
        </a>

        <a href="<?= Task::getUrl(Workflow::MODULE_TASKS,$model['id'],'update'); ?>" class="btn btn-info btn-sm"> 
          <i class="icon-pencil"> </i>
          <?= Yii::t('app','update'); ?> 
        </a>
      </td>
      <td></td>
    </tr>
  </table>  
</li>
