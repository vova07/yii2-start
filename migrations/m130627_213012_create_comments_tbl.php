<?php
use yii\db\Schema;

class m130627_213012_create_comments_tbl extends \yii\db\Migration
{
	public function up()
	{
		// MySQL-specific table options. Adjust if you plan working with another DBMS
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

		$this->createTable('tbl_comment', array(
			'id' => Schema::TYPE_PK,
			'author_id' => Schema::TYPE_INTEGER.' NOT NULL',
			'model_id' => Schema::TYPE_INTEGER.' NOT NULL',
			'content' => Schema::TYPE_TEXT.' NOT NULL',

			'status' => 'tinyint NOT NULL DEFAULT 1',
			'create_time' => Schema::TYPE_INTEGER.' NOT NULL',
			'update_time' => Schema::TYPE_INTEGER.' NOT NULL',
		), $tableOptions);

		$this->createIndex('author_id', 'tbl_comment', 'author_id');
		$this->addForeignKey('FK_comment_author', 'tbl_comment', 'author_id', 'tbl_user', 'id', 'CASCADE', 'RESTRICT');
		$this->addForeignKey('FK_comment_model_id', 'tbl_comment', 'model_id', 'tbl_blog', 'id', 'CASCADE', 'RESTRICT');
	}

	public function down()
	{
		$this->dropTable('tbl_comment');
	}
}
