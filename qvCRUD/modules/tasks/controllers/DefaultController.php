<?php

namespace app\modules\tasks\controllers;

use \Yii;
use yii\db\Query;
use yii\web\Controller;

use yii\helpers\Html;
use yii\helpers\Json;

use yii\data\Sort;
use yii\data\ActiveDataProvider;

use app\modules\workflow\models\Workflow;
use app\modules\tasks\models\Task;

class DefaultController extends Controller
{
	/**
	* @var string layout as default for the rendering
	*/
	public $layout='column3';

	//container for the current model
	private $_model = NULL;

	public function behaviors() {
		return array(
			'AccessControl' => array(
				'class' => '\yii\web\AccessControl',
				'rules' => array(
					array(
						'allow'=>true, 
						'roles'=>array('@'), // allow authenticated users to access all actions
					),
					array(
						'allow'=>false
					),
				)
			)
		);
	}

	public function actionIndex()
	{
		$query= new Query();

		$query->select('task.*,task.status AS status ,workflow.status_to AS wf_status')
			  ->from('tbl_task task')
			  ->join('LEFT JOIN','tbl_workflow workflow','workflow.wf_id = (SELECT max(id) FROM tbl_workflow WHERE task.id = tbl_workflow.wf_id AND workflow.wf_table = '.Workflow::MODULE_TASKS.')')
			  ->where('status <> :status',array(':status'=>Workflow::STATUS_ARCHIVED));

		$sort = new Sort(array(
          'attributes' => array(
              'id',
              'task_table'
        	),
      	));

     $dpTasks = new ActiveDataProvider(array(
		      'query' => $query,
		      'pagination' => array(
		          'pageSize' => 10,
		      ),
		      'sort' => $sort
	  	));

		return $this->render('index',array(
			'dpTasks' => $dpTasks,
		));

	}

	public function actionView($id){
		$model = $this->loadModel($id);
		return $this->render('_form',array(
			'model'=>$model,
		));
	}

	public function actionViewwindow($id,$module)
	{
		echo $this->renderPartial('windows/view',array(
			'module' => $module,
			'id'     => $id,
		));
	}

	public function actionUpdate($id)
	{
	    $model = $this->loadModel($id);	    

	    if ($model->load($_POST)) {
	        if($model->validate()) {
	        	if ($model->save()) {
					return $this->redirect(array('index'));
				}else{
	            	throw new \yii\web\HttpException(404,'The requested page does not exist.');
	            }
	        }
	    }

	    return $this->render('_form', array(
	        'model' => $model,
	    ));
	}

	public function actionCreate()
	{
	    $model = new Task;	    

	    if ($model->load($_POST)) {
	        if($model->validate()) {
	        	if ($model->save()) {
					return $this->redirect(array('index'));
				}else{
	            	throw new \yii\web\HttpException(404,'The requested page does not exist.');
	            }
	        }
	    }

	    $model->isNewRecord = true;
	    return $this->render('_form', array(
	        'model' => $model,
	    ));
	}

	public function actionCreatewindow($id,$module){		
		//define the request target		
		$requestUrl = Html::url(array('default/createwindow','id'=>$id,'module'=>$module));
		
		$model=new Task();
		$model->task_id = $id;
		$model->task_table = $module;
		$model->creator_id = Yii::$app->user->id;
		if ($model->load($_POST)) {
			if($model->save()){
				$myCounter = Task::getAdapterForTaskLogCount($module,$id);
				header('Content-type: application/json');
				$myResponse = array('info'=>'Done!','id'=>$model->id,'content'=>$model->content,'newCount'=>$myCounter);
				echo Json::encode($myResponse);
				exit;
			}
			else{
				throw new \yii\web\HttpException(404,'ERROR happened, pls contact '.Yii::$app->params[adminEmail].'.');
			}
		}

		$this->layout = '/column1';
		echo $this->renderPartial('windows/update',array(
			'model'=>$model,
			'requestUrl' => $requestUrl,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel($id='')
	{
		if($this->_model===null)
		{
			if(!empty($id))
			{
				$this->_model=Task::find($id);				
			}
			if($this->_model===null)
				throw new \yii\web\HttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}
