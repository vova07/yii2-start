<?php
use yii\db\Schema;
use yii\db\Migration;

/**
 * Миграция создаёт все таблицы БД модуля [[Comments]]
 * Создаётся 1 таблица:
 * - {{%comments}} - в которой хранится информация о комментариях.
 */
class m140110_194100_create_comments_tbl extends Migration
{
	public function safeUp()
	{
		// Настройки MySql таблицы
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

		// Таблица комментариев
		$this->createTable('{{%comments}}', array(
			'id' => Schema::TYPE_PK,
			'parent_id' => Schema::TYPE_INTEGER.' NOT NULL',
			'author_id' => Schema::TYPE_INTEGER.' NOT NULL',
			'post_id' => Schema::TYPE_INTEGER.' NOT NULL',
			'content' => Schema::TYPE_TEXT . ' NOT NULL',
			'status_id' => 'tinyint(3) NOT NULL DEFAULT 1',
			'create_time' => Schema::TYPE_INTEGER.' NOT NULL',
			'update_time' => Schema::TYPE_INTEGER.' NOT NULL',
		), $tableOptions);

		// Индексы
		$this->createIndex('parent_id', '{{%comments}}', 'parent_id');
		$this->createIndex('author_id', '{{%comments}}', 'author_id');
		$this->createIndex('post_id', '{{%comments}}', 'post_id');
		$this->createIndex('status_id', '{{%comments}}', 'status_id');
		$this->createIndex('create_time', '{{%comments}}', 'create_time');

		// Связи
		$this->addForeignKey('FK_comment_author', '{{%comments}}', 'author_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('FK_comment_post', '{{%comments}}', 'post_id', '{{%posts}}', 'id', 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
		$this->dropTable('{{%comments}}');
	}
}