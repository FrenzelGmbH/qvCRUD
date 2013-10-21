<?php

namespace app\modules\timetrack\models;

use \Yii;
use \DateTime;

use app\modules\workflow\models\Workflow;
use app\modules\revision\models\Revision;

/**
 * This is the model class for table "tbl_time_table".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $time_start
 * @property string $time_end
 * @property string $date_start
 * @property string $date_end
 * @property string $date_create
 * @property string $category
 * @property double $double_value
 * @property string $status
 * @property string $date_delete
 *
 * @property User $user
 */
class Timetable extends \yii\db\ActiveRecord
{

		const CAT_HOLIDAY                = 1;
    const CAT_ILLNESS                = 2;
    const CAT_TIMETRACK              = 3;
    const CAT_WEDDING                = 4;
    const CAT_MOVEMENT               = 5;
    const CAT_OTHER                  = 6;
    const CAT_HOLIDAY_BOOKING        = 7;
    const CAT_HOLIDAY_BOOKING_START  = 8;
    const CAT_HOLIDAY_BOOKING_UPDATE = 9;
    const CAT_HOLIDAY_BOOKING_EXIT   = 10;
    const CAT_HOLIDAY_BOOKING_ALIQUOTE   = 11;
    
    public static $categories = array(
        self::CAT_HOLIDAY                  =>'Holiday',
        self::CAT_ILLNESS                  =>'Illness',
        self::CAT_TIMETRACK                =>'Timetrack',
        self::CAT_WEDDING                  =>'Wedding',
        self::CAT_MOVEMENT                 =>'Moving',
        self::CAT_OTHER                    =>'Other',
        self::CAT_HOLIDAY_BOOKING          =>'Holiday Booking',
        self::CAT_HOLIDAY_BOOKING_START    =>'Holiday Booking Start',
        self::CAT_HOLIDAY_BOOKING_UPDATE   =>'Holiday Booking Update',
        self::CAT_HOLIDAY_BOOKING_EXIT     =>'Holiday Booking Exit',
        self::CAT_HOLIDAY_BOOKING_ALIQUOTE =>'Holiday Booking Aliquotation',
    );

    public static function getCategoryOptions()
    {
        return self::$categories;
    }

    /**
     * Returns a string representation of the model's categories
     * @return string The category of this model as a string
     */
    public function getCategoryAsString()
    {
        $options = self::getCategoryOptions();
        return isset($options[$this->category]) ? Yii::t('app',$options[$this->category]) : '';
    }

    /**
     * Returns a colorstring representation of the model's categories
     * @return string The category of this model as a string
     */
    public function getCategoryAsColor()
    {
        return isset(Yii::$app->params[$this->category]['color']) ? Yii::$app->params[$this->category]['color'] : '#B2DFEE';
    }


