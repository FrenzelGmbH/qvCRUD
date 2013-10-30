<?php

namespace app\controllers;

use app\models\SpendDefinition;
use app\models\SpendDefinitionSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\VerbFilter;

/**
 * SpendDefinitionController implements the CRUD actions for SpendDefinition model.
 */
class SpendDefinitionController extends Controller
{
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
	 * Lists all SpendDefinition models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		//$searchModel = new SpendDefinitionSearch;
		//$dataProvider = $searchModel->search($_GET);
		
		$data = SpendDefinition::find()
						->select('SpendDefID, SpendDefDescription')
            ->All();

		return $this->render('index', [
			'dataProvider' => $data,
			//'searchModel' => $searchModel,
		]);
	}

	/**
	 * Displays a single SpendDefinition model.
	 * @param string $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new SpendDefinition model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new SpendDefinition;

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->SpendDefID]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing SpendDefinition model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->SpendDefID]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing SpendDefinition model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();
		return $this->redirect(['index']);
	}

	/**
	 * Finds the SpendDefinition model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return SpendDefinition the loaded model
	 * @throws HttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = SpendDefinition::find($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}
}
