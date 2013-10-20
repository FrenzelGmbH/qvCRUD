<?php

class m131020_120241_qvdocs extends \yii\db\Migration
{
	public function up()
	{
    $this->createTable('tbl_qvdocs',array(
        'id'              => 'INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
        'qvDocumentName'  => 'VARCHAR(100) NOT NULL',
        'qvPath'          => 'VARCHAR(180)',
        'status'          => 'VARCHAR(255) NOT NULL DEFAULT "created"',
        'time_create'     => 'INTEGER',
    ),'CHARACTER SET utf8 COLLATE utf8_bin ENGINE = InnoDB;');
	}

	public function down()
	{
		$this->dropTable('tbl_qvdocs');
	}
}