    /**
     * scope for personal entries only
     * @param ActiveQuery $query
     */
    public static function personal($query)
    {
        $query->andWhere('user_id = '.Yii::$app->user->identity->id);
    }

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'tbl_time_table';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return array(
			array('user_id', 'integer'),
			array('time_start, time_end, date_start, date_end', 'safe'), //no date_create, date_deleted
			array('user_id, date_start', 'required'),
			array('double_value', 'number'),
			array('category', 'string', 'max' => 100),
			array('status', 'string', 'max' => 255),
      array('date_delete','string')            
		);
	}

	/**
    * before we save the record, we will md5 the password
    */
    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
            if ($insert) {
                switch ($this->category) {
                    case self::CAT_TIMETRACK:
                        //$this->user_id = Yii::$app->user->identity->id;
                        $this->status = Workflow::STATUS_BOOKED;                    
                        break;
                    case self::CAT_ILLNESS:
                        //$this->user_id = Yii::$app->user->identity->id;                    
                        break;                    
                    default:
                        break;
                }                
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
    * dependend on the category individual workflows are beeing started
    * maybe those need to be defined in the workflow model, not sure about
    * but needs to be discussed later on
    */

    public function afterSave($insert){
        parent::afterSave($insert);
        if ($insert) {
            switch($this->category){
                case self::CAT_TIMETRACK:
                    $this->double_value = $this->getCalculatedHoursDouble();
                    $this->status = Workflow::STATUS_BOOKED;
                    $this->save();            
                    break;                
                case self::CAT_HOLIDAY:
                    //As its a new holiday request, we will enter the next steps
                    /*$Wf = new Workflow();
                    $Wf->previous_user_id = Yii::$app->user->identity->id;
                    $Wf->next_user_id = Yii::$app->user->identity->parent_user_id;
                    $Wf->module = 'holiday';
                    $Wf->wf_table = Workflow::MODULE_TIMETABLE;
                    $Wf->wf_id = $this->id;
                    $Wf->status_to = Workflow::STATUS_REQUESTED;
                    $Wf->date_create = Date('Y-m-d H:i:s');
                    $Wf->actions_next = Workflow::ACTION_REJECT.','.Workflow::ACTION_APPROVE.','.Workflow::ACTION_CHANGE;
                    $Wf->save();*/
                    break;
                case self::CAT_ILLNESS:
                    //As its a new holiday request, we will enter the next steps
                    /*$Wf = new Workflow();
                    $Wf->previous_user_id = Yii::$app->user->identity->id;
                    $Wf->next_user_id = Yii::$app->user->identity->parent_user_id;
                    $Wf->module = 'illness';
                    $Wf->wf_table = Workflow::MODULE_TIMETABLE;
                    $Wf->wf_id = $this->id;
                    $Wf->status_to = Workflow::STATUS_REQUESTED;
                    $Wf->date_create = Date('Y-m-d H:i:s');
                    $Wf->actions_next = Workflow::ACTION_APPROVE;
                    $Wf->save();*/
                    break;
                default:
                    break;
            }      
        }
        $revision = new Revision();
        return  $this->addRevision($revision);
    }

    /**
     * Adds a revision entry to the record
     * This method will set status and pages_id of the comment accordingly.
     * @param revision model the revision to be added
     * @return boolean whether the comment is saved successfully
     */
    public function addRevision($revision)
    {
        $revision->status=Workflow::STATUS_BOOKED;
        $revision->revision_table=Workflow::MODULE_TIMETABLE;
        $revision->revision_id=$this->id;
        $revision->content = 'The TimeTable entry with #'.$this->id.' has been updated to status '.$this->status.' by user #'.$this->user_id.' at time: #'.time().' the new category is #'.$this->category.' and the new value #'.$this->double_value;
        return $revision->save();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
				'id'                     => 'ID',
				'time_start'             => Yii::t('app','Start Time'),
				'time_end'               => Yii::t('app','End Time'),
	      'date_start'             => Yii::t('app','Start Date'),
	      'date_end'               => Yii::t('app','End Date'),
	      'date_create' 					 => 'Date Create',
	      'user_id'                => Yii::t('app','User'),
	      'category'               => Yii::t('app','Type'),
	      'status'                 => Yii::t('app','Workflow State'),
	      'date_create'            => Yii::t('app','Created at'),
	      'double_value' 					 => 'Double Value',
	      'date_delete' 					 => 'Date Delete',
			);        
    }

	/**
   * will temporarily hold the module to be worked on
   * @var integer
   */
  public $_module = NULL;

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getUser()
	{
		return $this->hasOne('\app\models\User', array('id' => 'user_id'));
	}

	/**
  * @return object query for all timetrack entries by logged in user
  * @param integer userId hardcoded to logged in user
  */ 
  public static function getAdapterForTimetrack() {
      $userId = Yii::$app->user->identity->id;
      return static::find()->where('user_id = '.$userId.' AND category = '.self::CAT_TIMETRACK.' AND date_delete IS NULL');
                           //->orderBy('date_end DESC');
  }

  /**
  * @return object query for all holiday entries by logged in user
  * @param integer userId hardcoded to logged in user
  * @param integer status pls check out workflow model to see all possible stati
  */
  public static function getAdapterForHoliday($status=Workflow::STATUS_REQUESTED) {
      $userId = Yii::$app->user->identity->id;
      return static::find()->where('user_id = '.$userId.' AND category = '.self::CAT_HOLIDAY.' AND status = "'.$status.'"'.' AND date_delete IS NULL')
                           ->orderBy('date_create DESC');
  }

  /**
  * @return object query for the employee sheet in holiday/employeesheet entries by logged in user
  * @param integer userId of the viewed user
  */
  public static function getAdapterForEmployeeSheet($userId = NULL) {
      return static::find()->where('user_id = '.$userId.' AND category IN ('.self::CAT_HOLIDAY.','.self::CAT_ILLNESS.')'.' AND date_delete IS NULL')
                           ->orderBy('date_create DESC');
  }

  /**
  * @return h:m hours and minutes between two dates
  */
  public function getCalculatedHours(){
      $date1    = new DateTime($this->time_start);
      $date2    = new DateTime($this->time_end);
      $interval = date_diff($date1,$date2);
      return $interval->format('%h:%I');
  }

  /**
  * @return h:m hours and minutes as double between two dates
  */
  public function getCalculatedHoursDouble(){
      $date1     = new DateTime($this->time_start);
      $date2     = new DateTime($this->time_end);
      $interval  = date_diff($date1,$date2);
      $fullhours = (double)$interval->format('%h');
      $minutes   = (double)1/60*$interval->format('%I');
      return $fullhours+$minutes;
  }

  /**
  * This will create the initial booking for a specified date
  * @param object model containing the needed values
  * @var userId the user for which the opening is booked
  * @var start_date the date for which the booking will be saved
  * @var double_value the hours/days to be booked into the record
  * @var category if the employee has hourly model its 1 if day then 8
  */
  public static function createInitialBooking($model = NULL)
  {
      $MEntry = new self;
      $MEntry->user_id = (int)$model->user_id;
      $MEntry->date_start = date('Y-m-d',strtotime($model->date_start));
      $MEntry->date_end = date('Y-m-d',strtotime($model->date_start));
      $MEntry->time_start = NULL;
      $MEntry->time_end = NULL;
      $MEntry->status = (string)Workflow::STATUS_BOOKED;
      $MEntry->category = (string)self::CAT_HOLIDAY_BOOKING_START;
      $MEntry->double_value = (int)$model->category * (double)$model->double_value;
      return $MEntry->save();
  }

  /**
  * This will create the initial booking for a specified date
  * @param object model containing the needed values
  * @var userId the user for which the opening is booked
  * @var start_date the date for which the booking will be saved
  * @var double_value the hours/days to be booked into the record
  * @var category if the employee has hourly model its 1 if day then 8
  */
  public static function createExitBooking($model = NULL)
  {
      $MEntry = new self;
      $MEntry->user_id = (int)$model->user_id;
      $MEntry->date_start = date('Y-m-d',strtotime($model->date_start));
      $MEntry->date_end = date('Y-m-d',strtotime($model->date_start));
      $MEntry->time_start = NULL;
      $MEntry->time_end = NULL;
      $MEntry->status = (string)Workflow::STATUS_BOOKED;
      $MEntry->category = (string)self::CAT_HOLIDAY_BOOKING_EXIT;
      $MEntry->double_value = (int)$model->category * (double)$model->double_value*-1;
      return $MEntry->save();
  }
      
  /**
  * This will create the initial booking for a specified date
  * @param object model containing the needed values
  * @var userId the user for which the opening is booked
  * @var start_date the date for which the booking will be saved
  * @var double_value the hours/days to be booked into the record
  * @var category if the employee has hourly model its 1 if day then 8
  */
  public static function createAlliquotationBooking($model = NULL)
  {
      $MEntry = new self;
      $MEntry->user_id = (int)$model->user_id;
      $MEntry->date_start = date('Y-m-d',strtotime($model->date_start));
      $MEntry->date_end = date('Y-m-d',strtotime($model->date_start));
      $MEntry->time_start = NULL;
      $MEntry->time_end = NULL;
      $MEntry->status = (string)Workflow::STATUS_BOOKED;
      $MEntry->category = (string)self::CAT_HOLIDAY_BOOKING_ALIQUOTE;
      $MEntry->double_value = (int)$model->category * (double)$model->double_value*-1;
      return $MEntry->save();
  }

  /**
  * This will create the yearly refresh booking for a specified date
  * @param object model containing the needed values
  * @var userId the user for which the opening is booked
  * @var start_date the date for which the booking will be saved
  * @var double_value the hours/days to be booked into the record
  * @var category if the employee has hourly model its 1 if day then 8
  */
  public static function addHolidayUpdateBooking($model = NULL)
  {
      $MEntry = new self;
      $MEntry->user_id = (int)$model->user_id;
      $MEntry->date_start = date('Y-m-d',strtotime($model->date_start));
      $MEntry->date_end = date('Y-m-d',strtotime($model->date_start));
      $MEntry->time_start = NULL;
      $MEntry->time_end = NULL;
      $MEntry->status = (string)Workflow::STATUS_BOOKED;
      $MEntry->category = (string)self::CAT_HOLIDAY_BOOKING_UPDATE;
      $MEntry->double_value = (int)$model->category * (double)$model->double_value;
      return $MEntry->save();
  }
  

  /**
  * This will create a booking for a specified date
  * @param userId the user for which the opening is booked
  * @param start_date the date for which the booking will be saved
  * @param end_date the date for which the booking will be saved
  * @param category if the employee has hourly model its 1 if day then 8
  */
  public static function book($userId,$date_start,$date_end,$category)
  {
      try
      {
          $interval   = new DateInterval('P1D');        
          $date_start = new DateTime($date_start.' 00:00:00');
          $date_end   = new DateTime($date_end.' 24:00:00');
          $periods    = new DatePeriod($date_start, $interval, $date_end);
          
          $LatestSchedule = \app\models\TimeTableScheduled::findLatestWorkTime($userId);
          $UserCountry = strtolower(\app\models\User::find($userId)->Location->country);

          foreach($periods AS $periode){
              //first check for holiday
              if($isHoliday=true){
                  //check for odd or even week
                  $OddEven = (int)$periode->format('W')%2==0?0:1;
                  $DayOfWeek = (int)$periode->format('w');
                  $MDayValue = \app\models\TimeTableScheduledDetail::loadScheduledDetailEntry($LatestSchedule->id,$DayOfWeek,$OddEven);
                  
                  if(($MDayValue->CalculatedHoursDouble>0 OR $category==self::CAT_ILLNESS) AND !self::freierTag($periode->format('d'),$periode->format('m'),$periode->format('Y'),$UserCountry))
                  {
                      //we need to get the matching
                      $MEntry = new self();
                      $MEntry->user_id      = (int)$userId;
                      $MEntry->date_start   = $periode->format('Y-m-d');
                      $MEntry->date_end     = $periode->format('Y-m-d');
                      $MEntry->time_start   = $MDayValue->time_start;
                      $MEntry->time_end     = $MDayValue->time_end;
                      $MEntry->status       = (string)Workflow::STATUS_BOOKED;
                      $MEntry->category     = $category;

                      $double_value = (double)0;
                      if($LatestSchedule->category == 1 AND $category==self::CAT_HOLIDAY_BOOKING)
                          $double_value = $MDayValue->CalculatedHoursDouble*-1;
                      elseif($LatestSchedule->category == 8 AND $category==self::CAT_HOLIDAY_BOOKING)
                          $double_value = -8;

                      $MEntry->double_value = $double_value;
                      $MEntry->save();        
                  }
              }
          }
          return true;
      }
      catch(Exception $e)
      {
          return $e->getMessage();
      }
  }

  /**
  * This will return the latest workflow state for the relevant timetable entry
  *
  * @param integer module id, as defined in workflow model
  * @param integer pk of record in module table
  * @return array latest actions form workflow to timetable
  */
  public function getNextWorkflowActions(){
      return explode(',',Workflow::find()->select('actions_next')
                             ->where('wf_table = '.$this->_module.' AND wf_id = '.$this->id)
                             ->orderBy('date_create DESC')
                             ->one()->actions_next);
  }

  /**
  * Will return the initial booking for the mentioned periode
  * @param userId for whom you wanna get the initial booking
  * @param year e.g. 2013
  */
  public static function getInitialBooking($userId = NULL, $year = '2013')
  {
      $date1 = new DateTime($year.Yii::$app->params['gbFiscalYearStart']);
      return static::find()->select('SUM(double_value) AS double_value')
                      ->where('user_id='.$userId.' AND (date_start BETWEEN "'.$date1->format('Y-m-d H-i-s').'" AND "'.$date1->modify('+1 year')->format('Y-m-d H-i-s').'") AND category = '.self::CAT_HOLIDAY_BOOKING_START.' AND date_delete IS NULL')
                      ->groupBy('user_id')
                      ->one();
  }

  /**
  * Will return the current salod for the mentioned periode and user
  * @param userId for whom you wanna get the initial booking
  * @param year e.g. 2013
  */
  public static function getCurrentSaldo($userId = NULL, $year = '2013')
  {
      $date1 = new DateTime($year.Yii::$app->params['gbFiscalYearStart']);
      return static::find()->select('SUM(double_value) AS double_value')
                      ->where('user_id='.$userId.' AND (date_start BETWEEN "'.$date1->format('Y-m-d H-i-s').'" AND "'.$date1->modify('+1 year')->format('Y-m-d H-i-s').'") AND category IN ('.self::CAT_HOLIDAY_BOOKING_START.', '.self::CAT_HOLIDAY_BOOKING.','.self::CAT_HOLIDAY_BOOKING_UPDATE.','.self::CAT_HOLIDAY_BOOKING_EXIT.','.self::CAT_HOLIDAY_BOOKING_ALIQUOTE.')'.' AND date_delete IS NULL')
                      ->groupBy('user_id')
                      ->one();
  }

  /**
  * Will return the current holiday bookings for the mentioned periode and user
  * @param userId for whom you wanna get the initial booking
  * @param year e.g. 2013
  */
  public static function getUserBookings($userId = NULL, $year = '2013')
  {
      $date1 = new DateTime($year.Yii::$app->params['gbFiscalYearStart']);
      return static::find()->where('user_id='.$userId.' AND (date_start BETWEEN "'.$date1->format('Y-m-d H-i-s').'" AND "'.$date1->modify('+1 year')->format('Y-m-d H-i-s').'") AND category IN ('.self::CAT_HOLIDAY_BOOKING_START.', '.self::CAT_HOLIDAY_BOOKING.', '.self::CAT_HOLIDAY.', '.self::CAT_ILLNESS.','.self::CAT_MOVEMENT.','.self::CAT_WEDDING.','.self::CAT_OTHER.','.self::CAT_HOLIDAY_BOOKING_UPDATE.','.self::CAT_HOLIDAY_BOOKING_EXIT.','.self::CAT_HOLIDAY_BOOKING_ALIQUOTE.')'.' AND date_delete IS NULL')
                      ->orderBy('date_start ASC')
                      ->all();
  }

  /**
  * Will return the current bookings for the mentioned periode and user
  * @param integer userId for whom you wanna get bookings for
  * @param integer category
  * @param timestamp startdate 
  */
  public static function getCalendarBookings($userId = NULL, $category = self::CAT_TIMETRACK,$startdate = null)
  {
      if(!is_NULL($startdate)){
        $date1 = new DateTime();
        $date1->setTimestamp($startdate);
        //$date1->modify('-1 month');
      }
      else
        $date1 = new DateTime('today -1 month');
      return static::find()->where('user_id='.$userId.' AND (date_start BETWEEN "'.$date1->format('Y-m-d H-i-s').'" AND "'.$date1->modify('+1 month')->format('Y-m-d H-i-s').'") AND category IN ('.$category.')'.' AND date_delete IS NULL')
                      ->orderBy('date_start ASC')
                      ->all();
  }


  /**
  * Will return the current holidayBOOKED bookings for the mentioned periode and user
  * @param userId for whom you wanna get the initial booking
  * @param year e.g. 2013
  */
  public static function getHolidayBookings($userId = NULL, $year = '2013')
  {
      $date1 = new DateTime($year.Yii::$app->params['gbFiscalYearStart']);
      return static::find()->select('SUM(double_value) AS double_value')
                      ->where('user_id='.$userId.' AND (date_start BETWEEN "'.$date1->format('Y-m-d H-i-s').'" AND "'.$date1->modify('+1 year')->format('Y-m-d H-i-s').'") AND category IN ('.self::CAT_HOLIDAY_BOOKING.')'.' AND date_delete IS NULL')
                      ->orderBy('date_start ASC')
                      ->groupBy('user_id')
                      ->one();
  }

  /**
  * Will return the current stats for the mentioned periode and user
  * @param userId for whom you wanna get the initial booking
  * @param year e.g. 2013
  */
  public static function getUserStats($userId = NULL, $year = '2013')
  {
      $date1 = new DateTime($year.Yii::$app->params['gbFiscalYearStart']);
      return static::find()->select('monthname(date_start) AS status, SUM(double_value) AS double_value')
                      ->where('user_id='.$userId.' AND (date_start BETWEEN "'.$date1->format('Y-m-d H-i-s').'" AND "'.$date1->modify('+1 year')->format('Y-m-d H-i-s').'") AND category IN ('.self::CAT_HOLIDAY_BOOKING.', '.self::CAT_ILLNESS.','.self::CAT_MOVEMENT.','.self::CAT_WEDDING.','.self::CAT_OTHER.','.self::CAT_HOLIDAY_BOOKING_UPDATE.','.self::CAT_HOLIDAY_BOOKING_EXIT.','.self::CAT_HOLIDAY_BOOKING_ALIQUOTE.')'.' AND date_delete IS NULL') //', '.self::CAT_HOLIDAY. removed as missleading
                      ->groupBy('user_id, monthname(date_start)')
                      ->orderBy('date_start')
                      ->All();
  }

  /**
  * Will return the current stats for the mentioned periode and user
  * @param day int
  * @param month int
  * @param year e.g. 2013
  * @param country int
  */
  private static function freierTag($tag, $monat, $jahr, $country='at') {

      $feiertage = array();

     // Parameter in richtiges Format bringen
     if(strlen($tag) == 1) {
        $tag = "0$tag";
     }
     if(strlen($monat) == 1) {
        $monat = "0$monat";
     }

     // Feste Feiertage werden nach dem Schema ddmm eingetragen
     $feiertage['de'][] = "0101"; // Neujahrstag
     $feiertage['de'][] = "0105"; // Tag der Arbeit
     //$feiertage['de'][] = "1508"; // Maria Himmerlfahrt
     $feiertage['de'][] = "0310"; // Tag der Deutschen Einheit
     //$feiertage['de'][] = "0111"; // Allerheiligen
     $feiertage['de'][] = "2512"; // Erster Weihnachtstag
     $feiertage['de'][] = "2612"; // Zweiter Weihnachtstag
     
     $feiertage['at'][] = "0101"; // Neujahrstag
     $feiertage['at'][] = "0105"; // Tag der Arbeit
     $feiertage['at'][] = "2610"; // Nationalfeiertag
     $feiertage['at'][] = "1508"; // Maria Himmerlfahrt
     $feiertage['at'][] = "0111"; // Allerheiligen
     $feiertage['at'][] = "2512"; // Erster Weihnachtstag
     $feiertage['at'][] = "2612"; // Zweiter Weihnachtstag

     $feiertage['ch'][] = "0101"; // Neujahrstag
     $feiertage['ch'][] = "0105"; // Tag der Arbeit
     $feiertage['ch'][] = "1508"; // Maria Himmerlfahrt
     $feiertage['ch'][] = "0111"; // Allerheiligen
     $feiertage['ch'][] = "2512"; // Erster Weihnachtstag
     $feiertage['ch'][] = "2612"; // Zweiter Weihnachtstag

     // Bewegliche Feiertage berechnen
     $tage = 60 * 60 * 24;
     $ostersonntag = easter_date($jahr);

     $feiertage['de'][] = date("dm", $ostersonntag - 2 * $tage);  // Karfreitag
     $feiertage['de'][] = date("dm", $ostersonntag + 1 * $tage);  // Ostermontag
     $feiertage['de'][] = date("dm", $ostersonntag + 39 * $tage); // Himmelfahrt
     $feiertage['de'][] = date("dm", $ostersonntag + 50 * $tage); // Pfingstmontag
     //$feiertage['de'][] = date("dm", $ostersonntag + 60 * $tage); // Frohnleichnahm

     $feiertage['at'][] = date("dm", $ostersonntag - 2 * $tage);  // Karfreitag
     $feiertage['at'][] = date("dm", $ostersonntag + 1 * $tage);  // Ostermontag
     $feiertage['at'][] = date("dm", $ostersonntag + 39 * $tage); // Himmelfahrt
     $feiertage['at'][] = date("dm", $ostersonntag + 50 * $tage); // Pfingstmontag
     $feiertage['at'][] = date("dm", $ostersonntag + 60 * $tage); // Frohnleichnahm

     $feiertage['ch'][] = date("dm", $ostersonntag - 2 * $tage);  // Karfreitag
     $feiertage['ch'][] = date("dm", $ostersonntag + 1 * $tage);  // Ostermontag
     $feiertage['ch'][] = date("dm", $ostersonntag + 39 * $tage); // Himmelfahrt
     $feiertage['ch'][] = date("dm", $ostersonntag + 50 * $tage); // Pfingstmontag
     $feiertage['ch'][] = date("dm", $ostersonntag + 60 * $tage); // Frohnleichnahm

     // Prüfen, ob Feiertag
     $code = $tag.$monat;
     $compare = $feiertage[$country];
     if(in_array($code, $compare)) {
        return true;
     } else {
        return false;
     }
    }
}
