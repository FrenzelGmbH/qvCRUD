<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SpendDefinition".
 *
 */
class SpendDefinition extends \yii\db\ActiveRecord
{

	public $ValidFrom;
  public $IsValid;
  public $SpendDefID;
  public $SpendDefDescription;
  public $Parent;

	public static function getDb()
	{
		return Yii::$app->getComponent('dbsproserv');
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'dbo.SpendDefinition';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['SpendDefID','required'],
			['ValidFrom, IsValid, SpendDefDescription, Parent','safe'],
			['SpendDefID','string','max' => 6],
			['SpendDefDescription','string','max'=>25]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'ValidFrom' => 'Valid From',
			'IsValid' 	=> 'Is Valid',
			'SpendDefID'=> 'Spend Definition Id',
			'SpendDefDescription' => 'Description',
			'Parent'	  => 'Parent',
		];
	}
}
