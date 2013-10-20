<?php

class m130522_060302_alter_user extends \yii\db\Migration
{
	public function up()
	{
		$this->addColumn('tbl_user','date_entry','DATE');
		$this->addColumn('tbl_user','date_exit','DATE DEFAULT NULL');
		$this->addColumn('tbl_user','no_employee','VARCHAR(25)');
	}

	public function down()
	{
		$this->dropColumn('tbl_user','date_entry');
		$this->dropColumn('tbl_user','date_exit');
		$this->dropColumn('tbl_user','no_employee');
	}
}
