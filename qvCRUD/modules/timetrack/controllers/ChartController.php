<?php
/**
 * The CharttimeController is used for json requests from Timetable
 *
 * @author Philipp Frenzel <philipp@frenzel.net>
 */

namespace app\modules\timetrack\controllers;

use \Yii;
use yii\web\Controller;
use yii\base\HttpException;
use yii\helpers\Json;

use app\modules\timetrack\models\Timetable;

class ChartController extends Controller
{
	
	public function behaviors() {
		return array(
			'AccessControl' => array(
				'class' => '\yii\web\AccessControl',
				'rules' => array(
					array(
						'allow'=>true,
					)
				)
			)
		);
	}

	/**
	 * returns the current holiday, sickness, etc. values for passed user
	 *
	 * @param int $id The user id (used for paginating)
	 */

	public function actionJsonpieemployeesheet($id){
		//array of colors
		$colors=array('#556B2F','#556B2F','#556B2F','#556B2F','#556B2F','#556B2F');

		$data = Timetable::getUserStats($id);
		$clean = array();
		$ii=0;
		foreach($data AS $record){
			$ii++;
			$value = (double)$record->double_value>=0?1:$record->double_value*-1;
			$clean[]=array('id'=>$ii,'value'=>$value,'status'=>$record->status,'color'=>$colors[$ii]);
		}
		header('Content-type: application/json');
		echo Json::encode($clean);
		exit;
	}

	/**
	 * returns the current holiday, sickness, etc. values for passed user
	 *
	 * @param int $id The user id (used for paginating)
	 */

	public function actionJsongridemployeesheet($id){
		//array of colors
		$colors=array('#556B2F','#556B2F','#556B2F','#556B2F','#556B2F','#556B2F');

		$data = Timetable::getUserStats($id);
		$clean = array('pos'=>0, 'total_count'=>50000);
		$ii=0;
		foreach($data AS $record){
			$ii++;
			$value = (double)$record->double_value>=0?1:$record->double_value*-1;
			$clean['rows'][]=array(
				'id' => $ii,
				'style' => "color:".$colors[$ii].";",
				'data' => array(
					$record->CategoryAsString,
					$value,
				)
			);
		}
		header('Content-type: application/json');
		echo Json::encode($clean);
		exit;
	}

}