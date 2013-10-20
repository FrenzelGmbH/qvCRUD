<?php

class m130830_100722_tasktable extends \yii\db\Migration
{
	public function up()
	{
		$this->createTable('tbl_task',array(
				'id'              => 'INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'content'					=> 'TEXT NULL',
				'status'					=> 'VARCHAR(255) NOT NULL DEFAULT "created"',
				'creator_id'		  => 'INTEGER UNSIGNED NOT NULL',
				'time_create'     => 'INTEGER',
				'task_table'			=> 'INTEGER UNSIGNED DEFAULT NULL',
				'task_id'					=> 'INTEGER UNSIGNED DEFAULT NULL',
		),'CHARACTER SET utf8 COLLATE utf8_bin ENGINE = InnoDB;');

		//add the related fk's
		$this->addForeignKey('FK_task_creator','tbl_task','creator_id','tbl_user','id');
	}

	public function down()
	{
		//drop the related FKS
		$this->dropForeignKey('FK_task_creator','tbl_task');

		$this->dropTable('tbl_task');
	}
}
