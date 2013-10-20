<?php

namespace app\commands;

use \Yii;
use \yii\console\Exception;
use \yii\console\Controller;
use \yii\db\Connection;
use \yii\helpers\Html;

use PHPMailer;

use \ZipArchive;

/**
 * @author Philipp Frenzel <philipp@frenzel.net>
 * Used for seeding the database with initial data. Usually used during development
 */
class CronDbBackupController extends Controller
{

	/**
	* @var Connection|string the DB connection object or the application
	* component ID of the DB connection.
	*/
	public $db = 'db';

	/**
	* @var constraints|string the DB connection object or the application
	* component ID of the DB connection.
	*/
	private $constraints;

	/**
	* @var string the default command action.
	*/
	public $defaultAction = 'dbbackup';

	private $basePath = NULL;

	/**
	 * Initializes this application component.
	 */
	public function init()
	{
		parent::init();
		if($this->basePath===null)
			$this->basePath=Yii::getAlias('@app');
	}

	/**
	* This method is invoked right before an action is to be executed (after all possible filters.)
	* It checks the existence of the [[migrationPath]].
	* @param \yii\base\Action $action the action to be executed.
	* @return boolean whether the action should continue to be executed.
	* @throws Exception if the migration directory does not exist.
	*/
	public function beforeAction($action)
	{
		if (parent::beforeAction($action)) {
			if (is_string($this->db)) {
				$this->db = Yii::$app->getComponent($this->db);
			}
			if (!$this->db instanceof Connection) {
				throw new Exception("The 'db' option must refer to the application component ID of a DB connection.");
			}
			$version = Yii::getVersion();
			echo "MPIntranet Daily Backup Tool (based on Yii v.{$version})\n";
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This command is used when typing yiic seed. Demo data should be created here
	 */
	public function actionDbbackup()
	{
		$sql = $this->getDump();

		$directory = $this->basePath."/dbbackup/";
		$filename = "dbB".strtotime('now');

        $filesource = $directory.'sql/'.$filename.'.sql';

		if($sql!='')
			file_put_contents($filesource, $sql);

		$ZipName = $filename.'.zip';

		$zip = new ZipArchive;
		$res = $zip->open($directory.$ZipName, ZipArchive::CREATE);
		$zip->addFile($filesource, $filename.'.sql');
		if($zip->close())
			unlink($filesource);
	    
        $this->sendBackupMail('Backup','SQL Generated',$directory.$ZipName);

        unlink($directory.$ZipName);

		exit;
	}

	private function sendBackupMail($reason,$sql,$filesource){
		$mail = new PHPMailer;

		$mail->IsSMTP();                                      			// Set mailer to use SMTP
		$mail->Host       = Yii::$app->params['mailconfig']['Host'];  	// Specify main and backup server
		$mail->SMTPAuth   = true;                               		// Enable SMTP authentication
		$mail->Username   = Yii::$app->params['mailconfig']['Username'];// SMTP username
		$mail->Password   = Yii::$app->params['mailconfig']['Password'];// SMTP password
		//$mail->SMTPSecure = 'tls';                            			// Enable encryption, 'ssl' also accepted

		$mail->From = 'myplace-info@lichtbruecken.at';
		$mail->FromName = Yii::$app->params['mailerAlias'];
		$mail->AddAddress(Yii::$app->params['adminEmail'], 'Administrator');  // Add a recipient
		
		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		$mail->IsHTML(false);                                  // Set email format to HTML

		$mail->Subject = $reason;
		$mail->Body    = $sql;
		$mail->AltBody = $sql;

        $mail->AddAttachment($filesource);

		if(!$mail->Send()) {
		   echo 'Message could not be sent.';
		   echo 'Mailer Error: ' . $mail->ErrorInfo;
		   exit;
		}
	}


    /**
     * Dump all tables
     * @param boolean $download - if the generated data is to be sent to browser 
     * @return file|strings 
     */
    public function getDump($download = FALSE)
    {
            ob_start();
            foreach($this->getTables() as $key=>$value)
                    $this->dumpTable($value);
            $result = $this->setHeader();
            $result.= ob_get_contents();
            $result.= $this->getConstraints();
            $result.= $this->setFooter();
            ob_end_clean();
            if($download){
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Cache-Control: no-cache");
                header("Pragma: no-cache");
                header("Content-type:application/sql");
                header("Content-Disposition:attachment;filename=downloaded.sql");
            } 
            return $result;
    }

    /**
     * Generate constraints to all tables
     * @return string 
     */
    private function getConstraints()
    {
        $sql = "--\r\n-- Constraints for dumped tables\r\n--".PHP_EOL.PHP_EOL;
        $first = TRUE;
        foreach ($this->constraints as $key => $value) {
            if($first && count($value[0]) > 0){
                $sql  .= "--\r\n-- Constraints for table `$key`\r\n--".PHP_EOL.PHP_EOL;
                $sql .= "ALTER TABLE $key".PHP_EOL;
            }
            if(count($value[0]) > 0){
                for($i=0; $i<count($value[0]);$i++){
                    if(strpos($value[0][$i], 'CONSTRAINT') === FALSE)
                            $sql .= preg_replace('/(FOREIGN[\s]+KEY)/', "\tADD $1", $value[0][$i]);
                    else
                            $sql .= preg_replace('/(CONSTRAINT)/', "\tADD $1", $value[0][$i]);
                    if($i==count($value[0])-1)
                        $sql .= ";".PHP_EOL;
                    if($i<count($value[0])-1)
                        $sql .=PHP_EOL;
                }
            }
        }
        
        return $sql;            
    }

            
    /**
     * Set sql file header
     * @return string 
     */
    private function setHeader()
    {
        $header = PHP_EOL."--\n-- foreign key checks, autocomit and start a transaction\n--".PHP_EOL.PHP_EOL;
        $header.="SET FOREIGN_KEY_CHECKS=0;".PHP_EOL;
        $header.="SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";".PHP_EOL;
        $header.="SET AUTOCOMMIT=0;".PHP_EOL;
        $header.="START TRANSACTION;".PHP_EOL.PHP_EOL;
        $header.="/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;".PHP_EOL;
        $header.="/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;".PHP_EOL;
        $header.="/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;".PHP_EOL;
        $header.="/*!40101 SET NAMES utf8 */;".PHP_EOL;
        
        return $header;
    }
    
    
    /**
     * Set sql file footer
     * @return string 
     */
    private function setFooter()
    {
        $footer =PHP_EOL."SET FOREIGN_KEY_CHECKS=1;".PHP_EOL;
        $footer.="COMMIT;".PHP_EOL.PHP_EOL;
        $footer.="/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;".PHP_EOL;
        $footer.="/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;".PHP_EOL;
        $footer.="/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;".PHP_EOL;
        
        return $footer;
    }

            
    /**
     * Create table dump
     * @param $tableName
     * @return mixed
     */
    private function dumpTable($tableSchema)
    {
            $db = $this->db;
            $tableName = $tableSchema->name;

            echo PHP_EOL."--\n-- Structure for table `$tableName`\n--".PHP_EOL;
            echo PHP_EOL.'DROP TABLE IF EXISTS '.$tableSchema->name.';'.PHP_EOL.PHP_EOL;

            $q = $db->createCommand('SHOW CREATE TABLE '.$tableSchema->name.';')->queryOne();
            
            $create_query = $q['Create Table'];

            $pattern = '/CONSTRAINT.*|FOREIGN[\s]+KEY/';
            
            // constraints to $tablename
            preg_match_all($pattern, $create_query,$this->constraints[$tableSchema->name]);
            
            $create_query = explode(',',preg_replace($pattern, '', $create_query));
            
            for($i=0;$i<count($create_query)-1;$i++){
                echo ($i>=0 && $i<count($create_query)-2)?$create_query[$i].',':$create_query[$i];
            }
            echo "\n".trim($create_query[$i]).';'.PHP_EOL;
            
            $rows = $db->createCommand('SELECT * FROM '.$tableSchema->name.';')->queryAll();

                
            if(empty($rows))
                    return;

            echo PHP_EOL."--\n-- Data for table `$tableName`\n--".PHP_EOL.PHP_EOL;

            $attrs = array_map(array($db, 'quoteColumnName'), array_keys($rows[0]));
            echo 'INSERT INTO '.$tableSchema->name.''." (", implode(', ', $attrs), ') VALUES'.PHP_EOL;
            $i=0;
            $rowsCount = count($rows);
            foreach($rows AS $row)
            {
                    // Process row
                    foreach($row AS $key => $value)
                    {
                            if($value === null)
                                    $row[$key] = 'NULL';
                            else
                                    $row[$key] = $this->db->pdo->quote($value);
                    }

                    echo " (", implode(', ', $row), ')';
                    if($i<$rowsCount-1)
                            echo ',';
                    else
                            echo ';';
                    echo PHP_EOL;
                    $i++;
            }
            echo PHP_EOL;
            echo PHP_EOL;
    }
           
    /**
     * Get mysql tables list
     * @return array
     */
    private function getTables()
    {
            $db = $this->db;
            return $db->getSchema()->getTableSchemas();
    }

}
