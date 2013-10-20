<?php

namespace app\modules\timetrack\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\timetrack\models\TimeTableScheduledDetailed;

/**
 * TimeTableScheduledDetailedSearch represents the model behind the search form about TimeTableScheduledDetailed.
 */
class TimeTableScheduledDetailedSearch extends Model
{
	public $id;
	public $time_table_scheduled_id;
	public $odd_even;
	public $time_start;
	public $time_end;
	public $day_of_week;

	public function rules()
	{
		return [
			['id, time_table_scheduled_id, odd_even, day_of_week', 'integer'],
			['time_start, time_end', 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'time_table_scheduled_id' => 'Time Table Scheduled ID',
			'odd_even' => 'Odd Even',
			'time_start' => 'Time Start',
			'time_end' => 'Time End',
			'day_of_week' => 'Day Of Week',
		];
	}

	public function search($params)
	{
		$query = TimeTableScheduledDetailed::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'id');
		$this->addCondition($query, 'time_table_scheduled_id');
		$this->addCondition($query, 'odd_even');
		$this->addCondition($query, 'time_start');
		$this->addCondition($query, 'time_end');
		$this->addCondition($query, 'day_of_week');
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
