<?php

namespace app\modules\qlikview\qvdocs\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\qlikview\qvdocs\models\qvdocs;

/**
 * qvdocsSearch represents the model behind the search form about qvdocs.
 */
class qvdocsSearch extends Model
{
	public $id;
	public $qvDocumentName;
	public $qvPath;
	public $status;
	public $time_create;

	public function rules()
	{
		return [
			['id, time_create', 'integer'],
			['qvDocumentName, qvPath, status', 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'qvDocumentName' => 'Qv Document Name',
			'qvPath' => 'Qv Path',
			'status' => 'Status',
			'time_create' => 'Time Create',
		];
	}

	public function search($params)
	{
		$query = qvdocs::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'id');
		$this->addCondition($query, 'qvDocumentName', true);
		$this->addCondition($query, 'qvPath', true);
		$this->addCondition($query, 'status', true);
		$this->addCondition($query, 'time_create');
		return $dataProvider;
	}

	protected function addCondition($query, $attribute, $partialMatch = false)
	{
		$value = $this->$attribute;
		if (trim($value) === '') {
			return;
		}
		if ($partialMatch) {
			$value = '%' . strtr($value, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%';
			$query->andWhere(['like', $attribute, $value]);
		} else {
			$query->andWhere([$attribute => $value]);
		}
	}
}
