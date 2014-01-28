<?php
use yii\db\Schema;
use yii\db\Migration;
use yii\helpers\Security;

/**
 * Миграция создаёт все таблицы БД модуля [[Users]]
 * Создаются 2 таблицы:
 * - {{%users}} => в которой хранится основная информация о пользователе.
 * - {{%user_email}} => в которой хранятся временные E-mail записи. Таблица используется для смены E-mail адреса.
 */
class m130704_174427_create_users_tbl extends Migration
{
	public function safeUp()
	{
		// Настройки MySql таблицы
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

		// Таблица пользователей
		$this->createTable('{{%users}}', [
			'id' => Schema::TYPE_PK,
			'username' => Schema::TYPE_STRING . '(30) NOT NULL',
			'email' => Schema::TYPE_STRING . '(100) NOT NULL',
			'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
			'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
			'name' => Schema::TYPE_STRING . '(50) NOT NULL',
			'surname' => Schema::TYPE_STRING . '(50) NOT NULL',
			'avatar_url' => Schema::TYPE_STRING . '(64) NOT NULL',
			'role_id' => 'tinyint NOT NULL DEFAULT 0',
			'status_id' => 'tinyint(4) NOT NULL DEFAULT 0',
			'create_time' => Schema::TYPE_INTEGER . ' NOT NULL',
			'update_time' => Schema::TYPE_INTEGER . ' NOT NULL'
		], $tableOptions);

		// Индексы
		$this->createIndex('username', '{{%users}}', 'username', true);
		$this->createIndex('email', '{{%users}}', 'email', true);
		$this->createIndex('role_id', '{{%users}}', 'role_id');
		$this->createIndex('status_id', '{{%users}}', 'status_id');
		$this->createIndex('create_time', '{{%users}}', 'create_time');

		// Таблица для смены e-mail адресов пользователя
		$this->createTable('{{%user_email}}', [
			'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
			'email' => Schema::TYPE_STRING . '(100) NOT NULL',
			'token' => Schema::TYPE_STRING . '(32) NOT NULL',
			'valide_time' => Schema::TYPE_INTEGER . ' NOT NULL',
			'PRIMARY KEY (`user_id`, `token`)'
		], $tableOptions);

		// Индексы
		$this->createIndex('valide_time', '{{%user_email}}', 'valide_time');

		// Связи
		$this->addForeignKey('FK_user_email_user', '{{%user_email}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');

		// Добавляем администратора
		$this->execute($this->getSql());
	}

	public function safeDown()
	{
		$this->dropTable('{{%user_email}}');
		$this->dropTable('{{%users}}');
	}

	private function getSql()
	{
		$time = time();
		$password_hash = Security::generatePasswordHash('admin12345');
		$auth_key = Security::generateRandomKey();
		return "INSERT INTO {{%users}} (`username`, `email`, `name`, `surname`, `avatar_url`, `password_hash`, `auth_key`, `role_id`, `status_id`, `create_time`, `update_time`) VALUES ('admin', 'admin@demo.com', 'Администрация', 'Сайта', '', '$password_hash', '$auth_key', 2, 1, $time, $time)";
	}
}