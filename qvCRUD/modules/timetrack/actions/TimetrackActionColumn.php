<?php

namespace app\modules\timetrack\actions;

use \Yii;
use \Closure;

use yii\helpers\Html;
use yii\grid\ActionColumn;

/**
 * @author  <philipp@frenzel.net>
 */

class TimetrackActionColumn extends ActionColumn
{

  /**
   * @param \yii\db\ActiveRecord $model
   * @param string $action
   * @return string
   */
  public function createUrl($model, $action)
  {
    if ($this->urlCreator instanceof Closure) {
      return call_user_func($this->urlCreator, $model, $action);
    } else {
      $route = '/timetrack/timetrack/' . $action;
      $params = $model->getPrimaryKey(true);
      if (count($params) === 1) {
        $params = array('id' => reset($params));
      }
      return Yii::$app->getUrlManager()->createUrl($route, $params);
    }
  }

}
