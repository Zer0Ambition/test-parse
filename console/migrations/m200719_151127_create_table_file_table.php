<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%table_file}}`.
 */
class m200719_151127_create_table_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%table_file}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'web_filename' => $this->string(),
            'path' => $this->string(),
            'created_at' => $this->datetime(),
            'status' => $this->integer(),
            'user_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%table_file}}');
    }
}
