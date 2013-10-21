<?php

namespace app\modules\timetrack\controllers;

use \Yii;
use yii\web\Controller;
use yii\base\HttpException;
use yii\helpers\Json;
use yii\helpers\Html;

class DefaultController extends Controller
{

  //setting the default layout to column2
  public $layout = "column3";

	public function actionIndex()
	{
		return $this->render('index');
	}

  public function actionCalendar($category=\app\modules\timetrack\models\Timetable::CAT_TIMETRACK){

    return $this->render('calendar',array('category'=>$category));
  }

  public function actionJsoncalendar($category,$start=NULL,$end=NULL,$_=NULL){
    $times = \app\modules\timetrack\models\Timetable::getCalendarBookings(Yii::$app->user->identity->id,$category,$start);

    $events = array();

    foreach ($times AS $time){
      //Testing
      $Event = new \yii2fullcalendar\models\Event();
      $Event->id = $time->id;
      $Event->title = $time->categoryAsString;
      $date_start = new \DateTime($time->date_start.' '.$time->time_start);
      $date_end = new \DateTime($time->date_start.' '.$time->time_end);
      $Event->start = $date_start->getTimestamp();
      $Event->end = $date_end->getTimestamp();
      $Event->color = $time->categoryAsColor;
      $Event->url = Html::url(array('/timetrack/timetrack/update','id'=>$time->id));
      $events[] = $Event;
    }

    header('Content-type: application/json');
    echo Json::encode($events);
    exit;
  }
}
