<?php

class m130915_173629_motocycles extends \yii\db\Migration
{
	public function up()
  {
    $this->createTable('tbl_moto',array(
        'id'            => 'INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
        'Bezeichnung'   => 'VARCHAR(100) NOT NULL',
        'Farbe'         => 'VARCHAR(100)',
        'Kilometer'     => 'FLOAT DEFAULT 0',
        'Preis'         => 'FLOAT DEFAULT 0',
        'Leistung'      => 'FLOAT DEFAULT 0',
        'Hubraum'       => 'FLOAT DEFAULT 0',
        'Erstzulassung' => 'VARCHAR(10) NOT NULL',
        'Beschreibung'  => 'TEXT',        
        'Ausstattung'   => 'TEXT',
        'Antriebsart'   => 'VARCHAR(100)',
        'Getriebe'      => 'VARCHAR(100)',          
        'deleted'       => 'TINYINT(1) NOT NULL DEFAULT 0',
    ),'CHARACTER SET utf8 COLLATE utf8_bin ENGINE = InnoDB;');

    $this->createTable('tbl_article',array(
        'id'          => 'INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
        'number'      => 'VARCHAR(100) NOT NULL',
        'newnumber'   => 'VARCHAR(100) NULL',
        'description' => 'VARCHAR(255) NOT NULL',
        'price'       => 'FLOAT UNSIGNED NOT NULL',
    ),'CHARACTER SET utf8 COLLATE utf8_bin ENGINE = InnoDB;');
  }

  public function down()
  {
    $this->dropTable("tbl_moto");
    $this->dropTable('tbl_article');
  }
}
