<?php

namespace app\modules\qlikview\qvdocs\controllers;

use app\modules\qlikview\qvdocs\models\qvdocs;
use app\modules\qlikview\qvdocs\models\qvdocsSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\VerbFilter;

use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local;

use \XMLReader;
use \Yii;

/**
 * qvdocsController implements the CRUD actions for qvdocs model.
 */
class qvdocsController extends Controller
{

	/**
	 * the layout that will be used by default for this controller
	 * @var string
	 */
	public $layout = 'column3';

	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	/**
	 * Lists all qvdocs models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new qvdocsSearch;
		$dataProvider = $searchModel->search($_GET);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
	}

	/**
	 * Displays a single qvdocs model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		$dirname = sprintf(
        '%s/Solution Rights-prj',
        $model->qvPath
    );
    $filesystem = new Filesystem(new Local($dirname));    
    $dirs = $filesystem->listKeys();

    foreach($dirs AS $key => $values){
    	foreach ($values AS $value){
    		if($value === Yii::$app->params['QlikViewPrjFile']){
			    $xml = new XMLReader();
					$xml->xml($filesystem->read($value));
					$content = $model::xml2assocpf($xml); 
    		}
    	}
    }  

		return $this->render('view', [
			'dirs'  => $content,
			'model' => $model,
		]);
	}

	/**
	 * Creates a new qvdocs model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$this->layout = 'column3';
		$model = new qvdocs;

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing qvdocs model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$this->layout = 'column3';
		$model = $this->findModel($id);

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing qvdocs model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();
		return $this->redirect(['index']);
	}

	/**
	 * Finds the qvdocs model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return qvdocs the loaded model
	 * @throws HttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = qvdocs::find($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}
}
