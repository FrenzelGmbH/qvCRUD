<?php

class m130505_131012_users extends \yii\db\Migration
{
	public function up()
	{
		$this->createTable('tbl_user',array(
				'id'          => 'INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
				'username'    => 'VARCHAR(100) NOT NULL',
				'password'    => 'VARCHAR(255) NOT NULL',
				'email'       => 'VARCHAR(255) NOT NULL',
				'role'        => 'INTEGER UNSIGNED NOT NULL',
				'prename'     => 'VARCHAR(255)',
				'name'        => 'VARCHAR(255)',
				'phone'       => 'VARCHAR(255)',
				'mobile'      => 'VARCHAR(255)',
				'fax'         => 'VARCHAR(255)',
				'messanger'   => 'VARCHAR(255)',
				'parent_user_id' => 'INTEGER UNSIGNED DEFAULT NULL',
				'backup_user_id' => 'INTEGER UNSIGNED DEFAULT NULL',
				'time_create' => 'INTEGER',
				'time_update' => 'INTEGER',
				'time_login'  => 'INTEGER',
		),'CHARACTER SET utf8 COLLATE utf8_bin ENGINE = InnoDB;');

		/**
		* Add all needed fields to tbl_user in one_site belongs to many users
		**/
		$this->addForeignKey('FK_parentuser_user','tbl_user','parent_user_id','tbl_user','id');
		$this->addForeignKey('FK_backup_user','tbl_user','backup_user_id','tbl_user','id');
	}

	public function down()
	{
		//drop FKs
		$this->dropForeignKey('FK_parentuser_user','tbl_user');
		$this->dropForeignKey('FK_backup_user','tbl_user');

		$this->dropTable('tbl_user');
	}
}
