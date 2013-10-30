<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SpendDefinition;

/**
 * SpendDefinitionSearch represents the model behind the search form about SpendDefinition.
 */
class SpendDefinitionSearch extends Model
{
	public $ValidFrom;
	public $IsValid;
	public $SpendDefID;
	public $SpendDefDescription;
	public $Parent;

	public function rules()
	{
		return [
			['ValidFrom, IsValid, SpendDefID, SpendDefDescription, Parent', 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'ValidFrom' => 'Valid From',
			'IsValid' => 'Is Valid',
			'SpendDefID' => 'Spend Def ID',
			'SpendDefDescription' => 'Spend Def Description',
			'Parent' => 'Parent',
		];
	}

	public function search($params)
	{
		$query = SpendDefinition::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'ValidFrom');
		$this->addCondition($query, 'IsValid', true);
		$this->addCondition($query, 'SpendDefID', true);
		$this->addCondition($query, 'SpendDefDescription', true);
		$this->addCondition($query, 'Parent', true);
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
