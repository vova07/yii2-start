<?php
use yii\db\Schema;

class m130626_203236_create_blogs_tbl extends \yii\db\Migration
{
	public function up()
	{
		// MySQL-specific table options. Adjust if you plan working with another DBMS
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

		$this->createTable('tbl_blog', array(
			'id' => Schema::TYPE_PK,
			'author_id' => Schema::TYPE_INTEGER.' NOT NULL',
			'title' => Schema::TYPE_STRING.' NOT NULL',
			'content' => 'longtext NOT NULL',

			'status' => 'tinyint NOT NULL DEFAULT 1',
			'create_time' => Schema::TYPE_INTEGER.' NOT NULL',
			'update_time' => Schema::TYPE_INTEGER.' NOT NULL',
		), $tableOptions);

		$this->createIndex('author_id', 'tbl_blog', 'author_id');
		$this->addForeignKey('FK_blog_author', 'tbl_blog', 'author_id', 'tbl_user', 'id', 'CASCADE', 'RESTRICT');
	}

	public function down()
	{
		$this->dropTable('tbl_blog');
	}
}
