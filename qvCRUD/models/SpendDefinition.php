<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SpendDefinition".
 *
 */
class SpendDefinition extends \yii\db\ActiveRecord
{
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
			
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
		];
	}
}
