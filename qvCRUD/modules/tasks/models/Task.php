<?php

namespace app\modules\tasks\models;

use Yii;
use yii\helpers\Html;
use app\modules\workflow\models\Workflow;

/**
 * This is the model class for table "tbl_task".
 *
 * @property integer $id
 * @property string $content
 * @property string $status
 * @property integer $creator_id
 * @property integer $time_create
 * @property integer $task_table
 * @property integer $task_id
 *
 * @property  $creator
 */
class Task extends \yii\db\ActiveRecord
{

	public $isNewRecord = false;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'tbl_task';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return array(
			array('content', 'string'),
			// not needed here, as it will be set in before Save! array('creator_id', 'required'),
			array('creator_id, time_create, task_table, task_id', 'integer'),
			array('status', 'string', 'max' => 255)
		);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => Yii::t('app','Content'),
			'status' => Yii::t('app','Status'),
			'creator_id' => Yii::t('app','Creator'),
			'time_create' => Yii::t('app','Created'),
			'task_table' => Yii::t('app','Module'),
			'task_id' => Yii::t('app','Module PK'),
		);
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($insert) {
				$this->creator_id  = Yii::$app->user->id;
				$this->time_create = time();
			}
			return true;
		} else {
			return false;
		}
	}

	/**
    * needs to be programmed later in detail, as we gain more knowledge about user needs!
    */

    public function afterSave($insert){
        if ($insert) {
        	$nextActions = Workflow::ACTION_REJECT.','.Workflow::ACTION_APPROVE.','.Workflow::ACTION_CHANGE;
        	Workflow::addRecordIntoWorkflow(Workflow::MODULE_TASKS,$this->id,Workflow::STATUS_PENDING,NULL,$nextActions);
        }
        return true;
    }

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getCreator()
	{
		return $this->hasOne('User', array('id' => 'creator_id'));
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getWorkflow()
	{
		return $this->hasOne('\app\modules\workflow\models\Workflow', array('wf_id' => 'id'))
					->where('wf_table = '.Workflow::MODULE_TASKS)
					->orderBy('date_create DESC');
	}

     /**
     * @param ActiveQuery $query
     * @param integer $age
     */
    public static function active($query)
    {
        $query->andWhere('status <> :status', array(':status' => Workflow::STATUS_ARCHIVED));
    }

	/**
    * @return query to get the workflow logs for a special entry
    * @param integer the id of the module - workflow table - see static params from Workflow Model
    * @param integer the primarey key value of the record within the linked table
    */
    public static function getAdapterForTasksLog($module,$id)
    {
        return static::find()->where('task_table = '.$module.' AND task_id = '.$id);
    }

    /**
    * @return query to get the number of workflow logs for a special entry
    * @param integer the id of the module - workflow table - see static params from Workflow Model
    * @param integer the primarey key value of the record within the linked table
    */
    public static function getAdapterForTaskLogCount($module,$id)
    {
        return static::find()->where('task_table = '.$module.' AND task_id = '.$id)->Count();
    }

    /**
    * @return string the URL that shows the detail of the pages
    */
    public static function getUrl($module,$id,$action='view')
    {      
      return Html::Url(array('/'.Workflow::getModuleAsController($module).'/'.$action,
        'id'=>$id,
      ));
    }
}
