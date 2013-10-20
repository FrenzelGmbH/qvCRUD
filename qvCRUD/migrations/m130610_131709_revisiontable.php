<?php

class m130610_131709_revisiontable extends \yii\db\Migration
{
	public function up()
	{
		$this->createTable('tbl_revision',array(
				'id'                        => 'INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'content'					=> 'TEXT NULL',
				'status'					=> 'VARCHAR(255) NOT NULL DEFAULT "created"',
				'creator_id'		        => 'INTEGER UNSIGNED NOT NULL',
				'time_create'             	=> 'INTEGER',
				'revision_table'			=> 'INTEGER UNSIGNED DEFAULT NULL',
				'revision_id'				=> 'INTEGER UNSIGNED DEFAULT NULL',
		),'CHARACTER SET utf8 COLLATE utf8_bin ENGINE = InnoDB;');

		//add the related fk's
		$this->addForeignKey('FK_revision_creator','tbl_revision','creator_id','tbl_user','id');
	}

	public function down()
	{
		//drop the related FKS
		$this->dropForeignKey('FK_revision_creator','tbl_revision');

		$this->dropTable('tbl_revision');
	}
}
