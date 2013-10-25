<?php

namespace app\models;

use yii\web\IdentityInterface;

use Ccovey\LdapAuth\LdapAuthServiceProvider;

/**
 * This is the model class for table "tbl_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $role
 * @property string $prename
 * @property string $name
 * @property string $phone
 * @property string $mobile
 * @property string $fax
 * @property string $messanger
 * @property integer $parent_user_id
 * @property integer $backup_user_id
 * @property integer $time_create
 * @property integer $time_update
 * @property integer $time_login
 * @property string $date_entry
 * @property string $date_exit
 * @property string $no_employee
 *
 * @property User $backupUser
 * @property User $parentUser
 * @property ChildUsers[] $users
 */
class UserLDAP extends \yii\db\ActiveRecord implements IdentityInterface
{
    private $errorCode = TRUE;

		const ROLE_SYSADMIN = 0;
    const ROLE_ADMIN    = 1;
    const ROLE_USER_ADVANCED = 2;    
    const ROLE_USER     = 3;

    public static $roles = array(
			self::ROLE_SYSADMIN      => 'Sysadmin',
			self::ROLE_ADMIN         => 'Admin',
			self::ROLE_USER_ADVANCED => 'Advanced User',
			self::ROLE_USER          => 'User',
    );

    public static function getRoleOptions()
    {
        return self::$roles;
    }

    /**
     * Returns a string representation of the model's role
     *
     * @return string The role of this model as a string
     */
    public function getRoleAsString()
    {
    	$options = self::getRoleOptions();
    	return isset($options[$this->role]) ? $options[$this->role] : '';
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array(
            array('username, password, email, role', 'required'),
            array('role, parent_user_id, backup_user_id, time_create, time_update, time_login', 'integer'),
            array('date_entry, date_exit', 'safe'),
            array('username', 'string', 'max' => 100),
            array('password, email, prename, name, phone, mobile, fax, messanger', 'string', 'max' => 255),
            array('no_employee', 'string', 'max' => 25)
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'role' => 'Role',
            'prename' => 'Prename',
            'name' => 'Name',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'fax' => 'Fax',
            'messanger' => 'Messanger',
            'parent_user_id' => 'Parent User ID',
            'backup_user_id' => 'Backup User ID',
            'time_create' => 'Time Create',
            'time_update' => 'Time Update',
            'time_login' => 'Time Login',
            'date_entry' => 'Date Entry',
            'date_exit' => 'Date Exit',
            'no_employee' => 'No Employee',
        );
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function get()
    {
        return $this->hasMany('User', array('author_id' => 'id'));
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getBackupUser()
    {
        return $this->hasOne('User', array('id' => 'backup_user_id'));
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getParentUser()
    {
        return $this->hasOne('User', array('id' => 'parent_user_id'));
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getChildUsers()
    {
        return $this->hasMany('User', array('parent_user_id' => 'id'));
    }
  
  /**
	* before we save the record, we will md5 the password
	*/
	public function beforeSave($insert){
		if (parent::beforeSave($insert)) {
			if ($insert) {
				if(!empty($this->password)) 
				{
					//$this->password_hash = SecurityHelper::generatePasswordHash($this->password);
					$this->password = md5($this->password);
				}
				$this->backup_user_id==0?$this->backup_user_id = NULL:'';
				$this->parent_user_id==0?$this->parent_user_id = NULL:'';
			}else{
				$this->parent_user_id==0?$this->parent_user_id = NULL:'';
				$this->backup_user_id==0?$this->backup_user_id = NULL:'';
			}
			return true;
		}
	}

	/**
	 * Returns all possible lists to choose from as an associative array
	 *
	 * @return array The array of lists
	 */
	public static function getListOptions()
	{
		$returnme = array();
		$returnme[] = array('0'=>'NONE AVAILABLE! Gibts net!');
		$returnme[] = ArrayHelper::map(User::findBySQL('SELECT id, CONCAT(name,", ",prename) AS name FROM tbl_user WHERE date_exit IS NULL ORDER BY name')->all(),'id','name');
		return $returnme;
	}

	public static function searchByString($query){
		return static::find()->where("UPPER(name) LIKE '%".strtoupper($query)."%' OR UPPER(prename) LIKE '%".strtoupper($query)."%'")->all();
	}

	public static function getAdapterForHoliday() {
        return static::find()
        		->select('id, name, prename, orgunit_id, location_id')
        		->orderBy('name ASC');
    }

    /**
	 * all functions needed for identity
	 */

  public static function findIdentity($id)
	{
		return static::find($id);
	}

	public static function findByUsername($username)
	{
		$user = static::find()->where('username=:username', array('username'=>$username))->one();
		if ($user) {
			return new self($user);
		}
		else
			return null;
	}

	public function getId()
	{
		return $this->id;
	}	

	public function getAuthKey()
	{
		return $this->authKey;
	}

	public function validateAuthKey($authKey)
	{
		return prent::validateAuthKey($authKey);
	}

	/**
	* Checks if the given password is correct.
	* @param string the password to be validated
	* @return boolean whether the password is valid
	*/
	public function validatePassword($password)
	{
    try
    {
      $SearchFor=$this->username;               //What string do you want to find?
      $SearchField="samaccountname";   //In what Active Directory field do you want to search for the string?

      $LDAPFieldsToFind = array("cn", "givenname", "samaccountname", "mail");
      $filter="($SearchField=$SearchFor*)"; //Wildcard is * Remove it if you want an exact match

      //new ldap logic
      $settings = \Yii::$app->params['ldapSettings'];
      $options = \Yii::$app->params['ldap'];
      $dc_string = "DC=".implode(",",$settings['domain_controllers']);
      
      $connection = ldap_connect($options['host']) 
        or die("Could not connect to LDAP server.");
      ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION,3);
      ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
      
      if($connection){
        $bind = ldap_bind($connection,$settings['account_prefix'].$this->username,$password);
        if(!$bind){
          $this->addError('password', 'Incorrect username or password.');
          return false;
        }
        else{
          return true;
        }
      }
    }
    catch(Exception $e)
    {
      $this->addError('username', 'Incorrect username or password.');      
    }
    
    return FALSE; 
	}

}