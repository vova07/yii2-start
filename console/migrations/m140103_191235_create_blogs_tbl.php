<?php
use yii\db\Migration;
use yii\db\Schema;

/**
 * Миграция создаёт все таблицы БД модуля [[Blogs]]
 * Создаются 2 таблицы:
 * - {{%posts}} - в которой хранится информация о постах
 * - {{%post_categories}} - в которой хранится информация о категориях постов
 */
class m140103_191235_create_blogs_tbl extends Migration
{
	public function safeUp()
	{
		// Настройки MySql таблицы
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

		// Таблица постов
		$this->createTable('{{%posts}}', [
			'id' => Schema::TYPE_PK,
			'author_id' => Schema::TYPE_INTEGER . ' NOT NULL',
			'title' => Schema::TYPE_STRING . '(100) NOT NULL',
			'alias' => Schema::TYPE_STRING . '(100) NOT NULL',
			'snippet' => Schema::TYPE_TEXT . ' NOT NULL',
			'content' => 'longtext NOT NULL',
			'image_url' => Schema::TYPE_STRING . '(64) NOT NULL',
			'preview_url' => Schema::TYPE_STRING . '(64) NOT NULL',
			'fixed' => 'tinyint(1) NOT NULL DEFAULT 0',
			'status_id' => 'tinyint(2) NOT NULL DEFAULT 0',
			'views' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
			'create_time' => Schema::TYPE_INTEGER . ' NOT NULL',
			'update_time' => Schema::TYPE_INTEGER . ' NOT NULL',
		], $tableOptions);

		// Индексы
		$this->createIndex('author_id', '{{%posts}}', 'author_id');
		$this->createIndex('fixed', '{{%posts}}', 'fixed');
		$this->createIndex('status_id', '{{%posts}}', 'status_id');
		$this->createIndex('views', '{{%posts}}', 'views');
		$this->createIndex('create_time', '{{%posts}}', 'create_time');
		$this->createIndex('update_time', '{{%posts}}', 'update_time');

		// Связи
		$this->addForeignKey('FK_post_author', '{{%posts}}', 'author_id', '{{%users}}', 'id', 'CASCADE', 'CASCADE');

		// Таблица категорий постов
		$this->createTable('{{%posts_categories}}', [
			'id' => Schema::TYPE_PK,
			'title' => Schema::TYPE_STRING . '(100) NOT NULL',
			'alias' => Schema::TYPE_STRING . '(100) NOT NULL',
			'ordering' => Schema::TYPE_INTEGER . ' NOT NULL',
			'status_id' => 'tinyint(1) NOT NULL DEFAULT 1',
		], $tableOptions);

		// Индексы
		$this->createIndex('alias', '{{%posts_categories}}', 'alias');
		$this->createIndex('ordering', '{{%posts_categories}}', 'ordering');
		$this->createIndex('status_id', '{{%posts_categories}}', 'status_id');

		// Создаём вспомогательную таблицу post-category
		$this->createTable('{{%post_category}}', [
            'post_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'PRIMARY KEY (`post_id`, `category_id`)'
        ], $tableOptions);

        // Связи
        $this->addForeignKey('FK_post_category_post', '{{%post_category}}', 'post_id', '{{%posts}}', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('FK_post_category_category', '{{%post_category}}', 'category_id', '{{%posts_categories}}', 'id', 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
		$this->dropTable('{{%post_category}}');
		$this->dropTable('{{%posts}}');
		$this->dropTable('{{%posts_categories}}');
	}
}