<?php

namespace app\modules\posts\controllers;

use app\modules\posts\models\Post;
use app\modules\posts\models\PostSearch;
use yii\data\ActiveDataProvider;
//use yii\web\Controller;
use yii\web\HttpException;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends DefaultController
{

	public $layout = "column2";

	/**
	 * Lists all Post models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new PostSearch;
		$dataProvider = $searchModel->search($_GET);

		return $this->render('index', array(
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		));
	}

	/**
	 * Displays a single Post model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', array(
			'model' => $this->findModel($id),
		));
	}

	/**
	 * Creates a new Post model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Post;

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(array('view', 'id' => $model->id));
		} else {
			return $this->render('create', array(
				'model' => $model,
			));
		}
	}

	/**
	 * Updates an existing Post model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(array('view', 'id' => $model->id));
		} else {
			return $this->render('update', array(
				'model' => $model,
			));
		}
	}

	/**
	 * Deletes an existing Post model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();
		return $this->redirect(array('index'));
	}

	/**
	 * Finds the Post model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Post the loaded model
	 * @throws HttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Post::find($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}
}
