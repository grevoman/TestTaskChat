<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 */
class m210114_065049_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%message}}',
            [
                'id'           => $this->primaryKey(),
                'text'         => $this->text()->notNull()->comment('Текст сообщения'),
                'is_incorrect' => $this->boolean()->notNull()->defaultValue(false)->comment('Признак некорректного сообщения'),
                'created_by'   => $this->integer()->comment('Id пользователя'),
                'created_at'   => $this->dateTime()->null()->defaultValue(null)->comment('Дата создания'),
                'updated_at'   => $this->dateTime()->null()->defaultValue(null)->comment('Дата изменения'),
            ]
        );

        $this->createIndex('is_incorrect', '{{%message}}', ['is_incorrect']);

        $this->addForeignKey(
            'fk-message-user',
            '{{%message}}',
            'created_by',
            '{{%user}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-message-user', '{{%message}}');
        $this->dropTable('{{%message}}');
    }
}
