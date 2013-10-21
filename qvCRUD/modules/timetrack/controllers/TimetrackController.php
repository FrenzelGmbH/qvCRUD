<?php

namespace app\modules\timetrack\controllers;

use \Yii;

use app\modules\timetrack\models\Timetable;
use app\modules\timetrack\models\TimetableForm;

use app\modules\workflow\models\Workflow;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\VerbFilter;

/**
 * TimetrackController implements the CRUD actions for Timetable model.
 */
class TimetrackController extends Controller
{
	//setting the default layout to column2
	public $layout = "column2";

	public function behaviors()
	{
		return array(
			'verbs' => array(
				'class' => VerbFilter::className(),
				'actions' => array(
					'delete' => array('post'),
				),
			),
		);
	}

	/**
	 * Lists all Timetable models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		//change layout to column3
		$this->layout = "column1";
		$searchModel = new TimetableForm;
		$dataProvider = $searchModel->search($_GET);

		return $this->render('index', array(
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		));
	}

	/**
	 * Displays a single Timetable model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		//change layout to column3
		$this->layout = "column3";
		return $this->render('view', array(
			'model' => $this->findModel($id),
		));
	}

	/**
	 * Creates a new Timetable model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($category=3)
	{
		//change layout to column3
		$this->layout = "column3";
		$model = new Timetable;
		$model->category = $category;
		$model->user_id=Yii::$app->user->identity->id;
		$model->status = Workflow::STATUS_REQUESTED;

		if ($model->load($_POST) && $model->save()) {
			if($category == $model::CAT_HOLIDAY or $category == $model::CAT_WEDDING or $category == $model::CAT_MOVEMENT OR $category == $model::CAT_OTHER)
			{
				$link = Yii::$app->params['consoleBaseUrl']."/index.php?r=timetrack/timetrack/view&id=".$model->id;
				$user_id = Yii::$app->user->identity->parent_user_id;
				$workflow = Workflow::addRecordIntoWorkflow(Workflow::MODULE_HOLIDAY,$model->id,Workflow::STATUS_CREATED,$user_id,array(Workflow::ACTION_APPROVE,Workflow::ACTION_REJECT,Workflow::ACTION_CHANGE));
				Workflow::sendWorkflowMail($model->categoryAsString.' beantragt',$workflow,$link);
			}
			return $this->redirect(array('view', 'id' => $model->id));
		} else {
			return $this->render('create', array(
				'model' => $model,
			));
		}
	}

	/**
	 * Updates an existing Timetable model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		//change layout to column3
		$this->layout = "column3";
		$model = $this->findModel($id);

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(array('/timetrack/default/calendar', 'start' => $model->date_start));
		} else {
			return $this->render('update', array(
				'model' => $model,
			));
		}
	}

	/**
	 * Deletes an existing Timetable model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		// we only allow deletion via POST request
		$model = $this->loadModel($id);
		$user_id = $model->user_id;
		$model->status = Workflow::STATUS_ARCHIVED;
		$model->date_delete = date('Y-m-d');
		if(Yii::$app->user->isAdmin)
			$model->save();
		return $this->redirect(array('index'));
	}

	/**
	 * Finds the Timetable model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Timetable the loaded model
	 * @throws HttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Timetable::find($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}
}
