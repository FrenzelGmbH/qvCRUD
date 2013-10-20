<?php

namespace app\modules\qlikview\qvdocs\models;

/**
 * This is the model class for table "tbl_qvdocs".
 *
 * @property integer $id
 * @property string $qvDocumentName
 * @property string $qvPath
 * @property string $status
 * @property integer $time_create
 */
class qvdocs extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'tbl_qvdocs';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['qvDocumentName', 'required'],
			['time_create', 'integer'],
			['qvDocumentName', 'string', 'max' => 100],
			['qvPath', 'string', 'max' => 180],
			['status', 'string', 'max' => 255]
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
}
