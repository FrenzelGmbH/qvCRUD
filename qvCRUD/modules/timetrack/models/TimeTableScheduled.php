<?php

namespace app\modules\timetrack\models;

/**
 * This is the model class for table "tbl_time_table_scheduled".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $location_id
 * @property integer $category
 * @property string $date_start
 *
 * @property Location $location
 * @property User $user
 * @property TimeTableScheduledDetail[] $timeTableScheduledDetails
 */
class TimeTableScheduled extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'tbl_time_table_scheduled';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['user_id, location_id, category', 'integer'],
			['date_start', 'safe']
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

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getLocation()
	{
		return $this->hasOne('Location', ['id' => 'location_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getUser()
	{
		return $this->hasOne('User', ['id' => 'user_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getTimeTableScheduledDetails()
	{
		return $this->hasMany('TimeTableScheduledDetail', ['time_table_scheduled_id' => 'id']);
	}
}
