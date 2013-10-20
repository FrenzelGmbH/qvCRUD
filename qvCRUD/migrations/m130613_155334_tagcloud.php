<?php

class m130613_155334_tagcloud extends \yii\db\Migration
{
	public function up()
	{
		$this->createTable('tbl_tag',array(
				'id'        => 'INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'name'      => 'VARCHAR(128) NOT NULL',
				'frequency' => 'INTEGER DEFAULT 1',
		),'CHARACTER SET utf8 COLLATE utf8_bin ENGINE = InnoDB;');
	}

	public function down()
	{
		$this->dropTable('tbl_tag');
	}
}
