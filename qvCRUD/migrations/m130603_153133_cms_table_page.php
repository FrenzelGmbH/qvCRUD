<?php

class m130603_153133_cms_table_page extends \yii\db\Migration
{
	public function up()
	{
		/**
		* For detailed information about design take a look at
		* @link CMS Design Using PHP and Jquery Packtpub.com
		*/

		$this->createTable('tbl_pages',array(
				'id'                        => 'INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'name'						=> 'TEXT',
				'body'						=> 'MEDIUMTEXT',
				'parent_pages_id'           => 'INTEGER UNSIGNED DEFAULT 0',
				'ord' 		                => 'INTEGER DEFAULT 0',
				'time_create'             	=> 'INTEGER',
				'time_update'             	=> 'INTEGER',
				'special'              		=> 'BIGINT(20) DEFAULT NULL',
				'title'						=> 'TEXT',
				'template'					=> 'TEXT',
				'category'					=> 'VARCHAR(64) DEFAULT NULL',
				'tags'          			=> 'TEXT',
				'description'          		=> 'TEXT',
				'date_associated'			=> 'DATE DEFAULT NULL',
				'vars'						=> 'TEXT',
				'status'					=> 'VARCHAR(255) NOT NULL DEFAULT "created"',				
		),'CHARACTER SET utf8 COLLATE utf8_bin ENGINE = InnoDB;');
	}

	public function down()
	{
		$this->dropTable('tbl_pages');
	}
}
