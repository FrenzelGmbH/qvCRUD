<?php

namespace app\modules\revision\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\revision\models\Revision;

/**
 * RevisionForm represents the model behind the search form about Revision.
 */
class RevisionForm extends Model
{
	public $id;
	public $content;
	public $status;
	public $creator_id;
	public $time_create;
	public $revision_table;
	public $revision_id;

	public function rules()
	{
		return array(
			array('id, creator_id, time_create, revision_table, revision_id', 'integer'),
			array('content, status', 'safe'),
		);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => 'Content',
			'status' => 'Status',
			'creator_id' => 'Creator ID',
			'time_create' => 'Time Create',
			'revision_table' => 'Revision Table',
			'revision_id' => 'Revision ID',
		);
	}

	public function search($params)
	{
		$query = Revision::find();
		$dataProvider = new ActiveDataProvider(array(
			'query' => $query,
		));

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'id');
		$this->addCondition($query, 'content', true);
		$this->addCondition($query, 'status', true);
		$this->addCondition($query, 'creator_id');
		$this->addCondition($query, 'time_create');
		$this->addCondition($query, 'revision_table');
		$this->addCondition($query, 'revision_id');
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
