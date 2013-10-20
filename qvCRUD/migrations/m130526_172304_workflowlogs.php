<?php

class m130526_172304_workflowlogs extends \yii\db\Migration
{
	public function up()
	{
		$this->createTable('tbl_workflow',array(
				'id'                        => 'INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'previous_user_id'          => 'INTEGER UNSIGNED NOT NULL',
				'next_user_id'          	=> 'INTEGER UNSIGNED DEFAULT NULL',
				'module'					=> 'VARCHAR(255) NOT NULL',
				'wf_table'					=> 'INTEGER UNSIGNED DEFAULT NULL',
				'wf_id'						=> 'INTEGER UNSIGNED DEFAULT NULL',
				'status_from'				=> 'VARCHAR(255) NOT NULL DEFAULT "created"',
				'status_to'					=> 'VARCHAR(255) NOT NULL DEFAULT ""',
				'actions_next'				=> 'VARCHAR(255) NOT NULL DEFAULT ""',
				'date_create'             => 'DATETIME NOT NULL',				
		),'CHARACTER SET utf8 COLLATE utf8_bin ENGINE = InnoDB;');

		/**
		* Add all needed fields to tbl_user in one_site belongs to many users
		**/
		$this->addForeignKey('FK_wf_user_previous','tbl_workflow','previous_user_id','tbl_user','id');
		$this->addForeignKey('FK_wf_user_next','tbl_workflow','next_user_id','tbl_user','id');

	}

	public function down()
	{
		/**
		* drop all fks
		**/
		$this->dropForeignKey('FK_wf_user_previous','tbl_workflow');
		$this->dropForeignKey('FK_wf_user_next','tbl_workflow');

		$this->dropTable('tbl_workflow');
	}
}
