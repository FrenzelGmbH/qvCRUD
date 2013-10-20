<?php

namespace app\modules\workflow\models;

use \Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

use \PHPMailer;

class Workflow extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%workflow}}';
    }

    //all application workflow stati
    const ACTION_APPROVE  = 'approve';
    const ACTION_REJECT   = 'reject';
    const ACTION_CHANGE   = 'change';
    const ACTION_ESCALATE = 'escalate';
    const ACTION_ARCHIVE  = 'archive';
    const ACTION_BOOK     = 'book';

    //all appication stati
    const STATUS_CREATED   = 'created';
    const STATUS_REJECTED  = 'rejected';
    const STATUS_REQUESTED = 'requested';
    const STATUS_CORRECTED = 'corrected';
    const STATUS_APPROVED  = 'approved';
    const STATUS_PENDING   = 'pending';
    const STATUS_BOOKED    = 'booked';
    
    const STATUS_DRAFT     = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_ARCHIVED  = 'archived';
    
    public static $statusse = array(
        self::STATUS_CREATED   =>'created',
        self::STATUS_REQUESTED =>'requested',
        self::STATUS_REJECTED  =>'rejected',
        self::STATUS_CORRECTED =>'corrected',
        self::STATUS_APPROVED  =>'approved',
        self::STATUS_PENDING   =>'pending',
        self::STATUS_BOOKED    =>'booked',
        self::STATUS_DRAFT     => 'draft',
        self::STATUS_PUBLISHED => 'published',
        self::STATUS_ARCHIVED  => 'archived',
    );

    public static function getStatusOptions()
    {
        return self::$statusse;
    }

    /**
     * Returns a string representation of the model's categories
     *
     * @return string The category of this model as a string
     */
    public function getStatusAsString($status)
    {
        $options = self::getStatusOptions();
        return isset($options[$status]) ? $options[$status] : '';
    }

    /**
    * @var const MODULE_TIMETABLE
    * is used for managing workflow
    */
    const MODULE_TIMETABLE   = 1;
    const MODULE_PRINTREPORT = 2;
    const MODULE_CMS         = 3;
    const MODULE_BLOG        = 4;
    const MODULE_TASKS       = 5;
    const MODULE_REVISION    = 6;
    const MODULE_HOLIDAY     = 7;

    public static $appmodules = array(
        self::MODULE_TIMETABLE   => 'timetrack/timetrack',
        self::MODULE_PRINTREPORT => 'printreport',
        self::MODULE_CMS         => 'pages/page',
        self::MODULE_BLOG        => 'post',
        self::MODULE_TASKS       => 'tasks/default',
        self::MODULE_REVISION    => 'revision/default',
        self::MODULE_HOLIDAY     => 'timetrack/timetrack',
    );

    public static $appinternals = array(
        self::MODULE_TIMETABLE => array('table'=>'tbl_time_table','field'=>'category'),
        self::MODULE_HOLIDAY => array('table'=>'tbl_time_table','field'=>'category'),
        self::MODULE_TASKS => array('table'=>'tbl_task','field'=>'content'),
    );

    public static function getModuleOptions(){
        return self::$appmodules;
    }

    public static function getModuleInternals(){
        return self::$appinternals;
    }

    /**
     * Returns a string representation of the model's module table name
     *
     * @return string The module table name of this workflow as a string
     */
    public static function getModuleAsString($id=NULL)
    {
        $options = self::getModuleOptions();
        if(!is_null($id))
            return isset($options[$id]) ? $options[$id] : '';
        return 'Unknown';
    }

    /**
     * Returns a string representation of the model's module table name
     *
     * @return string The module table name of this workflow as a string
     */
    public static function getModuleAsController($id)
    {
        $options = self::getModuleOptions();
        if(isset($options[$id])){ 
            $cleanme = $options[$id];
            //cut table shortcut
            $cleanme = str_replace(Yii::$app->db->tablePrefix, '', $cleanme);
            $cleanme = implode('',explode('_',$cleanme));
            return $cleanme;
        }
        return 'site';
    }

    /**
    * @return model \app\models\user User
    */
    public function getPreviousUser(){
        return $this->hasOne('\app\models\User', array('id' => 'previous_user_id'));
    }

    /**
    * @return model \app\models\user User
    */
    public function getNextUser(){
        return $this->hasOne('\app\models\User', array('id' => 'next_user_id'));
    }
 
    /**
     * @return array primary key of the table
     **/     
    public static function primaryKey()
    {
        return array('id');
    }

 	public function rules()
	{
	    return array(
            array('previous_user_id','required'),
	        array('date_create','string'),	        
	    );
	}

    /**
    * before we save the record, we will md5 the password
    */
    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->date_create = Date('Y-m-d H:i:s');
            }
            else {
                //on update
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'               => 'ID',
            'previous_user_id' => Yii::t('app','From User'),
            'next_user_id'     => Yii::t('app','Acting User'),
            'module'           => Yii::t('app','Module'),
            'wf_table'         => Yii::t('app','Module DB'),
            'wf_id'            => Yii::t('app','Module RecId'),
            'status_from'      => Yii::t('app','Old State'),
            'status_to'        => Yii::t('app','Current State'),
            'actions_next'     => Yii::t('app','Allowed Actions'),
            'date_create'      => Yii::t('app','Created at'),
		);        
    }

    public static function getAdapterForUserWorkflow() {
        $userId = Yii::$app->user->identity->id;
        return static::find()->where('(next_user_id = '.$userId.') AND (id IN (SELECT max(id) FROM tbl_workflow GROUP BY wf_table, wf_id))')
            ->OrderBy('date_create DESC');
        //return static::find()->where('(previous_user_id = '.$userId.' OR next_user_id = '.$userId.') AND (id IN (SELECT max(id) FROM tbl_workflow GROUP BY wf_table, wf_id))')
    }

    /**
     * this function trys to return the related content for the module
     * @return [type] [description]
     */
    public function getRelatedContent()
    {
        $allInternals = $this->getModuleInternals();

        //return $allInternals[$this->wf_table]['field'];
        
        if($allInternals[$this->wf_table]['table']<>''){
            $query = new \yii\db\Query;

            // Define query
            $query->select($allInternals[$this->wf_table]['field'])
                ->from($allInternals[$this->wf_table]['table'])
                ->where(array('id'=>$this->wf_id))
                ->limit(1);

            // Create a command. You can get the actual SQL using $command->sql
            $command = $query->createCommand();
            // Execute command
            $rows = $command->queryOne();

            return $rows[$allInternals[$this->wf_table]['field']];
            //return $allInternals;
        }else{
            return 'no details available...';
        }
    }

    /**
    * @return array splitted actions that are allowed from next
    */
    public function getNextActions(){
        $allowed_actions = array();        
        $allowed_actions = explode(',',$this->actions_next);
        if(Yii::$app->user->isAdmin){
            $allowed_actions[]='update';
        }
        $allowed_actions[]='view';
        return $allowed_actions;
    }

    /**
     * will insert a record into a new workflow
     * @param integer $module  module table by const from workflow model
     * @param integer $id      fk of the table refrenced by param one
     * @param integer $status  new status for the workflow item
     * @param integer $user_id the user id, the next workflow step is related to
     * @param string $actions the allowed next actions for the workflow
     *
     * @return object $NWflow the new created workflow object
     */
    public static function addRecordIntoWorkflow($module,$id,$status=self::STATUS_CREATED,$user_id=NULL,$actions=NULL){
        //grep the modules as array
        $options = self::getModuleOptions();

        $NWflow = new self;
        $NWflow->previous_user_id = Yii::$app->user->identity->id;
        $NWflow->next_user_id = is_null($user_id)?$NWflow->previous_user_id:$user_id;
        $NWflow->module = $options[(int)$module];
        $NWflow->wf_table = $module;
        $NWflow->wf_id = $id;
        $NWflow->status_from = self::STATUS_CREATED;
        $NWflow->status_to = $status;        
        $NWflow->actions_next = is_array($actions)?implode(',',$actions):'';
        if($NWflow->save())
            return $NWflow;
        return NULL;
    }

    /**
    * @return query to get the workflow logs for a special entry
    * @param integer the id of the module - workflow table - see static params from Workflow Model
    * @param integer the primarey key value of the record within the linked table
    */
    public static function getAdapterForWorkflowLog($module,$id)
    {
        return static::find()->where('wf_table = '.$module.' AND wf_id = '.$id)
            ->OrderBy('date_create DESC');
    }

    /**
    * @return query to get the number of workflow logs for a special entry
    * @param integer the id of the module - workflow table - see static params from Workflow Model
    * @param integer the primarey key value of the record within the linked table
    */
    public static function getAdapterForWorkflowLogCount($module,$id)
    {
        return static::find()->where('wf_table = '.$module.' AND wf_id = '.$id)->Count();
    }

    /**
     * will send an email for the workflow step
     * @param  [type] $reason   what should the next user do
     * @param  [type] $workflow the corresponding workflow item
     * @param  [type] $link     the deep link to the website
     * @return [type]           returns nothing if mail is send
     */
    public static function sendWorkflowMail($reason,$workflow,$link = NULL){
        $mail = new PHPMailer;

        $mail->IsSMTP();                                                // Set mailer to use SMTP
        $mail->Host       = Yii::$app->params['mailconfig']['Host'];    // Specify main and backup server
        $mail->SMTPAuth   = true;                                       // Enable SMTP authentication
        $mail->Username   = Yii::$app->params['mailconfig']['Username'];// SMTP username
        $mail->Password   = Yii::$app->params['mailconfig']['Password'];// SMTP password
        //$mail->SMTPSecure = 'tls';                                        // Enable encryption, 'ssl' also accepted

        $mail->From = 'myplace-info@lichtbruecken.at';
        $mail->FromName = Yii::$app->params['mailerAlias'];
        $mail->AddAddress($workflow->NextUser->email);  // Add a recipient
        $mail->AddCc($workflow->PreviousUser->email); //Add carbon copy
        $mail->AddAddress(Yii::$app->params['adminEmail'], 'Administrator');  // Add a recipient
        
        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->IsHTML(true);                                  // Set email format to HTML

        $mail->Subject = $reason;        

        $wfModul = Workflow::getModuleAsString($workflow->wf_table);

        $mail->Body = <<<MSGBODY

Sehr geehrteR BenutzerIn,<br>

auf dem Modul <b>$wfModul</b> mit Bezug auf die Id: {$workflow->wf_id} wird eine neue Handlung gefordert:

<p>$reason</p>

Bitte folgen sie dem <a href="$link"> folgenden Link </a> und setzten Sie die dort gewuenschten Schritte.<br>

Vielen Dank Ihr Informationsdienst.
MSGBODY;

        $mail->AltBody = htmlentities($mail->Body);

        if(!$mail->Send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           exit;
        }
    }
}
