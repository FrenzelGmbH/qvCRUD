<?php

namespace app\modules\timetrack\models;

/**
 * This is the model class for table "tbl_time_table_scheduled_detail".
 *
 * @property integer $id
 * @property integer $time_table_scheduled_id
 * @property integer $odd_even
 * @property string $time_start
 * @property string $time_end
 * @property integer $day_of_week
 *
 * @property TimeTableScheduled $timeTableScheduled
 */
class TimeTableScheduledDetailed extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'tbl_time_table_scheduled_detail';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['time_table_scheduled_id, odd_even, day_of_week', 'integer'],
			['time_start, time_end', 'safe']
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

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getTimeTableScheduled()
	{
		return $this->hasOne('TimeTableScheduled', ['id' => 'time_table_scheduled_id']);
	}
}
