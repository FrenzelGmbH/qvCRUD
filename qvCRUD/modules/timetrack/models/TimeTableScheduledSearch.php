<?php

namespace app\modules\timetrack\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\timetrack\models\TimeTableScheduled;

/**
 * TimeTableScheduledSearch represents the model behind the search form about TimeTableScheduled.
 */
class TimeTableScheduledSearch extends Model
{
	public $id;
	public $user_id;
	public $location_id;
	public $category;
	public $date_start;

	public function rules()
	{
		return [
			['id, user_id, location_id, category', 'integer'],
			['date_start', 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'user_id' => 'User ID',
			'location_id' => 'Location ID',
			'category' => 'Category',
			'date_start' => 'Date Start',
		];
	}

	public function search($params)
	{
		$query = TimeTableScheduled::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'id');
		$this->addCondition($query, 'user_id');
		$this->addCondition($query, 'location_id');
		$this->addCondition($query, 'category');
		$this->addCondition($query, 'date_start');
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
