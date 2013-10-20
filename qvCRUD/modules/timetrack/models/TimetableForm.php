<?php

namespace app\modules\timetrack\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\timetrack\models\Timetable;

/**
 * TimetableForm represents the model behind the search form about Timetable.
 */
class TimetableForm extends Model
{
	public $id;
	public $user_id;
	public $time_start;
	public $time_end;
	public $date_start;
	public $date_end;
	public $date_create;
	public $category;
	public $double_value;
	public $status;
	public $date_delete;

	public function rules()
	{
		return array(
			array('id, user_id', 'integer'),
			array('time_start, time_end, date_start, date_end, date_create, category, status, date_delete', 'safe'),
			array('double_value', 'number'),
		);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User ID',
			'time_start' => 'Time Start',
			'time_end' => 'Time End',
			'date_start' => 'Date Start',
			'date_end' => 'Date End',
			'date_create' => 'Date Create',
			'category' => 'Category',
			'double_value' => 'Double Value',
			'status' => 'Status',
			'date_delete' => 'Date Delete',
		);
	}

	public function search($params)
	{
		$query = Timetable::find()->Personal();
		$dataProvider = new ActiveDataProvider(array(
			'query' => $query,
		));

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'id');
		$this->addCondition($query, 'user_id');
		$this->addCondition($query, 'time_start');
		$this->addCondition($query, 'time_end');
		$this->addCondition($query, 'date_start');
		$this->addCondition($query, 'date_end');
		$this->addCondition($query, 'date_create');
		$this->addCondition($query, 'category', true);
		$this->addCondition($query, 'double_value');
		$this->addCondition($query, 'status', true);
		$this->addCondition($query, 'date_delete');
		return $dataProvider;
	}

	protected function addCondition($query, $attribute, $partialMatch = false)
	{
		$value = $this->$attribute;
		if (trim($value) === '') {
			return;
		}
		if ($partialMatch) {
			$value = '%' . strtr($value, array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')) . '%';
			$query->andWhere(array('like', $attribute, $value));
		} else {
			$query->andWhere(array($attribute => $value));
		}
	}
}
