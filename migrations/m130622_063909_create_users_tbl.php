<?php
use yii\db\Schema;

class m130622_063909_create_users_tbl extends \yii\db\Migration
{
	public function up()
	{
		// MySQL-specific table options. Adjust if you plan working with another DBMS
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

		$this->createTable('tbl_user', array(
			'id' => Schema::TYPE_PK,
			'username' => Schema::TYPE_STRING.' NOT NULL',
			'password_hash' => Schema::TYPE_STRING.' NOT NULL',
			'activkey' => Schema::TYPE_STRING.' NOT NULL',
			'email' => Schema::TYPE_STRING.' NOT NULL',
			'role' => 'tinyint NOT NULL DEFAULT 0',

			'status' => 'tinyint NOT NULL DEFAULT 0',
			'create_time' => Schema::TYPE_INTEGER.' NOT NULL',
			'update_time' => Schema::TYPE_INTEGER.' NOT NULL',
		), $tableOptions);

		$this->createIndex('username', 'tbl_user', 'username');
		$this->createIndex('email', 'tbl_user', 'email');
	}

	public function down()
	{
		$this->dropTable('tbl_user');
	}
}
